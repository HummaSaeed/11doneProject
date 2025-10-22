<?php

namespace App\Http\Controllers\Vendor\ServicePromotion\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\ServicePromotionController;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Vendor;
use Auth;
use Illuminate\Http\Request;
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
    // amount calculation
    $chargeId = FeaturedServiceCharge::find($request->promotion_id);

    $amount = intval($chargeId->amount);
    $day = intval($chargeId->day);

    $allowedCurrencies = array('BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'MZN', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD');

    $currencyInfo = $this->getCurrencyInfo();


    // checking whether the base currency is allowed or not
    if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
      return Response::json(['error' => 'Invalid currency for flutterwave payment.'], 422);
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
      'paymentMethod' => 'FlutterWave',
      'gatewayType' => 'online',
      'paymentStatus' => 'completed',
      'orderStatus' => 'pending',
    );

    $title = 'Service Featured';
    $notifyURL = route('vendor.featured.flutterwave.notify');


    $vendor = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', '=', 'vendors.id')
      ->where('vendor_infos.vendor_id', $request->vendor_id)
      ->where('vendor_infos.language_id', $request->language_id)
      ->select('vendor_infos.name', 'vendors.email', 'vendors.phone')
      ->first();

    $vendorName = $vendor->name;
    $vendorEmail = $vendor->email;
    $vendorPhone = $vendor->phone;


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
        'amount' => $amount,
        'currency' => $currencyInfo->base_currency_text,
        'redirect_url' => $notifyURL,
        'payment_options' => 'card,banktransfer',
        'customer' => [
          'email' => $vendorEmail,
          'phone_number' => $vendorPhone,
          'name' => $vendorName
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
    $request->session()->put('language_id', $request->language_id);

    // redirect to payment
    if ($responseData['status'] === 'success') {
      $redirectUrl = $responseData['data']['link'];

      // Return the redirect URL as part of the JSON response
      return Response::json(['redirectURL' => $redirectUrl]);
    } else {
      return redirect()->back()->with('error', 'Error: ' . $responseData['message'])->withInput();
    }
  }

  public function notify(Request $request)
  {
    // get the information from session

    $arrData = $request->session()->get('arrData');
    $languageId = $request->session()->get('language_id');

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
        $request->session()->forget('arrData');
        $request->session()->forget('language_id');
        return redirect()->route('vendor.featured.cancel');
      }
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('language_id');

      return redirect()->route('vendor.featured.cancel');
    }
  }
}
