<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Admin\AdminGlobalDay;
use App\Models\Staff\StaffGlobalDay;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffGlobalDayController extends Controller
{
  public function index(Request $request)
  {
    $information['vendors'] = Vendor::join('memberships', 'vendors.id', '=', 'memberships.vendor_id')
      ->where([
        ['memberships.status', '=', 1],
        ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])
      ->select('vendors.id', 'vendors.username')
      ->get();

    if ($request->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = $request->vendor_id;
    }
    if ($request->vendor_id) {
      if ($vendor_id != 0) {
        $current_package = VendorPermissionHelper::packagePermission($vendor_id);
        if ($current_package != '[]') {
          $information['days'] = StaffGlobalDay::where('vendor_id', $vendor_id)->get();
        } else {
          return redirect()->back()->with('warning', 'This vendor is not available!');
        }
      } else {
        $information['days'] = AdminGlobalDay::all();
      }
      return view('admin.staff.global-day.index', $information);
    } else {
      return redirect()->back()->with('warning', 'This vendor is not available!');
    }
  }

  public function weekendChange(Request $request, $id)
  {
    if ($request->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = $request->vendor_id;
    }

    if ($vendor_id != 0) {
      $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);
      if ($current_package == '[]') {
        return redirect()->back()->with('warning', 'No packages available for this vendor!');
      }
    }

    if ($vendor_id != 0) {
      $hour = StaffGlobalHour::where('vendor_id', $vendor_id)->where('global_day_id', $id)->get();
      if ($hour->count() > 0) {
        return redirect()->back()->with('warning', 'First delete all the time slots of this day!');
      } else {
        $staffGlobalDay =  StaffGlobalDay::find($id);
      }
    } else {
      $hour = StaffGlobalHour::where('vendor_id', $vendor_id)->where('global_day_id', $id)->get();
      if ($hour->count() > 0) {
        return redirect()->back()->with('warning', 'First delete all the time slots of this day!');
      } else {
        $staffGlobalDay = AdminGlobalDay::find($id);
      }
    }
    if ($staffGlobalDay) {
      $staffGlobalDay->update(['is_weekend' => $request->is_weekend]);
      return redirect()->back()->with('success', 'Weekend change successfully');
    }
  }
}
