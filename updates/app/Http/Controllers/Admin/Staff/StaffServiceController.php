<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Services\Services;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffService;
use Illuminate\Http\Request;
use Response;
use Validator;

class StaffServiceController extends Controller
{
  public function index($id)
  {
    $language = Language::where('is_default', 1)->first();
    $information['language'] = $language;
    $information['staff'] = Staff::findOrFail($id);

    $information['langs'] = Language::all();
    $language_id = $language->id;

    $vendor_id = request()->vendor_id;

    $information['staffServices'] = StaffService::with(['staffContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }, 'service' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('vendor_id', $vendor_id)
      ->where('staff_id', $id)
      ->get();



    $information['services'] = Services::join('service_contents', function ($join) use ($language_id) {
      $join->on('services.id', '=', 'service_contents.service_id')
        ->where('service_contents.language_id', '=', $language_id);
    })
      ->where('services.vendor_id', $vendor_id)
      ->select('services.id as id', 'service_contents.name as name')
      ->get();


    return view('admin.staff.staff-services.service_assign', $information);
  }

  public function store(Request $request)
  {
    $staffServices = StaffService::where('staff_id', $request->staff_id)->where('service_id', $request->service_id)->get();

    $rules = [
      'service_id' => 'required',
    ];

    $messages = [
      'service_id.required' => 'The service field is required',
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }

    if ($staffServices->count() > 0) {
      $request->session()->flash("warning", "You can\'t add the same service multiple times!");
      return Response::json(['status' => 'success'], 200);
    } else {
      StaffService::create([
        'vendor_id' => request()->vendor_id,
        'service_id' => $request->service_id,
        'staff_id' => $request->staff_id,
      ]);

      $mainService = Services::findOrFail($request->service_id);
      $mainService->update(['staff_id' => $request->staff_id]);

      $request->session()->flash('success', 'New staff service added successfully!');
      return Response::json(['status' => 'success'], 200);
    }
  }


  public function destroy($id)
  {
    $staffService = StaffService::find($id);
    $mainService = Services::findOrFail($staffService->service_id);
    $mainService->update(['staff_id' => null]);
    $staffService->delete();
    return redirect()->back()->with('success', 'Staff service deleted successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $staffService = StaffService::find($id);

      $mainService = Services::findOrFail($staffService->service_id);
      $mainService->update(['staff_id' => null]);

      $staffService->delete();
    }
    $request->session()->flash('success', 'Services deleted successfully!');
    return response()->json(['status' => 'success'], 200);
  }
}
