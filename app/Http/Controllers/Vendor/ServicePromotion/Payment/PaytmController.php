<?php

namespace App\Http\Controllers\Vendor\ServicePromotion\Payment;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\ServicePromotionController;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\Vendor;
use Auth;
use Illuminate\Http\Request;
use Response;

class PaytmController extends Controller
{
  public function index(Request $request, $paymentFor)
  {
    // amount calculation
    $chargeId = FeaturedServiceCharge::findOrFail($request->promotion_id);

    $amount = intval($chargeId->amount);
    $day = intval($chargeId->day);

    $currencyInfo = $this->getCurrencyInfo();

    // checking whether the currency is set to 'INR' or not
    if ($currencyInfo->base_currency_text !== 'INR') {
      return Response::json(['error' => 'Invalid currency for paytm payment.'], 422);
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
      'paymentMethod' => 'Paytm',
      'gatewayType' => 'online',
      'paymentStatus' => 'completed',
      'orderStatus' => 'pending',
    );


    $notifyURL = route('vendor.featured.paytm.notify');

    $vendor = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', '=', 'vendors.id')
      ->where('vendor_infos.vendor_id', $request->vendor_id)
      ->where('vendor_infos.language_id', $request->language_id)
      ->select('vendor_infos.name', 'vendors.email', 'vendors.phone')
      ->first();

    $vendorEmail = $vendor->email;
    $vendorPhone = $vendor->phone;

    $payment = PaytmWallet::with('receive');

    $payment->prepare([
      'order' => time(),
      'user' => uniqid(),
      'mobile_number' => $vendorPhone,
      'email' => $vendorEmail,
      'amount' => round($amount, 2),
      'callback_url' => $notifyURL
    ]);

    // put some data in session before redirect to paytm url
    $request->session()->put('paymentFor', $paymentFor);
    $request->session()->put('arrData', $arrData);
    $request->session()->put('language_id', $request->language_id);
    return $payment->receive();
  }

  public function notify(Request $request)
  {
    $arrData = $request->session()->get('arrData');
    $languageId = $request->session()->get('language_id');

    $transaction = PaytmWallet::with('receive');

    // this response is needed to check the transaction status
    $response = $transaction->response();

    if ($transaction->isSuccessful()) {
      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');

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
      $request->session()->forget('language_id');

      return redirect()->route('vendor.featured.cancel');
    }
  }
}
