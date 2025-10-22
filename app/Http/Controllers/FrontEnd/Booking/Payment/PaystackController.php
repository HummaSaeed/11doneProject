<?php

namespace App\Http\Controllers\Frontend\Booking\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\CheckLimitHelper;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffServiceHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Response;

class PaystackController extends Controller
{
  private $api_key;

  public function __construct()
  {
    $data = OnlineGateway::whereKeyword('paystack')->first();
    $paystackData = json_decode($data->information, true);

    $this->api_key = $paystackData['key'];
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
      $customerpaid = intval($serviceData['service_ammount']);
      $currencyInfo = $this->getCurrencyInfo();

      // checking whether the currency is set to 'NGN' or not
      if ($currencyInfo->base_currency_text !== 'NGN') {
        return Response::json(['error' => 'Invalid currency for paystack payment.'], 422);
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
        'customer_paid' => $customerpaid,
        'currencyText' => $currencyInfo->base_currency_text,
        'currencyTextPosition' => $currencyInfo->base_currency_text_position,
        'currencySymbol' => $currencyInfo->base_currency_symbol,
        'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
        'paymentMethod' => 'Paystack',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );

      $notifyURL = route('frontend.service_booking.paystack.notify');

      $customerEmail = $request['email'];

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL            => 'https://api.paystack.co/transaction/initialize',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => json_encode([
          'amount'       => ($customerpaid * 100),
          'email'        => $customerEmail,
          'callback_url' => $notifyURL
        ]),
        CURLOPT_HTTPHEADER     => [
          'authorization: Bearer ' . $this->api_key,
          'content-type: application/json',
          'cache-control: no-cache'
        ]
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $transaction = json_decode($response, true);

      // put some data in session before redirect to paystack url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);

      if ($transaction['status'] == true) {
        return Response::json(['redirectURL' => $transaction['data']['authorization_url']]);
      } else {
        return redirect()->back()->with('error', 'Error: ' . $transaction['message'])->withInput();
      }
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }

  public function notify(Request $request)
  {
    $arrData = $request->session()->get('arrData');

    $urlInfo = $request->all();

    if ($urlInfo['trxref'] === $urlInfo['reference']) {
      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('serviceData');

      $bookingProcess = new ServicePaymentController();

      zoomCreate($arrData);
      calendarEventCreate($arrData);

      // store product order information in database
      $bookingInfo = $bookingProcess->storeData($arrData);

      $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
      $type = 'service_payment_approved';
      payemntStatusMail($type, $bookinId);


      $request->session()->forget('discount');

      //redirect url with billing session data

      Session::put('complete', 'payment_complete');
      Session::put('paymentInfo', $bookingInfo);
      return redirect()->route('frontend.services');
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('serviceData');

      return redirect()->route('frontend.service_booking.cancel');
    }
  }
}
