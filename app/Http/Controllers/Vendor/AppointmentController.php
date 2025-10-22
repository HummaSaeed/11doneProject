<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\BasicMailer;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Language;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Vendor;
use Auth;
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
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
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
    return view('vendors.appointment.all', $information);
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
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->where('order_status', 'pending')
      ->orderByDesc('id')
      ->paginate(10);
    return view('vendors.appointment.pending', $information);
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
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->where('order_status', 'accepted')->orderByDesc('id')
      ->paginate(10);;
    return view('vendors.appointment.accepted', $information);
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
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->where('order_status', 'rejected')->orderByDesc('id')
      ->paginate(10);;
    return view('vendors.appointment.rejected', $information);
  }

  public function show($id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $appointment = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->findOrFail($id);
    $information['details'] = $appointment;

    $information['vendor_details'] = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', '=', 'vendors.id')
      ->where('vendors.id', $appointment->vendor_id)
      ->first();

    $information['staff'] = Staff::join('staff_contents', 'staff_contents.staff_id', '=', 'staff.id')
      ->where('staff.id', $appointment->staff_id)
      ->select('staff.id', 'staff.email', 'staff.phone', 'staff_contents.location', 'staff_contents.information', 'staff_contents.name')
      ->first();

    return view('vendors.appointment.details', $information);
  }

  public function destroy($id)
  {
    $appointment = ServiceBooking::where('vendor_id', Auth::guard('vendor')->user()->id)->findOrFail($id);
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
      $appointment = ServiceBooking::where('vendor_id', Auth::guard('vendor')->user()->id)->findOrFail($id);
      if (!empty($appointment->invoice)) {
        @unlink(public_path('assets/file/invoices/service/' . $appointment->invoice));
      }
      @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);
      $appointment->delete();
      $request->session()->flash('success', 'Appointments delete successfully!');
    }
    return Response::json(['status' => 'success'], 200);
  }

  //order status change
  public function updateAppointmentStatus(Request $request, $id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $booking = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->findOrFail($id);

    $vendor = Vendor::findOrFail($booking->vendor_id);

    if ($request['order_status'] == 'pending') {

      $booking->update([
        'order_status' => 'pending'
      ]);
      return redirect()->back()->with('success', 'Appointment status update successful!');
    } else if ($request['order_status'] == 'accepted') {
      $lessAppointmentNum = intval($vendor->total_appointment) - 1;

      $booking->update([
        'order_status' => 'accepted'
      ]);

      //update less appoitnment number
      $vendor->update([
        'total_appointment' => $lessAppointmentNum,
      ]);

      $purchaseProcess = new ServicePaymentController();
      // generate an invoice in pdf format
      $invoice = $purchaseProcess->generateInvoice($booking);

      // then, update the invoice field info in database
      $booking->update(['invoice' => $invoice]);

      // send a mail to the customer with the invoice for booking accepted
      $purchaseProcess->prepareMail($booking);

      return redirect()->back()->with('success', 'Appointment status update successful!');
    } else {
      //after reject
      $lessAppointmentNum = intval($vendor->total_appointment) + 1;
      $booking->update([
        'order_status' => 'rejected',
        'refund' => 'pending',
      ]);

      //update less appoitnment number
      $vendor->update([
        'total_appointment' => $lessAppointmentNum,
      ]);

      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'service_booking_rejected')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // get the website title info from db
      $info = Basic::select('website_title')->first();

      if ($booking->serviceContent->isNotEmpty()) {
        $service =  $booking->serviceContent->first()->name;
      }

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

      return redirect()->back()->with('success', 'Appointment status update successful!');
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
}
