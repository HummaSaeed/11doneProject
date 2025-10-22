<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Services\InqueryMessage;
use App\Models\Vendor;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceInqController extends Controller
{
  public function message(Request $request)
  {
    $vendor_id  = null;
    if ($request->filled('vendor_id')) {
      $vendor_id = $request->vendor_id;
    }
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $information['vendors'] = Vendor::join('memberships', 'vendors.id', '=', 'memberships.vendor_id')
      ->where([
        ['memberships.status', '=', 1],
        ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])
      ->select('vendors.id', 'vendors.username')
      ->get();

    $information['messages'] = InqueryMessage::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($vendor_id, function ($query) use ($vendor_id) {
        if ($vendor_id == 'admin') {
          return $query->where('vendor_id', '0');
        } else {
          return $query->where('vendor_id', $vendor_id);
        }
      })
      ->orderBy('id', 'desc')
      ->paginate(10);

    return view('admin.email.message', $information);
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
