<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Language;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Vendor;
use Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
  public function index(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $orderNumber =  $paymentStatus = $orderStatus = $refundStatus = null;
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
      ->where('staff_id', Auth::guard('staff')->user()->id)
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
    return view('staffs.appointment.all', $information);
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
      ->where('staff_id', Auth::guard('staff')->user()->id)
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->where('order_status', 'pending')
      ->orderByDesc('id')
      ->paginate(10);
    return view('staffs.appointment.pending', $information);
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
      ->where('staff_id', Auth::guard('staff')->user()->id)
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->where('order_status', 'accepted')->orderByDesc('id')
      ->paginate(10);;
    return view('staffs.appointment.accepted', $information);
  }

  public function rejectedAppointment(Request $request)
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
      ->where('staff_id', Auth::guard('staff')->user()->id)
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->when($refundStatus, function ($query, $refundStatus) {
        return $query->where('refund', '=', $refundStatus);
      })
      ->where('order_status', 'rejected')->orderByDesc('id')
      ->paginate(10);;
    return view('staffs.appointment.rejected', $information);
  }

  public function show($id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $details = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('staff_id', Auth::guard('staff')->user()->id)
      ->findOrFail($id);

    $information['details'] = $details;

    //vendor info
    if ($details->vendor_id != 0) {
      $information['vendor_details'] = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', '=', 'vendors.id')
        ->where('vendors.id', $details->vendor_id)
        ->first();
    } else {
      $information['vendor_details'] = Admin::whereNull('role_id')->first();
    }

    //staff info
    $information['staff'] = Staff::join('staff_contents', 'staff_contents.staff_id', '=', 'staff.id')
      ->where('staff.id', $details->staff_id)
      ->select('staff.id', 'staff.email', 'staff.phone', 'staff_contents.location', 'staff_contents.information', 'staff_contents.name')
      ->first();

    return view('staffs.appointment.details', $information);
  }
}
