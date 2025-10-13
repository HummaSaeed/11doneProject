<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Vendor;
use Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
  public function appointment(Request $request)
  {
    $misc = new MiscellaneousController();

    $language = $misc->getLanguage();
    $language_id = $language->id;

    $information['bgImg'] = $misc->getBreadcrumb();
    $information['pageHeading'] = $misc->getPageHeading($language);


    $information['appointments'] = ServiceBooking::join('service_contents', 'service_bookings.service_id', '=', 'service_contents.service_id')
    ->where('service_contents.language_id', $language_id)
    ->when($request->search_appointment, function ($query) use ($request) {
      $query->where(function ($subQuery) use ($request) {
        $subQuery->where('service_bookings.order_number', 'like', '%' . $request->search_appointment . '%')
          ->orWhere('service_contents.name', 'like', '%' . $request->search_appointment . '%');
      });
    })
    ->where('service_bookings.user_id', Auth::guard('web')->user()->id)
    ->orderBy('service_bookings.id', 'desc')
    ->select(
      'service_contents.name',
      'service_contents.slug',
      'service_bookings.id',
      'service_bookings.start_date',
      'service_bookings.end_date',
      'service_bookings.booking_date',
      'service_bookings.vendor_id',
      'service_bookings.order_status',
      'service_bookings.service_id',
    )
    ->paginate(10);


    return view('frontend.user.appointment.index', $information);
  }

  public function details($id)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $language_id = $language->id;


    $queryResult['bgImg'] = $misc->getBreadcrumb();
    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    $appointment = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($id);

    if ($appointment) {
      if ($appointment->user_id != Auth::guard('web')->user()->id) {
        return redirect()->route('user.dashboard');
      }
      $queryResult['appointment'] = $appointment;

      $queryResult['staff'] = Staff::join('staff_contents', 'staff_contents.staff_id', '=', 'staff.id')
        ->where('staff.id', $appointment->staff_id)
        ->select('staff.info_status', 'staff_contents.location', 'staff_contents.information', 'staff_contents.name')
        ->firstOrFail();

      if ($appointment->vendor_id != 0) {
        $queryResult['vendor'] = Vendor::join('vendor_infos', 'vendor_infos.vendor_id', 'vendors.id')
          ->where('vendors.id', $appointment->vendor_id)
          ->select('vendors.show_email_addresss', 'vendors.show_phone_number', 'vendors.email', 'vendors.phone', 'vendor_infos.name', 'vendor_infos.country', 'vendor_infos.city', 'vendor_infos.address', 'vendor_infos.details')
          ->firstOrFail();
      } else {
        $queryResult['vendor'] = Admin::whereNull('role_id')->firstOrFail();
      }

      return view('frontend.user.appointment.details', $queryResult);
    } else {
      return view('errors.404');
    }
  }
}
