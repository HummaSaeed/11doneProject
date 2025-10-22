<?php

namespace App\Http\Controllers\FrontEnd\Booking\Payment;

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

class FlutterwaveController extends Controller
{
  private $public_key, $secret_key;

  public function __construct()
  {
    $data = OnlineGateway::whereKeyword('flutterwave')->first();
    $flutterwaveData = json_decode($data->information, true);

    $this->public_key = $flutterwaveData['public_key'];
    $this->secret_key = $flutterwaveData['secret_key'];
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

      $customerPaid = intval($serviceData['service_ammount']);


      $allowedCurrencies = array('BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'MZN', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD');

      $currencyInfo = $this->getCurrencyInfo();


      // checking whether the base currency is allowed or not
      if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
        return Response::json(['error' => 'Invalid currency for flutterwave payment.'], 422);
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
        'customer_paid' => $customerPaid,
        'currencyText' => $currencyInfo->base_currency_text,
        'currencyTextPosition' => $currencyInfo->base_currency_text_position,
        'currencySymbol' => $currencyInfo->base_currency_symbol,
        'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
        'paymentMethod' => 'Flutterwave',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );

      $title = 'Service Booking';
      $notifyURL = route('frontend.service_booking.flutterwave.notify');

      $customerName = $request['name'];
      $customerEmail = $request['email'];
      $customerPhone = $request['phone'];


      // send payment to flutterwave for processing
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.flutterwave.com/v3/payments',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
          'tx_ref' => 'FLW | ' . time(),
          'amount' => $customerPaid,
          'currency' => $currencyInfo->base_currency_text,
          'redirect_url' => $notifyURL,
          'payment_options' => 'card,banktransfer',
          'customer' => [
            'email' => $customerEmail,
            'phone_number' => $customerPhone,
            'name' => $customerName
          ],
          'customizations' => [
            'title' => $title,
            'description' => $title . ' via Flutterwave.'
          ]
        ]),
        CURLOPT_HTTPHEADER => array(
          'authorization: Bearer ' . $this->secret_key,
          'content-type: application/json'
        )
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $responseData = json_decode($response, true);

      //curl end

      // put some data in session before redirect to flutterwave url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);

      // redirect to payment
      if ($responseData['status'] === 'success') {
        $redirectUrl = $responseData['data']['link'];

        // Return the redirect URL as part of the JSON response
        return Response::json(['redirectURL' => $redirectUrl]);
      } else {
        return redirect()->back()->with('error', 'Error: ' . $responseData['message'])->withInput();
      }
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }

  public function notify(Request $request)
  {
    // get the information from session

    $arrData = $request->session()->get('arrData');

    $urlInfo = $request->all();

    if ($urlInfo['status'] == 'successful') {
      $txId = $urlInfo['transaction_id'];

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txId}/verify",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
          'authorization: Bearer ' . $this->secret_key,
          'content-type: application/json'
        )
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $responseData = json_decode($response, true);
      if ($responseData['status'] === 'success') {
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
        $request->session()->forget('serviceData');
        return redirect()->route('frontend.services');
      } else {
        $request->session()->forget('arrData');
        $request->session()->forget('serviceData');
        return redirect()->route('frontend.service_booking.cancel');
      }
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('serviceData');

      return redirect()->route('frontend.service_booking.cancel');
    }
  }
}
