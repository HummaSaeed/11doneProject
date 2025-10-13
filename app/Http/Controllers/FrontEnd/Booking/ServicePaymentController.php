<?php

namespace App\Http\Controllers\FrontEnd\Booking;

use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\Payment\AuthorizenetController;
use App\Http\Controllers\FrontEnd\Booking\Payment\FlutterwaveController;
use App\Http\Controllers\FrontEnd\Booking\Payment\InstamojoController;
use App\Http\Controllers\FrontEnd\Booking\Payment\MercadoPagoController;
use App\Http\Controllers\FrontEnd\Booking\Payment\MollieController;
use App\Http\Controllers\FrontEnd\Booking\Payment\OfflineController;
use App\Http\Controllers\FrontEnd\Booking\Payment\PayPalController;
use App\Http\Controllers\FrontEnd\Booking\Payment\PaystackController;
use App\Http\Controllers\FrontEnd\Booking\Payment\PaytmController;
use App\Http\Controllers\FrontEnd\Booking\Payment\RazorpayController;
use App\Http\Controllers\FrontEnd\Booking\Payment\StripeController;
use App\Http\Helpers\BasicMailer;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Language;
use App\Models\Membership;
use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceContent;
use App\Models\Vendor;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use Validator;

class ServicePaymentController extends Controller
{
  public function index(Request $request)
  {
    //gateway validation
    $rules = ['gateway' => 'required',];
    $messages = ['gateway.required' => 'Please select a payment gateway'];
    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    if ($request['gateway'] == 'paypal') {
      $paypal = new PayPalController();

      return $paypal->index($request, 'service booking');
    } else if ($request['gateway'] == 'instamojo') {
      $instamojo = new InstamojoController();

      return $instamojo->index($request, 'service booking');
    } else if ($request['gateway'] == 'paystack') {
      $paystack = new PaystackController();

      return $paystack->index($request, 'service booking');
    } else if ($request['gateway'] == 'flutterwave') {
      $flutterwave = new FlutterwaveController();

      return $flutterwave->index($request, 'service booking');
    } else if ($request['gateway'] == 'razorpay') {
      $razorpay = new RazorpayController();

      return $razorpay->index($request, 'service booking');
    } else if ($request['gateway'] == 'mercadopago') {
      $mercadopago = new MercadoPagoController();

      return $mercadopago->index($request, 'service booking');
    } else if ($request['gateway'] == 'mollie') {
      $mollie = new MollieController();

      return $mollie->index($request, 'service booking');
    } else if ($request['gateway'] == 'stripe') {
      $stripe = new StripeController();

      return $stripe->index($request, 'service booking');
    } else if ($request['gateway'] == 'paytm') {
      $paytm = new PaytmController();

      return $paytm->index($request, 'service booking');
    } else if ($request['gateway'] == 'authorize.net') {
      $authorize = new AuthorizenetController();

      return $authorize->index($request, 'service booking');
    } else {
      $offline = new OfflineController();

      return $offline->index($request, 'service booking');
    }
  }

  public function storeData($arrData)
  {
    if ($arrData['vendor_id'] != 0) {
      $currentPackage = Membership::query()->where([
        ['vendor_id', '=', $arrData['vendor_id']],
        ['status', '=', 1],
        ['start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])->first();
    }

    $orderInfo = ServiceBooking::create([
      'order_number' => uniqid(),
      'membership_id' => $arrData['vendor_id'] != 0 ? ($currentPackage ? $currentPackage->id : null) : null,
      'customer_name' => $arrData['customer_name'],
      'customer_phone' => $arrData['customer_phone'],
      'customer_email' => $arrData['customer_email'],
      'customer_address' => $arrData['customer_address'],
      'customer_zip_code' => $arrData['customer_zip_code'],
      'customer_country' => $arrData['customer_country'],
      'start_date' => $arrData['start_date'],
      'end_date' => $arrData['end_date'],
      'booking_date' => $arrData['booking_date'],
      'staff_id' => $arrData['staff_id'],
      'service_id' => $arrData['service_id'],
      'max_person' => $arrData['max_person'] != null ? $arrData['max_person'] : 1,
      'user_id' => $arrData['user_id'],
      'vendor_id' => $arrData['vendor_id'],
      'service_hour_id' => $arrData['service_hour_id'],
      'customer_paid' => $arrData['customer_paid'],
      'currency_text' => $arrData['currencyText'],
      'currency_text_position' => $arrData['currencyTextPosition'],
      'currency_symbol' => $arrData['currencySymbol'],
      'currency_symbol_position' => $arrData['currencySymbolPosition'],
      'payment_method' => $arrData['paymentMethod'],
      'gateway_type' => $arrData['gatewayType'],
      'payment_status' => $arrData['paymentStatus'],
      'order_status' => $arrData['orderStatus'],
      'refund' => $arrData['refund'],
      'attachment' => array_key_exists('attachment', $arrData) ? $arrData['attachment'] : null,
      'zoom_info' => session()->has('zoom_info') ? json_encode(session()->get('zoom_info')) : null,
    ]);

    //create transaction for this payment
    if ($arrData['gatewayType'] != 'offline') {
      $transaction = new TransactionController();
      $transaction->storeTransaction($arrData);
    }
    if ($arrData['vendor_id'] != 0) {
      $vendor = Vendor::findOrFail($arrData['vendor_id']);
      $lessAppointmentNum = intval($vendor->total_appointment) - 1;
      //update less appoitnment number
      $vendor->update([
        'total_appointment' => $lessAppointmentNum,
      ]);
    }

    session::forget('zoom_info');
    return $orderInfo;
  }

  public function generateInvoice($orderInfo)
  {
    $fileName = $orderInfo->order_number . '.pdf';

    $data['orderInfo'] = $orderInfo;

    $directory = public_path('assets/file/invoices/service/');
    @mkdir($directory, 0775, true);

    $fileLocated = $directory . $fileName;

    PDF::loadView('frontend.services.invoice', $data)->save($fileLocated);

    return $fileName;
  }

  public function prepareMail($orderInfo)
  {
    // get the mail template info from db
    $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'service_booking_accepted')->first();
    $mailData['subject'] = $mailTemplate->mail_subject;
    $mailBody = $mailTemplate->mail_body;

    $appointment = ServiceBooking::where([
      'service_id' => $orderInfo['service_id'],
      'booking_date' => $orderInfo['booking_date'],
      'service_hour_id' => $orderInfo['service_hour_id']
    ])->select('zoom_info')->first();

    if ($appointment->zoom_info != null) {
      // Decode JSON data into an associative array
      $zoomLink = json_decode($appointment->zoom_info, true);
      $joinUrl = $zoomLink['join_url'];
      $joinPwd = $zoomLink['password'];
    }
    if ($appointment->zoom_info != null) {
      $joinurl = '<p>Zoom Join link: ' . $joinUrl . '</p>';
      $joinPassword = '<p>Zoom Join Password: ' . $joinPwd . '</p>';
    } else {
      $joinurl = '';
      $joinPassword = '';
    }

    if (Auth::guard('web')->check() == true) {
      $orderLink = '<p>Appointment Details: <a href=' . url("user/appointment/details/" . $orderInfo->id) . '>Click Here</a></p>';
    } else {
      $orderLink = '';
    }

    $language = Language::where('is_default', 1)->first();
    $serviceInfo = ServiceContent::query()
      ->where('service_id', $orderInfo->service_id)
      ->where('language_id', $language->id)
      ->select('name', 'slug')
      ->firstOrFail();

    $url = route('frontend.service.details', ['slug' => $serviceInfo->slug, 'id' => $orderInfo->service_id]);
    $serviceName = truncateString($serviceInfo->name, 50);

    // get the website title info from db
    $info = Basic::select('website_title')->first();
    $appointmentTime = $orderInfo->start_date . ' to ' . $orderInfo->end_date;

    // replacing with actual data
    $mailBody = str_replace('{booking_number}', $orderInfo->order_number, $mailBody);
    $mailBody = str_replace('{service_title}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
    $mailBody = str_replace('{order_link}', $orderLink, $mailBody);
    $mailBody = str_replace('{zoom_link}', $joinurl, $mailBody);
    $mailBody = str_replace('{zoom_password}', $joinPassword, $mailBody);
    $mailBody = str_replace('{customer_name}', $orderInfo->customer_name, $mailBody);
    $mailBody = str_replace('{booking_date}', date_format($orderInfo->created_at, 'M d, Y'), $mailBody);
    $mailBody = str_replace('{appointment_date}', Carbon::parse($orderInfo->booking_date)->format('M d, Y'), $mailBody);
    $mailBody = str_replace('{appointment_time}', $appointmentTime, $mailBody);
    $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);


    $mailData['body'] = $mailBody;
    $mailData['recipient'] = $orderInfo->customer_email;
    $mailData['invoice'] = public_path('assets/file/invoices/service/') . $orderInfo->invoice;
    BasicMailer::sendMail($mailData);
    return;
  }

  public function cancel()
  {
    $notification = array('message' => 'Something went wrong', 'alert-type' => 'error');
    return redirect()->route('frontend.services')->with($notification);
  }
}
