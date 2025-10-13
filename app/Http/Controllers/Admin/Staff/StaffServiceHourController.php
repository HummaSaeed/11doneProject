<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffDay;
use App\Models\Staff\StaffServiceHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class StaffServiceHourController extends Controller
{
  public function day($id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $information['staff'] = Staff::with(['StaffContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($id);


    $information['days'] = StaffDay::where('staff_id', $id)
      ->where('vendor_id', request()->vendor_id)->get();

    return view('admin.staff.staff-day.index', $information);
  }

  public function index(Request $request)
  {

    $information['currentDay'] = StaffDay::where('id', $request->day_id)->select('day')->first();
    $information['staff'] = Staff::find($request->staff_id);
    $information['service_hours'] = StaffServiceHour::where('staff_id', $request->staff_id)
      ->where('staff_day_id', $request->day_id)
      ->get();
    return view('admin.staff.staff-hour.index', $information);
  }

  public function weekendChange(Request $request, $id)
  {
    $staffday = StaffDay::where('staff_id', $request->staff_id)->find($id);

    $hour = StaffServiceHour::where('staff_id', $request->staff_id)->where('staff_day_id', $id)->get();
    if ($hour->count() > 0) {
      return redirect()->back()->with('warning', 'First delete all the time slots of this day!');
    } else {

      if ($staffday) {
        $staffday->update(['is_weekend' => $request->is_weekend]);
      }
      return redirect()->back()->with('success', 'Weekend change successfully');
    }
  }


  public function store(Request $request)
  {
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
    $servicehour->staff_id = $request->staff_id;
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
    $service_hour = StaffServiceHour::query()->find($id);
    $service_hour->delete();
    return redirect()->back()->with('success', 'Time slot delete successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $service_hours = StaffServiceHour::find($id);
      $service_hours->delete();
    }

    $request->session()->flash('success', 'Time slots delete successfully!');
    return Response::json(['status' => 'success'], 200);
  }
}
