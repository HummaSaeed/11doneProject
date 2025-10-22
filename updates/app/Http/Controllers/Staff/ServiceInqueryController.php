<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Services\InqueryMessage;
use App\Models\Staff\StaffService;
use Auth;
use Illuminate\Http\Request;

class ServiceInqueryController extends Controller
{

  public function message()
  {
       $language = Language::where('code', request()->language)->firstOrFail();
       $language_id = $language->id;
           $information['langs'] = Language::all();

    $staffId = Auth::guard('staff')->user()->id;
    $serviceIds = StaffService::where('staff_id', $staffId)->pluck('service_id')->toArray();

    $information['messages'] = InqueryMessage::whereIn('service_id', $serviceIds)
    ->with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->orderBy('id', 'DESC')
      ->get();

    return view('staffs.message', $information);
  }

  public function messageDestroy($id)
  {
    $message = InqueryMessage::find($id);
    $message->delete();

    return redirect()->back()->with('success', 'Message delete successfully!');
  }

  public function bulkDelete(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $message = InqueryMessage::where('vendor_id', Auth::guard('vendor')->user()->id)->find($id);

      if ($message) {
        $message->delete();
      }
    }

    $request->session()->flash('success', 'Message deleted successfully!');
    return response()->json(['status' => 'success'], 200);
  }
}
