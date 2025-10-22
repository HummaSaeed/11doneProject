<?php

namespace App\Http\Controllers\Vendor\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffGlobalDay;
use App\Models\Staff\StaffGlobalHour;
use Auth;
use Illuminate\Http\Request;

class StaffGlobalDayController extends Controller
{
  public function index()
  {
    $information['days'] = StaffGlobalDay::where('vendor_id', Auth::guard('vendor')->user()->id)->get();

    return view('vendors.staff.global-day.index', $information);
  }


  public function weekendChange(Request $request, $id)
  {
    $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);

    if ($current_package == '[]') {
      return redirect()->back()->with('warning', 'Please buy a plan to make changes');
    } else {
      $hour = StaffGlobalHour::where('vendor_id', Auth::guard('vendor')->user()->id)->where('global_day_id', $id)->get();

      if ($hour->count() > 0) {
        return redirect()->back()->with('warning', 'First delete all the time slots of this day!');
      } else {
        $staffGlobalDay = StaffGlobalDay::find($id);
        $staffGlobalDay->update(['is_weekend' => $request->is_weekend]);
        return redirect()->back()->with('success', 'Weekend change successfully');
      }
    }
  }
}
