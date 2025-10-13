<?php

namespace App\Http\Controllers\Frontend\Booking\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\CheckLimitHelper;
use App\Http\Helpers\Instamojo;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffServiceHour;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Log;
use Response;

class InstamojoController extends Controller
{
  private $api;

  public function __construct()
  {

    $data = OnlineGateway::whereKeyword('instamojo')->first();
    $instamojoData = json_decode($data->information, true);

    if ($instamojoData['sandbox_status'] == 1) {
      $this->api = new Instamojo($instamojoData['key'], $instamojoData['token'], 'https://test.instamojo.com/api/1.1/');
    } else {
      $this->api = new Instamojo($instamojoData['key'], $instamojoData['token']);
    }
  }

  public function index(Request $request, $paymentFor)
  {
    if (Session::has('serviceData')) {
      $serviceData = Session::get('serviceData');
    } else {
      return redirect()->back()->with('error', 'Something went wrong');
    }
    //check membership expire date
    if ($serviceData['vendor_id'] != 0) {
      $expireDate = checkMembersipExpireDate($serviceData['vendor_id']);
      if ($request['bookingDate'] > $expireDate) {
        return redirect()->back()->with('error', 'Something went wrong');
      }
    }
    $countAppointment = CheckLimitHelper::countAppointment($serviceData['vendor_id']);
    if ($countAppointment > 0) {


      $currencyInfo = $this->getCurrencyInfo();
      // checking whether the currency is set to 'INR' or not
      if ($currencyInfo->base_currency_text !== 'INR') {
        return Response::json(['error' => 'Invalid currency for instamojo payment.'], 422);
      }

      $staff = Staff::find($request['staffId']);

      if ($staff->is_day == 1) {
        $staffHour = StaffServiceHour::find($request['serviceHourId']);
      } else {
        $staffHour = StaffGlobalHour::find($request['serviceHourId']);
      }


      $arrData = array(
        'zoom_status' => $serviceData['zoom_status'],
        'calender_status' => $serviceData['calendar_status'],
        'customer_name' => $request['name'],
        'customer_phone' => $request['phone'],
        'customer_email' => $request['email'],
        'customer_address' => $request['address'],
        'customer_zip_code' => $request['zip_code'],
        'customer_country' => $request['country'],
        'start_date' => $staffHour->start_time,
        'end_date' => $staffHour->end_time,
        'booking_date' => $request['bookingDate'],
        'service_hour_id' => $request['serviceHourId'],
        'staff_id' => $request['staffId'],
        'max_person' => $request['max_person'],
        'service_id' => $serviceData['service_id'],
        'user_id' => $request['user_id'],
        'vendor_id' => $serviceData['vendor_id'],
        'customer_paid' => $serviceData['service_ammount'],
        'currencyText' => $currencyInfo->base_currency_text,
        'currencyTextPosition' => $currencyInfo->base_currency_text_position,
        'currencySymbol' => $currencyInfo->base_currency_symbol,
        'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
        'paymentMethod' => 'Instamojo',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );


      $title = 'Service Booking';
      $notifyURL = route('frontend.service_booking.instamojo.notify');

      $customerName = $request['name'];
      $customerEmail = $request['email'];
      $customerPhone = $request['phone'];
      try {
        $response = $this->api->paymentRequestCreate(array(
          'purpose' => $title,
          'amount' => round($serviceData['service_ammount'], 2),
          'buyer_name' => $customerName,
          'email' => $customerEmail,
          'send_email' => false,
          'phone' => $customerPhone,
          'send_sms' => false,
          'redirect_url' => $notifyURL
        ));

        // put some data in session before redirect to instamojo url
        $request->session()->put('paymentFor', $paymentFor);
        $request->session()->put('arrData', $arrData);

        $request->session()->put('paymentId', $response['id']);

        // Return the redirect URL as part of the JSON response
        return Response::json(['redirectURL' => $response['longurl']]);
      } catch (Exception $e) {
        // Handling the exception
        $errorMessage = json_decode($e->getMessage(), true);

        // Accessing the individual error messages
        foreach ($errorMessage as $errorMessages) {
          foreach ($errorMessages as $errorMessage) {
            return Response::json(['error' => $errorMessage . "\n"], 422);
          }
        }
      }
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }

  public function notify(Request $request)
  {
    $arrData = $request->session()->get('arrData');
    $paymentId = $request->session()->get('paymentId');

    $urlInfo = $request->all();

    if ($urlInfo['payment_request_id'] == $paymentId) {
      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('paymentId');
      $request->session()->forget('serviceData');

      $bookingProcess = new ServicePaymentController();

      zoomCreate($arrData);
      calendarEventCreate($arrData);

      // store product order information in database
      $bookingInfo = $bookingProcess->storeData($arrData);

      $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
      $type = 'service_payment_approved';
      payemntStatusMail($type, $bookinId);


      Session::put('complete', 'payment_complete');
      Session::put('paymentInfo', $bookingInfo);
      return redirect()->route('frontend.services');
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('paymentId');
      $request->session()->forget('serviceData');

      return redirect()->route('frontend.service_booking.cancel');
    }
  }
}
