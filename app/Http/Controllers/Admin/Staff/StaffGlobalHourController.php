<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminGlobalDay;
use App\Models\Staff\StaffGlobalDay;
use App\Models\Staff\StaffGlobalHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class StaffGlobalHourController extends Controller
{

  public function serviceHour(Request $request)
  {
    if (request()->vendor_id == 'admin') {
      $information['currentDay'] = AdminGlobalDay::where('id', $request->day_id)->select('day')->first();
    } else {
      $information['currentDay'] = StaffGlobalDay::where('id', $request->day_id)->select('day')->first();
    }

    if (request()->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = request()->vendor_id;
    }

    $information['service_hours'] = StaffGlobalHour::where('vendor_id', $vendor_id)
      ->where('global_day_id', $request->day_id)
      ->get();

    return view('admin.staff.global-hour.index', $information);
  }

  public function store(Request $request)
  {
    if ($request->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = $request->vendor_id;
    }

    if ($vendor_id != 0) {
      $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);
      if ($current_package == '[]') {
        $request->session()->flash('warning', 'Please buy a plan to add hour!');
        return Response::json(['status' => 'success'], 200);
      }
    }

    $rules = [
      'start_time' => 'required',
      'end_time' => 'required',
    ];

    $messages = [
      'start_time.required' => 'Start Time is required',
      'end_time.required' => 'End Time is required',
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
    $servicehour = new StaffGlobalHour();
    $servicehour->global_day_id = $request->global_day_id;
    $servicehour->start_time = $request->start_time;
    $servicehour->end_time =  $request->end_time;
    $servicehour->max_booking =  $request->max_booking;
    $servicehour->vendor_id = $vendor_id;
    $servicehour->save();

    $request->session()->flash('success', 'Time slot added successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function update(Request $request)
  {
    if ($request->vendor_id == 'admin') {
      $vendor_id = 0;
    } else {
      $vendor_id = $request->vendor_id;
    }

    $rules = [
      'start_time' => 'required',
      'end_time' => 'required',
    ];

    $messages = [
      'start_time.required' => 'Start Time is required',
      'end_time.required' => 'End Time is required',
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

    $servicehour = StaffGlobalHour::find($request->id);
    $servicehour->global_day_id = $request->global_day_id;
    $servicehour->start_time = $request->start_time;
    $servicehour->max_booking =  $request->max_booking;
    $servicehour->end_time =  $request->end_time;
    $servicehour->vendor_id = $vendor_id;
    $servicehour->save();

    session()->flash('success', 'Time slot updated successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function destroy($id)
  {
    $service_hour = StaffGlobalHour::query()->find($id);
    $service_hour->delete();
    return redirect()->back()->with('success', 'Time slot delete successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $service_hours = StaffGlobalHour::find($id);
      $service_hours->delete();
    }

    $request->session()->flash('success', 'Time slots delete successfully!');
    return Response::json(['status' => 'success'], 200);
  }
}
