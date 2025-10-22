<?php

namespace App\Http\Controllers\Vendor\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\StaffGlobalHoliday;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class GlobalHolidayController extends Controller
{
  public function index()
  {
    $globalHoliday = StaffGlobalHoliday::where('vendor_id', Auth::guard('vendor')->user()->id)->get();
    return view('vendors.staff.global-holiday.index', compact('globalHoliday'));
  }

  public function store(Request $request)
  {
    $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);

    if ($current_package == '[]') {
      $request->session()->flash('warning', 'Please buy a plan to add holiday!');
      return Response::json(['status' => 'success'], 200);
    } else {
      $rules = [
        'date' => 'required',
      ];

      $messages = [
        'date.required' => 'The date field is required',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
        return Response::json(
          [
            'errors' => $validator->getMessageBag()->toArray()
          ],
          400
        );
      }

      $holiday = StaffGlobalHoliday::where('vendor_id', Auth::guard('vendor')->user()->id)->pluck('date')->toArray();
      $date = date('Y-m-d', strtotime($request->date));
      if (in_array($date, $holiday)) {
        $request->session()->flash('warning', 'The date exists in the holiday list!');
        return Response::json(['status' => 'success'], 200);
      } {
        StaffGlobalHoliday::create([
          'date' => $date,
          'vendor_id' => Auth::guard('vendor')->user()->id
        ]);
        $request->session()->flash('success', 'Holiday added successfully!');

        return Response::json(['status' => 'success'], 200);
      }
    }
  }

  public function destroy(Request $request, $id)
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
