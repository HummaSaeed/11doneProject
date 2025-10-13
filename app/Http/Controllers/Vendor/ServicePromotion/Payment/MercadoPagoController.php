<?php

namespace App\Http\Controllers\Vendor\ServicePromotion\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\ServicePromotionController;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\Language;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Vendor;
use Auth;
use Illuminate\Http\Request;

class MercadoPagoController extends Controller
{
  private $token, $sandbox_status;

  public function __construct()
  {
    $data = OnlineGateway::whereKeyword('mercadopago')->first();
    $mercadopagoData = json_decode($data->information, true);

    $this->token = $mercadopagoData['token'];
    $this->sandbox_status = $mercadopagoData['sandbox_status'];
  }

  public function index(Request $request, $paymentFor)
  {
    // amount calculation
    $chargeId = FeaturedServiceCharge::find($request->promotion_id);
    $amount = intval($chargeId->amount);
    $day = intval($chargeId->day);


    $allowedCurrencies = array('ARS', 'BOB', 'BRL', 'CLF', 'CLP', 'COP', 'CRC', 'CUC', 'CUP', 'DOP', 'EUR', 'GTQ', 'HNL', 'MXN', 'NIO', 'PAB', 'PEN', 'PYG', 'USD', 'UYU', 'VEF', 'VES');

    $currencyInfo = $this->getCurrencyInfo();

    // checking whether the base currency is allowed or not
    if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
      return Response::json(['error' => 'Invalid currency for mercadopago payment.'], 422);
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
      'paymentMethod' => 'MercadoPago',
      'gatewayType' => 'online',
      'paymentStatus' => 'completed',
      'orderStatus' => 'pending',
    );

    $title = 'Service Featured';
    $notifyURL = route('vendor.featured.mercadopago.notify');
    $cancelURL = route('vendor.featured.cancel');

    $vendor = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', '=', 'vendors.id')
      ->where('vendor_infos.vendor_id', $request->vendor_id)
      ->where('vendor_infos.language_id', $request->language_id)
      ->select('vendor_infos.name', 'vendors.email', 'vendors.phone')
      ->first();

    $vendorEmail = $vendor->email;

    $curl = curl_init();

    $preferenceData = [
      'items' => [
        [
          'id' => uniqid(),
          'title' => $title,
          'description' => $title . ' via MercadoPago',
          'quantity' => 1,
          'currency' => $currencyInfo->base_currency_text,
          'unit_price' => $amount
        ]
      ],
      'payer' => [
        'email' => $vendorEmail
      ],
      'back_urls' => [
        'success' => $notifyURL,
        'pending' => '',
        'failure' => $cancelURL
      ],
      'notification_url' => $notifyURL,
      'auto_return' => 'approved'
    ];

    $httpHeader = ['Content-Type: application/json'];

    $url = 'https://api.mercadopago.com/checkout/preferences?access_token=' . $this->token;

    $curlOPT = [
      CURLOPT_URL             => $url,
      CURLOPT_CUSTOMREQUEST   => 'POST',
      CURLOPT_POSTFIELDS      => json_encode($preferenceData, true),
      CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
      CURLOPT_RETURNTRANSFER  => true,
      CURLOPT_TIMEOUT         => 30,
      CURLOPT_HTTPHEADER      => $httpHeader
    ];

    curl_setopt_array($curl, $curlOPT);

    $response = curl_exec($curl);
    $responseInfo = json_decode($response, true);

    curl_close($curl);

    // put some data in session before redirect to mercadopago url
    $request->session()->put('paymentFor', $paymentFor);
    $request->session()->put('arrData', $arrData);
    $request->session()->put('language_id', $request->language_id);

    if ($this->sandbox_status == 1) {
      return redirect($responseInfo['sandbox_init_point']);
    } else {
      return redirect($responseInfo['init_point']);
    }
  }

  public function notify(Request $request)
  {
    $arrData = $request->session()->get('arrData');
    $languageId = $request->session()->get('language_id');

    if ($request->status == 'approved') {
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

  public function curlCalls($url)
  {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $curlData = curl_exec($curl);

    curl_close($curl);

    return $curlData;
  }
}
