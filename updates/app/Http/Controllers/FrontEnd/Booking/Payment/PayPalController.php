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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PayPalController extends Controller
{
  private $api_context;

  public function __construct()
  {
    $data = OnlineGateway::whereKeyword('paypal')->first();
    $paypalData = json_decode($data->information, true);

    $paypal_conf = Config::get('paypal');
    $paypal_conf['client_id'] = $paypalData['client_id'];
    $paypal_conf['secret'] = $paypalData['client_secret'];
    $paypal_conf['settings']['mode'] = $paypalData['sandbox_status'] == 1 ? 'sandbox' : 'live';

    $this->api_context = new ApiContext(
      new OAuthTokenCredential(
        $paypal_conf['client_id'],
        $paypal_conf['secret']
      )
    );

    $this->api_context->setConfig($paypal_conf['settings']);
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

      $customerPaid = $serviceData['service_ammount'];
      $currencyInfo = $this->getCurrencyInfo();

      // changing the currency before redirect to PayPal
    //   if ($currencyInfo->base_currency_text === 'GBP') {
    //     $rate = floatval($currencyInfo->base_currency_rate);
    //     $convertedTotal = $customerPaid / $rate;
    //   }

    //   $paypalTotal = $currencyInfo->base_currency_text === 'USD' ? $customerPaid : $convertedTotal;
    
     $paypalTotal = $customerPaid;

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
        'paymentMethod' => 'PayPal',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );

      $title = 'Service Booking';
      $notifyURL = route('frontend.service_booking.paypal.notify');
      $cancelURL = route('frontend.service_booking.cancel');

      $payer = new Payer();
      $payer->setPaymentMethod('paypal');

      $item_1 = new Item();
      $item_1->setName($title)
        /** item name **/
        ->setCurrency('GBP')
        ->setQuantity(1)
        ->setPrice($paypalTotal);
      /** unit price **/
      $item_list = new ItemList();
      $item_list->setItems(array($item_1));

      $amount = new Amount();
      $amount->setCurrency('GBP')
        ->setTotal($paypalTotal);

      $transaction = new Transaction();
      $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription($title . ' via PayPal');

      $redirect_urls = new RedirectUrls();
      $redirect_urls->setReturnUrl($notifyURL)
        /** Specify return URL **/
        ->setCancelUrl($cancelURL);

      $payment = new Payment();
      $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));

      try {
        $payment->create($this->api_context);
      } catch (\Exception $ex) {
        return redirect($cancelURL)->with('error', $ex->getMessage());
      }


      foreach ($payment->getLinks() as $link) {
        if ($link->getRel() == 'approval_url') {
          $redirectURL = $link->getHref();
          break;
        }
      }

      // put some data in session before redirect to paypal url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);
      $request->session()->put('paymentId', $payment->getId());

      if (isset($redirectURL)) {
        /** redirect to paypal **/
        return response()->json(['redirectURL' => $redirectURL]);
      }
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }

  public function notify(Request $request)
  {
    // get the information from session
    $paymentPurpose = $request->session()->get('paymentFor');
    $arrData = $request->session()->get('arrData');
    $paymentId = $request->session()->get('paymentId');

    $urlInfo = $request->all();

    if (empty($urlInfo['token']) || empty($urlInfo['PayerID'])) {
      if ($paymentPurpose == 'service booking') {
        return redirect()->route('frontend.services');
      }
    }

    /** Execute The Payment **/
    $payment = Payment::get($paymentId, $this->api_context);
    $execution = new PaymentExecution();
    $execution->setPayerId($urlInfo['PayerID']);
    $result = $payment->execute($execution, $this->api_context);

    if ($result->getState() == 'approved') {
      $purchaseProcess = new ServicePaymentController();

      zoomCreate($arrData);
      calendarEventCreate($arrData);

      // store service booking information in database
      $bookingInfo = $purchaseProcess->storeData($arrData);

      $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
      $type = 'service_payment_approved';
      payemntStatusMail($type, $bookinId);

      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('paymentId');
      $request->session()->forget('serviceData');

      // redirect url here after succesfully payment
      Session::put('complete', 'payment_complete');
      Session::put('paymentInfo', $bookingInfo);
      return redirect()->route('frontend.services');
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('serviceData');
      $request->session()->forget('paymentId');

      if ($paymentPurpose == 'service booking') {
        return redirect()->back();
      }
    }
  }
}
