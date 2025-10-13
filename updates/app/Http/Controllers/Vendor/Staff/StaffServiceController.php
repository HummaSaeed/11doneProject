<?php

namespace App\Http\Controllers\Vendor\Staff;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Services\ServiceCategory;
use App\Models\Services\Services;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffService;
use Auth;
use Illuminate\Http\Request;
use Response;
use Validator;

class StaffServiceController extends Controller
{
  public function index($id, Request $request)
  {
    $language = Language::where('code', $request->language)->first();
    $language_id = $language->id;

    $information['langs'] = Language::all();
    $information['staff'] = Staff::where('vendor_id', Auth::guard('vendor')->user()->id)->findOrFail($id);

    $information['staffServices'] = StaffService::with(['staffContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }, 'service' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('vendor_id', Auth::guard('vendor')->user()->id)->where('staff_id', $id)->orderByDesc('id')->get();


    $information['services'] = Services::join('service_contents', 'services.id', '=', 'service_contents.service_id')
      ->where('services.vendor_id', Auth::guard('vendor')->user()->id)
      ->where('service_contents.language_id', $language->id)
      ->select('services.id as id', 'service_contents.name as name')
      ->get();

    return view('vendors.staff.staff-services.service_assign', $information);
  }


  public function getServiceCategory($id, Request $request)
  {
    $language = Language::where('code', $request->language)->first();
    $categories = ServiceCategory::join('service_category_contents', 'service_categories.id', '=', 'service_category_contents.service_category_id')
      ->join('services', 'service_category_contents.service_id', '=', 'services.id')
      ->where('services.id', $id)
      ->where('service_category_contents.language_id', $language->id)
      ->select('service_categories.id as id', 'service_category_contents.name as name')
      ->get();

    return response()->json($categories);
  }



  public function store(Request $request)
  {
    $staffServices = StaffService::where('staff_id', $request->staff_id)->where('service_id', $request->service_id)->get();

    $rules = [
      'service_id' => 'required',
    ];

    $messages = [
      'service_id.required' => "The service field is required",
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
        'vendor_id' => Auth::guard('vendor')->user()->id,
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
    $staffService = StaffService::query()->where('vendor_id', Auth::guard('vendor')->user()->id)->findOrFail($id);

    $mainService = Services::findOrFail($staffService->service_id);
    $mainService->update(['staff_id' => null]);

    $staffService->delete();
    return redirect()->back()->with('success', 'Staff service deleted successfully!');
  }

  public function blukDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $staffService = StaffService::query()->where('vendor_id', Auth::guard('vendor')->user()->id)->findOrFail($id);

      $mainService = Services::findOrFail($staffService->service_id);
      $mainService->update(['staff_id' => null]);

      $staffService->delete();
    }

    $request->session()->flash('success', 'Staff service successfully!');
    return response()->json(['status' => 'success'], 200);
  }
}
