<?php

namespace App\Http\Controllers\Vendor\ServicePromotion\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\ServicePromotionController;
use App\Http\Helpers\Instamojo;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Vendor;
use Auth;
use Exception;
use Illuminate\Http\Request;
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
    // amount calculation
    $chargeId = FeaturedServiceCharge::find($request->promotion_id);

    $amount = intval($chargeId->amount);
    $day = intval($chargeId->day);

    $currencyInfo = $this->getCurrencyInfo();
    // checking whether the currency is set to 'INR' or not
    if ($currencyInfo->base_currency_text !== 'INR') {
      return Response::json(['error' => 'Invalid currency for instamojo payment.'], 422);
    }

    $arrData = array(
      'amount' => $amount,
      'day' => $day,
      'service_id' => $request['service_id'],
      'vendor_id' => $request['vendor_id'],
      'invoice' => $request['invoice'],
      'currencyText' => $currencyInfo->base_currency_text,
      'currencyTextPosition' => $currencyInfo->base_currency_text_position,
      'currencySymbol' => $currencyInfo->base_currency_symbol,
      'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
      'paymentMethod' => 'Instamojo',
      'gatewayType' => 'online',
      'paymentStatus' => 'completed',
      'orderStatus' => 'pending',
    );


    $title = 'Service Featured';
    $notifyURL = route('vendor.featured.instamojo.notify');

    $vendor = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', '=', 'vendors.id')
      ->where('vendor_infos.vendor_id', $request->vendor_id)
      ->where('vendor_infos.language_id', $request->language_id)
      ->select('vendor_infos.name', 'vendors.email', 'vendors.phone')
      ->first();

    $vendorName = $vendor->name;
    $vendorEmail = $vendor->email;
    $vendorPhone = $vendor->phone;

    try {
      $response = $this->api->paymentRequestCreate(array(
        'purpose' => $title,
        'amount' => round($amount, 2),
        'buyer_name' => $vendorName,
        'email' => $vendorEmail,
        'send_email' => false,
        'phone' => $vendorPhone,
        'send_sms' => false,
        'redirect_url' => $notifyURL
      ));

      // put some data in session before redirect to instamojo url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);
      $request->session()->put('paymentId', $response['id']);
      $request->session()->put('language_id', $request->language_id);

      // Return the redirect URL as part of the JSON response
      return Response::json(['redirectURL' => $response['longurl']]);
    } catch (Exception $e) {
      return Response::json(['error' => 'Enter a valid phone number!'], 422);
    }
  }

  public function notify(Request $request)
  {
    $arrData = $request->session()->get('arrData');
    $paymentId = $request->session()->get('paymentId');
    $languageId = $request->session()->get('language_id');

    $urlInfo = $request->all();

    if ($urlInfo['payment_request_id'] == $paymentId) {
      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('paymentId');

      $servicePromotion = new ServicePromotionController();

      // store product order information in database
      $featuredInfo = $servicePromotion->storeData($arrData);

      //transaction create
      $after_balance = NULL;
      $pre_balance = NULL;
      $transactionData = [
        'vendor_id' => Auth::guard('vendor')->user()->id,
        'transaction_type' => 'featured_service',
        'pre_balance' => $pre_balance,
        'actual_total' => $arrData['amount'],
        'after_balance' => $after_balance,
        'admin_profit' => $arrData['amount'],
        'payment_method' => $arrData['paymentMethod'],
        'currency_symbol' => $arrData['currencySymbol'],
        'currency_symbol_position' => $arrData['currencySymbolPosition'],
        'payment_status' => $arrData['paymentStatus'],
      ];
      store_transaction($transactionData);

      // generate an invoice in pdf format
      $invoice = $servicePromotion->generateInvoice($featuredInfo);

      // then, update the invoice field info in database
      $featuredInfo->update(['invoice' => $invoice]);

      // send a mail to the customer with the invoice
      $servicePromotion->prepareMail($featuredInfo, $languageId);


      return redirect()->route('featured.service.online.success.page');
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('paymentId');
      $request->session()->forget('language_id');

     return redirect()->route('vendor.featured.cancel');
    }
  }
}
