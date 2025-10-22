<?php

namespace App\Http\Controllers\FrontEnd\Booking\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\CheckLimitHelper;
use App\Models\BasicSettings\Basic;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffServiceHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Response;

class RazorpayController extends Controller
{
  private $key, $secret, $api;

  public function __construct()
  {
    $data = OnlineGateway::whereKeyword('razorpay')->first();
    $razorpayData = json_decode($data->information, true);

    $this->key = $razorpayData['key'];
    $this->secret = $razorpayData['secret'];

    $this->api = new Api($this->key, $this->secret);
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
      if ($currencyInfo->base_currency_text !== 'INR') {
        return Response::json(['error' => 'Invalid currency for razorpay payment.'], 422);
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
        'paymentMethod' => 'Razorpay',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );

      $title = 'Service Booking';
      $notifyURL = route('frontend.service_booking.razorpay.notify');

      // create order data
      $orderData = [
        'receipt'         => $title,
        'amount'          => ($customerpaid * 100),
        'currency'        => 'INR',
        'payment_capture' => 1 // auto capture
      ];

      $razorpayOrder = $this->api->order->create($orderData);

      $webInfo = Basic::select('website_title')->first();

      $customerName = $request['name'] . ' ' . $request['name'];
      $customerEmail = $request['email'];
      $customerPhone = $request['phone'];

      // create checkout data
      $checkoutData = [
        'key'               => $this->key,
        'amount'            => $orderData['amount'],
        'name'              => $webInfo->website_title,
        'description'       => $title . ' via Razorpay.',
        'prefill'           => [
          'name'              => $customerName,
          'email'             => $customerEmail,
          'contact'           => $customerPhone
        ],
        'order_id'          => $razorpayOrder->id
      ];

      $jsonData = json_encode($checkoutData);

      // put some data in session before redirect to razorpay url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);
      $request->session()->put('razorpayOrderId', $razorpayOrder->id);

      return view('frontend.payment.razorpay', compact('jsonData', 'notifyURL'));
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }

  public function notify(Request $request)
  {
    $arrData = $request->session()->get('arrData');
    $razorpayOrderId = $request->session()->get('razorpayOrderId');

    $urlInfo = $request->all();

    // assume that the transaction was successful
    $success = true;

    /**
     * either razorpay_order_id or razorpay_subscription_id must be present.
     * the keys of $attributes array must follow razorpay convention.
     */
    try {
      $attributes = [
        'razorpay_order_id' => $razorpayOrderId,
        'razorpay_payment_id' => $urlInfo['razorpayPaymentId'],
        'razorpay_signature' => $urlInfo['razorpaySignature']
      ];

      $this->api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
      $success = false;
    }

    if ($success === true) {
      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('razorpayOrderId');
      $request->session()->forget('serviceData');

      $bookingProcess = new ServicePaymentController();

      zoomCreate($arrData);
      calendarEventCreate($arrData);

      // store product order information in the database
      $bookingInfo = $bookingProcess->storeData($arrData);

      $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
      $type = 'service_payment_approved';
      payemntStatusMail($type, $bookinId);

      // remove all session data
      Session::put('complete', 'payment_complete');
      Session::put('paymentInfo', $bookingInfo);
      return redirect()->route('frontend.services');
    } else {
      // remove session data
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('serviceData');
      $request->session()->forget('razorpayOrderId');

      return redirect()->route('frontend.service_booking.cancel');
    }
  }
}
