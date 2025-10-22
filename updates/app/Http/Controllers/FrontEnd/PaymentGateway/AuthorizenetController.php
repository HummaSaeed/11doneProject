<?php

namespace App\Http\Controllers\FrontEnd\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Shop\PurchaseProcessController;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Shop\Product;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
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
    // get the products from session
    if ($request->session()->has('productCart')) {
      $productList = $request->session()->get('productCart');
    } else {
      Session::flash('error', 'Something went wrong!');
      return redirect()->route('shop.products');
    }
    $purchaseProcess = new PurchaseProcessController();

    // do calculation
    $calculatedData = $purchaseProcess->calculation($request, $productList);
    $currencyInfo = $this->getCurrencyInfo();

    // checking whether the currency is set to 'INR' or not
    $allowedCurrencies = array('USD', 'CAD', 'CHF', 'DKK', 'EUR', 'GBP', 'NOK', 'PLN', 'SEK', 'AUD', 'NZD');
    $currencyInfo = $this->getCurrencyInfo();

    // checking whether the base currency is allowed or not
    if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
      return redirect()->back()->with('error', 'Invalid currency for authorize.net payment.')->withInput();
    }
    $arrData = array(
      'billing_name' => $request['billing_name'],
      'billing_email' => $request['billing_email'],
      'billing_phone' => $request['billing_phone'],
      'billing_city' => $request['billing_city'],
      'billing_state' => $request['billing_state'],
      'billing_country' => $request['billing_country'],
      'billing_address' => $request['billing_address'],

      'shipping_name' => $request->checkbox == 1 ? $request['shipping_name'] : $request['billing_name'],
      'shipping_email' => $request->checkbox == 1 ? $request['shipping_email'] : $request['billing_email'],
      'shipping_phone' => $request->checkbox == 1 ? $request['shipping_phone'] : $request['billing_phone'],
      'shipping_city' => $request->checkbox == 1 ? $request['shipping_city'] : $request['billing_city'],
      'shipping_state' => $request->checkbox == 1 ? $request['shipping_state'] : $request['billing_state'],
      'shipping_country' => $request->checkbox == 1 ? $request['shipping_country'] : $request['billing_country'],
      'shipping_address' => $request->checkbox == 1 ? $request['shipping_address'] : $request['billing_address'],

      'total' => $calculatedData['total'],
      'discount' => $calculatedData['discount'],
      'productShippingChargeId' => $request->exists('shipping_method') ? $request['shipping_method'] : null,
      'shippingCharge' => $calculatedData['shippingCharge'],
      'tax' => $calculatedData['tax'],
      'grandTotal' => $calculatedData['grandTotal'],
      'currencyText' => $currencyInfo->base_currency_text,
      'currencyTextPosition' => $currencyInfo->base_currency_text_position,
      'currencySymbol' => $currencyInfo->base_currency_symbol,
      'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
      'paymentMethod' => 'Authorize.net',
      'gatewayType' => 'online',
      'paymentStatus' => 'completed',
      'orderStatus' => 'pending'
    );
    // put some data in session before redirect to paytm url
    $request->session()->put('paymentFor', $paymentFor);
    $request->session()->put('arrData', $arrData);

    if ($request->filled('opaqueDataValue') && $request->filled('opaqueDataDescriptor')) {
      // generate a unique merchant site transaction ID
      $transactionId = rand(100000000, 999999999);

      $response = $this->gateway->authorize([
        'amount' => sprintf('%0.2f', $calculatedData['grandTotal']),
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
        $purchaseProcess = new PurchaseProcessController();

        // store product order information in database
        $orderInfo = $purchaseProcess->storeData($productList, $arrData);

        // then subtract each product quantity from respective product stock
        foreach ($productList as $key => $item) {
          $product = Product::query()->find($key);
          if ($product->product_type == 'physical') {
            $stock = $product->stock - intval($item['quantity']);
            $product->update(['stock' => $stock]);
          }
        }
        //transaction create
        $after_balance = NULL;
        $pre_balance = NULL;
        $transactionData = [
          'transaction_id' => time(),
          'vendor_id' => $arrData['vendor_id'] ?? 0,
          'transaction_type' => 'product_purchase',
          'pre_balance' => $pre_balance,
          'actual_total' => $arrData['grandTotal'],
          'after_balance' => $after_balance,
          'admin_profit' => $arrData['grandTotal'],
          'payment_method' => $arrData['paymentMethod'],
          'currency_symbol' => $arrData['currencySymbol'],
          'currency_symbol_position' => $arrData['currencySymbolPosition'],
          'payment_status' => $arrData['paymentStatus'],
        ];
        store_transaction($transactionData);
        // generate an invoice in pdf format
        $invoice = $purchaseProcess->generateInvoice($orderInfo, $productList);

        // then, update the invoice field info in database
        $orderInfo->update(['invoice' => $invoice]);

        // send a mail to the customer with the invoice
        $purchaseProcess->prepareMail($orderInfo);

        // remove all session data
        $request->session()->forget('productCart');
        $request->session()->forget('discount');
        return redirect()->route('shop.purchase_product.complete');
      } else {
        //cancel payment
        $request->session()->forget('paymentFor');
        $request->session()->forget('arrData');
        $request->session()->forget('paymentId');
        // remove session data
        $request->session()->forget('productCart');
        $request->session()->forget('discount');
        return redirect()->route('shop.purchase_product.cancel');
      }
    } else {
      //return cancel url
      return redirect()->route('shop.products');
    }
    return redirect()->route('shop.products');
  }
}
