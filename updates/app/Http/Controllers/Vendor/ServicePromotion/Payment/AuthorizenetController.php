<?php

namespace App\Http\Controllers\Vendor\ServicePromotion\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\ServicePromotionController;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\PaymentGateway\OnlineGateway;
use Auth;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use Response;

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
    $chargeId = FeaturedServiceCharge::find($request->promotion_id);
    $languageId = $request->language_id;

    $amount = intval($chargeId->amount);
    $day = intval($chargeId->day);

    $currencyInfo = $this->getCurrencyInfo();

    // checking whether the currency is set to 'INR' or not
    $allowedCurrencies = array('USD', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'NOK', 'PLN', 'SEK', 'AUD', 'NZD');
    $currencyInfo = $this->getCurrencyInfo();

    // checking whether the base currency is allowed or not
    if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
      return Response::json(['error' => 'Invalid currency for authorize.net payment.'], 422);
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
      'paymentMethod' => 'Authorize.net',
      'gatewayType' => 'online',
      'paymentStatus' => 'completed',
      'orderStatus' => 'pending',
    );
    // put some data in session before redirect to paytm url
    $request->session()->put('paymentFor', $paymentFor);
    $request->session()->put('arrData', $arrData);

    if ($request->filled('opaqueDataValue') && $request->filled('opaqueDataDescriptor')) {
      // generate a unique merchant site transaction ID
      $transactionId = rand(100000000, 999999999);

      $response = $this->gateway->authorize([
        'amount' => sprintf('%0.2f', $amount),
        'currency' => $currencyInfo->base_currency_text,
        'transactionId' => $transactionId,
        'opaqueDataDescriptor' => $request->opaqueDataDescriptor,
        'opaqueDataValue' => $request->opaqueDataValue
      ])->send();

      if ($response->isSuccessful()) {
        /**
         * success process will be go here
         * remove this session datas
         */
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
        //cancel payment
        $request->session()->forget('paymentFor');
        $request->session()->forget('arrData');
        $request->session()->forget('paymentId');
        return redirect()->route('vendor.featured.cancel');
      }
    } else {
      //return cancel url
      return redirect()->route('vendor.featured.cancel');
    }
    return redirect()->route('vendor.featured.cancel');
  }
}
