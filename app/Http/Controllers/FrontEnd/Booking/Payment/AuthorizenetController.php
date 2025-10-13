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
use Omnipay\Omnipay;
use Response;
use Session;

class AuthorizenetController extends Controller
{
  private $gateway;

  public function __construct()
  {
    $data = OnlineGateway::query()->whereKeyword('authorize.net')->first();
    $authorizeNetData = json_decode($data->information, true);
    $this->gateway = Omnipay::create('AuthorizeNetApi_Api');
    $this->gateway->setAuthName($authorizeNetData['login_id']);
    $this->gateway->setTransactionKey($authorizeNetData['transaction_key']);
    if ($authorizeNetData['sandbox_check'] == 1) {
      $this->gateway->setTestMode(true);
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

      $customerpaid = intval($serviceData['service_ammount']);

      $currencyInfo = $this->getCurrencyInfo();

      // checking whether the currency is set to 'INR' or not
      $allowedCurrencies = array('USD', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'NOK', 'PLN', 'SEK', 'AUD', 'NZD');
      $currencyInfo = $this->getCurrencyInfo();

      // checking whether the base currency is allowed or not
      if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
        return Response::json(['error' => 'Invalid currency for authorize.net payment.'], 422);
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
        'paymentMethod' => 'Authorize.net',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );
      // put some data in session before redirect to paytm url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);

      if ($request->filled('opaqueDataValue') && $request->filled('opaqueDataDescriptor')) {
        // generate a unique merchant site transaction ID
        $transactionId = rand(100000000, 999999999);

        $response = $this->gateway->authorize([
          'amount' => sprintf('%0.2f', $customerpaid),
          'currency' => $currencyInfo->base_currency_text,
          'transactionId' => $transactionId,
          'opaqueDataDescriptor' => $request->opaqueDataDescriptor,
          'opaqueDataValue' => $request->opaqueDataValue
        ])->send();

        if ($response->isSuccessful()) {
          $bookingProcess = new ServicePaymentController();
          zoomCreate($arrData);
          calendarEventCreate($arrData);

          // store product order information in database
          $bookingInfo = $bookingProcess->storeData($arrData);

          $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
          $type = 'service_payment_approved';
          payemntStatusMail($type, $bookinId);

          /**
           * success process will be go here
           * remove this session datas
           */
          $request->session()->forget('paymentFor');
          $request->session()->forget('arrData');
          $request->session()->forget('paymentId');
          $request->session()->forget('serviceData');

          Session::put('complete', 'payment_complete');
          Session::put('paymentInfo', $bookingInfo);
          return redirect()->route('frontend.services');
        } else {
          //cancel payment
          $request->session()->forget('paymentFor');
          $request->session()->forget('arrData');
          $request->session()->forget('paymentId');
          $request->session()->forget('serviceData');
          return redirect()->route('frontend.service_booking.cancel');
        }
      }
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }
}
