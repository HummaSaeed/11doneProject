<?php

namespace App\Http\Controllers\Admin\Appointment;

use App\Http\Controllers\Admin\Transaction\TransactionController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Http\Helpers\BasicMailer;
use App\Models\Admin;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Language;
use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceContent;
use App\Models\Staff\Staff;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class AppointmentController extends Controller
{

  public function index(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $orderNumber = $paymentStatus = $orderStatus = $refundStatus = null;
    if ($request->filled('order_no')) {
      $orderNumber = $request['order_no'];
    }
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }
    if ($request->filled('order_status')) {
      $orderStatus = $request['order_status'];
    }
    if ($request->filled('refund')) {
      $refundStatus = $request['refund'];
    }

    $information['currencyInfo'] = $this->getCurrencyInfo();
    $information['booking_item'] = ServiceBooking::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($orderNumber, function ($query, $orderNumber) {
        return $query->where('order_number', 'like', '%' . $orderNumber . '%');
      })
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($orderStatus, function ($query, $orderStatus) {
        return $query->where('order_status', '=', $orderStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->orderByDesc('id')
      ->paginate(10);
    return view('admin.appointment.all', $information);
  }

  public function pendingAppointment(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $paymentStatus = $refundStatus = null;
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }
    if ($request->filled('refund')) {
      $refundStatus = $request['refund'];
    }

    $information['booking_item'] = ServiceBooking::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->where('order_status', 'pending')
      ->orderByDesc('id')
      ->paginate(10);
    return view('admin.appointment.pending', $information);
  }

  public function acceptedAppointment(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $paymentStatus = $refundStatus = null;
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }
    if ($request->filled('refund')) {
      $refundStatus = $request['refund'];
    }

    $information['booking_item'] = ServiceBooking::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->where('order_status', 'accepted')->orderByDesc('id')
      ->paginate(10);
    return view('admin.appointment.accepted', $information);
  }

  public function rejectedAppointment(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $refundStatus = $paymentStatus = null;
    if ($request->filled('refund')) {
      $refundStatus = $request['refund'];
    }
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }

    $information['booking_item'] = ServiceBooking::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->where('order_status', 'rejected')->orderByDesc('id')
      ->paginate(10);;
    return view('admin.appointment.rejected', $information);
  }

  public function show($id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $appointment = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($id);

    $information['details'] = $appointment;

    $information['staff'] = Staff::join('staff_contents', 'staff_contents.staff_id', '=', 'staff.id')
      ->where('staff.id', $appointment->staff_id)
      ->select('staff.id', 'staff.email', 'staff.phone', 'staff_contents.location', 'staff_contents.information', 'staff_contents.name')
      ->first();


    if ($appointment->vendor_id != 0) {
      $information['vendor_details'] = Vendor::with(['vendor_infos' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      }])
        ->where('vendors.id', $appointment->vendor_id)
        ->first();
    } else {
      $information['vendor_details'] = Admin::whereNull('role_id')->first();
    }

    return view('admin.appointment.details', $information);
  }

  public function updatePaymentStatus(Request $request, $id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;
    $appointment = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($id);

    if ($request['payment_status'] == 'pending') {

      $appointment->update([
        'payment_status' => 'pending'
      ]);
      //send mail
      $type = 'service_payment_pending';
      payemntStatusMail($type, $id);

      return redirect()->back()->with('success', 'Payment status update successful!');
    } else if ($request['payment_status'] == 'completed') {
      $appointment->update([
        'payment_status' => 'completed'
      ]);

      //send mail
      $type = 'service_payment_approved';
      payemntStatusMail($type, $id);

      $arrData = array(
        'customer_paid' => $appointment->customer_paid,
        'paymentMethod' => $appointment->payment_method,
        'currencySymbol' => $appointment->currency_symbol,
        'currencySymbolPosition' => $appointment->currency_symbol_position,
        'paymentStatus' => $appointment->payment_status,
        'vendor_id' => $appointment->vendor_id,
      );

      $transaction = new TransactionController();
      $transaction->storeTransaction($arrData);

      return redirect()->back()->with('success', 'Payment status update successful!');
    } else {
      //after reject
      $appointment->update([
        'payment_status' => 'rejected'
      ]);

      //send mail
      $type = 'service_payment_rejected';
      payemntStatusMail($type, $id);

      return redirect()->back();
    }
  }

  //order status change
  public function updateAppointmentStatus(Request $request, $id)
  {
    $booking = ServiceBooking::findOrFail($id);
    if ($booking->vendor_id != 0) {
      $vendor = Vendor::findOrFail($booking->vendor_id);
    }
    if ($request['order_status'] == 'pending') {

      $booking->update([
        'order_status' => 'pending'
      ]);
    } else if ($request['order_status'] == 'accepted') {
      $booking->update([
        'order_status' => 'accepted'
      ]);

      $appointmentProcess = new ServicePaymentController();
      // generate an invoice in pdf format
      $invoice = $appointmentProcess->generateInvoice($booking);

      // then, update the invoice field info in database
      $booking->update(['invoice' => $invoice]);

      // send a mail to the customer with the invoice for booking accepted
      $appointmentProcess->prepareMail($booking);
    } else {
      //after reject
      $misc = new MiscellaneousController();
      $language = $misc->getLanguage();

      $serviceInfo = ServiceContent::query()
        ->where('service_id', $booking->service_id)
        ->where('language_id', $language->id)
        ->select('name', 'slug')
        ->firstOrFail();

      $booking->update([
        'order_status' => 'rejected',
        'refund' => 'pending',
      ]);
      if ($booking->vendor_id != 0) {
        $lessAppointmentNum = intval($vendor->total_appointment) + 1;
        //update less appoitnment number
        $vendor->update([
          'total_appointment' => $lessAppointmentNum,
        ]);
      }

      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'service_booking_rejected')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // get the website title info from db
      $info = Basic::select('website_title')->first();

      $service = $serviceInfo->name;
      $price = $booking->currency_symbol . $booking->customer_paid;
      $username = $booking->customer_name;
      $websiteTitle = $info->website_title;

      // replacing with actual data

      $mailBody = str_replace('{service_name}', $service, $mailBody);
      $mailBody = str_replace('{username}', $username, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);
      $mailBody = str_replace('{price}', $price, $mailBody);

      $mailData['body'] = $mailBody;
      $mailData['recipient'] = $booking->customer_email;

      BasicMailer::sendMail($mailData);
    }
    return redirect()->back()->with('success', 'Appointment status update successful!');
  }

  //refund status change
  public function updateRefundStatus(Request $request, $id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;
    $appointment = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($id);

    if ($request['refund'] == 'pending') {
      $appointment->update([
        'refund' => 'pending'
      ]);
      //send mail
      $type = 'service_payment_pending';
      payemntStatusMail($type, $id);

      return redirect()->back()->with('success', 'Refund status update successful!');
    } else {
      $appointment->update([
        'refund' => 'refunded'
      ]);

      $arrData = array(
        'type' => 'refund',
        'customer_paid' => $appointment->customer_paid,
        'paymentMethod' => $appointment->payment_method,
        'currencySymbol' => $appointment->currency_symbol,
        'currencySymbolPosition' => $appointment->currency_symbol_position,
        'paymentStatus' => $appointment->payment_status,
        'vendor_id' => $appointment->vendor_id,
        'refund_amount' => $appointment->customer_paid,
      );

      //create transaction for this payment
      $transaction = new TransactionController();
      $transaction->storeTransaction($arrData);

      return redirect()->back()->with('success', 'Refund status update successful!');
    }
  }

  public function staffAssign(Request $request)
  {
    $ruels = ['staff_id' => 'required'];
    $messages = [
      'staff_id.required' => 'The staff field is required',
    ];
    $validator = Validator::make($request->all(), $ruels, $messages);
    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }
    $appointment = ServiceBooking::findOrFail($request->appointment_id);
    $appointment->update([
      'staff_id' => $request->staff_id,
    ]);

    $request->session()->flash('success', 'New staff assigned successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function destroy($id)
  {
    $appointment = ServiceBooking::find($id);

    // delete the attachment
    @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);

    @unlink(public_path('assets/file/invoices/service/') . $appointment->invoice);

    $appointment->delete();

    return redirect()->back()->with('success', 'Appointment delete successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $appointment = ServiceBooking::findOrFail($id);
      @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);

      if (!empty($appointment->invoice)) {
        @unlink(public_path('assets/file/invoices/service/' . $appointment->invoice));
      }
      $appointment->delete();
      $request->session()->flash('success', 'Appointments delete successfully!');
    }
    return Response::json(['status' => 'success'], 200);
  }
}
