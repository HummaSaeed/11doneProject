<?php

namespace App\Http\Controllers\Vendor\ServicePromotion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\AuthorizenetController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\FlutterwaveController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\InstamojoController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\MercadoPagoController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\MollieController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\OfflineController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\PayPalController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\PaystackController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\PaytmController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\RazorpayController;
use App\Http\Controllers\Vendor\ServicePromotion\Payment\StripeController;
use App\Http\Helpers\BasicMailer;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\FeaturedService\ServicePromotion;
use App\Models\Language;
use App\Models\Services\ServiceContent;
use App\Models\VendorInfo;
use Illuminate\Http\Request;
use PDF;
use Validator;

class ServicePromotionController extends Controller
{
  public function index(Request $request)
  {
    $rules = [
      'promotion_id' => 'required',
      'gateway' => 'required',
    ];

    $messages = [
      'promotion_id.required' => 'Please select a promotion.',
      'gateway.required' => 'Please select a payment gateway.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    if ($request['gateway'] == 'paypal') {
      $paypal = new PayPalController();

      return $paypal->index($request, 'service featured');
    } else if ($request['gateway'] == 'instamojo') {
      $instamojo = new InstamojoController();

      return $instamojo->index($request, 'service featured');
    } else if ($request['gateway'] == 'paystack') {
      $paystack = new PaystackController();

      return $paystack->index($request, 'service featured');
    } else if ($request['gateway'] == 'flutterwave') {
      $flutterwave = new FlutterwaveController();

      return $flutterwave->index($request, 'service featured');
    } else if ($request['gateway'] == 'razorpay') {
      $razorpay = new RazorpayController();

      return $razorpay->index($request, 'service featured');
    } else if ($request['gateway'] == 'mercadopago') {
      $mercadopago = new MercadoPagoController();

      return $mercadopago->index($request, 'service featured');
    } else if ($request['gateway'] == 'mollie') {
      $mollie = new MollieController();

      return $mollie->index($request, 'service featured');
    } else if ($request['gateway'] == 'stripe') {
      $stripe = new StripeController();

      return $stripe->index($request, 'service featured');
    } else if ($request['gateway'] == 'paytm') {
      $paytm = new PaytmController();

      return $paytm->index($request, 'service featured');
    } else if ($request['gateway'] == 'authorize.net') {
      $authorize = new AuthorizenetController();

      return $authorize->index($request, 'service featured');
    } else {
      $offline = new OfflineController();

      return $offline->index($request, 'service featured');
    }
  }

  public function storeData($arrData)
  {
    $orderInfo = ServicePromotion::create([
      'order_number' => uniqid(),
      'amount' => $arrData['amount'],
      'day' => $arrData['day'],
      'service_id' => $arrData['service_id'],
      'vendor_id' => $arrData['vendor_id'],
      'invoice' => $arrData['invoice'],
      'currency_text' => $arrData['currencyText'],
      'currency_text_position' => $arrData['currencyTextPosition'],
      'currency_symbol' => $arrData['currencySymbol'],
      'currency_symbol_position' => $arrData['currencySymbolPosition'],
      'payment_method' => $arrData['paymentMethod'],
      'gateway_type' => $arrData['gatewayType'],
      'payment_status' => $arrData['paymentStatus'],
      'order_status' => $arrData['orderStatus'],
      'attachment' => array_key_exists('attachment', $arrData) ? $arrData['attachment'] : null
    ]);

    return $orderInfo;
  }

  public function generateInvoice($orderInfo)
  {
    $fileName = $orderInfo->order_number . '.pdf';
    $data['orderInfo'] = $orderInfo;

    $directory = public_path('assets/file/invoices/featured/service/');
    @mkdir($directory, 0775, true);

    $fileLocated = $directory . $fileName;
    PDF::loadView('frontend.services.featured-service.invoice', $data)->save($fileLocated);
    return $fileName;
  }

  public function prepareMail($featuredInfo, $languageId)
  {
    // get the mail template info from db
    $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'featured_request_send')->first();
    $mailData['subject'] = $mailTemplate->mail_subject;
    $mailBody = $mailTemplate->mail_body;

    // get the website title info from db
    $info = Basic::select('website_title')->first();

    //service info
    $service = ServiceContent::where('service_id', $featuredInfo->service_id)
      ->where('language_id', $languageId)
      ->select('name', 'slug')
      ->first();
    $url = route('frontend.service.details', ['slug' => $service->slug, 'id' => $featuredInfo->service_id]);
    $serviceName = truncateString($service->name, 50);

    //vendor info
    $vendorName = VendorInfo::where('vendor_id', $featuredInfo->vendor_id)
      ->where('language_id', $languageId)
      ->first()->name;

    // replacing with actual data
    $mailBody = str_replace('{service_title}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
    $mailBody = str_replace('{amount}', symbolPrice($featuredInfo->amount), $mailBody);
    $mailBody = str_replace('{username}', $vendorName, $mailBody);
    $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);

    $mailData['body'] = $mailBody;
    $mailData['recipient'] = $featuredInfo->vendor->email;
    $mailData['invoice'] = public_path('assets/file/invoices/featured/service/') . $featuredInfo->invoice;
    BasicMailer::sendMail($mailData);
    return;
  }

  public function cancel(Request $request)
  {
    $language = Language::where('is_default', 1)->first();
    session()->flash('warning', 'Something went wrong !');
    return redirect()->route('vendor.service_managment', ['language' => $language->code]);
  }
}
