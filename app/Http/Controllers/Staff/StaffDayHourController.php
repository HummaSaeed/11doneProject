<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffDay;
use App\Models\Staff\StaffServiceHour;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class StaffDayHourController extends Controller
{
  public function day()
  {
    $id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($id);
    $information['staff'] = $staff;

    $information['days'] = StaffDay::where('staff_id', $id)->get();
    if ($staff->time == 0) {
      return redirect()->route('staff.dashboard')->with('warning', 'You do not have permission to edit time slot!');
    } else {
      return view('staffs.time.day', $information);
    }
  }

  public function changeStaffSetting(Request $request, $id)
  {
    $id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($id);

    $staffday = Staff::where('vendor_id', $staff->vendor_id)->find($id);
    if ($staffday) {
      $staffday->is_day = $request->is_day;
      $staffday->save();
    }

    if ($staffday->is_day == 1) {
      return redirect()->back()->with('success', 'Staff schedule entered successfully!');
    } else {
      return redirect()->back()->with('success', 'Owner schedule entered successfully!');
    }
  }

  public function weekendChange(Request $request, $id)
  {
    $staff_id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($staff_id);

    $staffday = StaffDay::where('staff_id', $staff_id)->find($id);
    if ($staff->time == 0) {
      return redirect()->route('staff.dashboard')->with('warning', 'You do not have permission to edit time slot!');
    } else {

      if ($staffday) {
        $staffday->update(['is_weekend' => $request->is_weekend]);
      }
      return redirect()->back()->with('success', 'Weekend Change Successfully');
    }
  }

  public function hour(Request $request)
  {
    $id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($id);
    $information['staff'] = $staff;

    $information['currentDay'] = StaffDay::where('id', $request->day_id)
      ->where('staff_id', $id)
      ->select('day')
      ->firstOrFail();

    $information['service_hours'] = StaffServiceHour::where('staff_id', $id)
      ->where('staff_day_id', $request->day_id)
      ->get();
    if ($staff->time == 0) {
      return redirect()->route('staff.dashboard')->with('warning', 'You do not have permission to edit time slot!');
    } else {
      return view('staffs.time.servicehour.index', $information);
    }
  }

  public function store(Request $request)
  {
    $id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($id);

    if ($staff->time == 0) {
      $request->session()->flash('warning', 'You do not have permission to edit time slot!');
      return Response::json(['status' => 'success'], 200);
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

    $servicehour = new StaffServiceHour();
    $servicehour->staff_id = Auth::guard('staff')->user()->id;
    $servicehour->start_time = $request->start_time;
    $servicehour->end_time =  $request->end_time;
    $servicehour->max_booking =  $request->max_booking;
    $servicehour->staff_day_id = $request->staff_day_id;
    $servicehour->save();

    $request->session()->flash('success', 'Time slot added successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function update(Request $request)
  {
    $id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($id);

    if ($staff->time == 0) {
      $request->session()->flash('warning', 'You do not have permission to edit time slot!');
      return Response::json(['status' => 'success'], 200);
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

    $servicehour = StaffServiceHour::find($request->id);

    $servicehour->staff_id = $servicehour->staff_id;
    $servicehour->staff_day_id = $servicehour->staff_day_id;
    $servicehour->start_time = $request->start_time;
    $servicehour->end_time =  $request->end_time;
    $servicehour->max_booking =  $request->max_booking;
    $servicehour->update();

    $request->session()->flash('success', 'Time slot updated successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function destroy($id)
  {
    $staff_id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($staff_id);

    if ($staff->time == 0) {
      return redirect()->back()->with('warning', 'You do not have permission to edit time slot!');
    }

    if ($staff->time == 0) {
      return redirect()->route('staff.dashboard')->with('warning', 'You do not have permission to edit time slot!');
    }

    $service_hour = StaffServiceHour::query()->find($id);

    $service_hour->delete();
    return redirect()->back()->with('success', 'Time slot delete successfully');
  }

  public function bulkDestroy(Request $request)
  {
    $id = Auth::guard('staff')->user()->id;
    $staff = Staff::find($id);

    if ($staff->time == 0) {
      $request->session()->flash('warning', 'You do not have permission to edit time slot!');
      return Response::json(['status' => 'success'], 200);
    }

    $ids = $request->ids;

    foreach ($ids as $id) {
      $service_hours = StaffServiceHour::find($id);
      $service_hours->delete();
    }

    $request->session()->flash('success', 'Time slots delete successfully');
    return Response::json(['status' => 'success'], 200);
  }
}
