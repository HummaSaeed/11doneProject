<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Staff\StaffGlobalHoliday;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;
use Validator;

class GlobalHolidayController extends Controller
{
  public function index(Request $request)
  {
    if ($request->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = $request->vendor_id;
    }

    if ($request->vendor_id) {
      if ($vendor_id != 0 || $vendor_id == 0) {
        if ($vendor_id != 0) {
          $current_package = VendorPermissionHelper::packagePermission($vendor_id);
          if ($current_package == '[]') {
            return redirect()->back()->with('warning', 'This vendor is not available!');
          }
        }
        $vendors = Vendor::join('memberships', 'vendors.id', '=', 'memberships.vendor_id')
          ->where([
            ['memberships.status', '=', 1],
            ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
            ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')]
          ])
          ->select('vendors.id', 'vendors.username')
          ->get();

        $globalHoliday = StaffGlobalHoliday::where('vendor_id', $vendor_id)->get();

        return view('admin.staff.global-holiday.index', compact('globalHoliday', 'vendors'));
      }
    } else {
      return redirect()->back()->with('warning', 'This vendor is not available!');
    }
  }

  public function store(Request $request)
  {
    if ($request->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = $request->vendor_id;
    }

    $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);

    if ($vendor_id != 0) {
      $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);
      if ($current_package == '[]') {
        $request->session()->flash('warning', 'No packages available for this vendor!');
        return Response::json(['status' => 'success'], 200);
      }
    }
    $rules = ['date' => 'required',];
    $messages = ['date.required' => 'The date field is required',];

    $validator = Validator::make($request->all(), $rules, $messages);
    if ($validator->fails()) {
      return Response::json(
        [
          'errors' => $validator->getMessageBag()->toArray()
        ],
        400
      );
    }

    $holiday = StaffGlobalHoliday::where('vendor_id', $vendor_id)->pluck('date')->toArray();
    $date = date('Y-m-d', strtotime($request->date));

    if (in_array($date, $holiday)) {
      $request->session()->flash('warning', 'The date exists in the holiday list!');
      return Response::json(['status' => 'success'], 200);
    } else {
      StaffGlobalHoliday::create([
        'date' => $date,
        'vendor_id' => $vendor_id,
      ]);
      $request->session()->flash('success', 'Holiday added successfully!');

      return Response::json(['status' => 'success'], 200);
    }
  }

  public function destroy($id)
  {
    $UserStaffHoliday = StaffGlobalHoliday::find($id);
    $UserStaffHoliday->delete();
    return redirect()->back()->with('success', 'Holiday delete successfully!');
  }

  public function blukDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $UserStaffHoliday = StaffGlobalHoliday::find($id);
      $UserStaffHoliday->delete();
    }

    $request->session()->flash('success', 'Holiday delete successfully!');
    return Response::json(['status' => 'success'], 200);
  }
}
