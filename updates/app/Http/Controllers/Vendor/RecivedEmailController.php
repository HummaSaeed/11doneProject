<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Services\InqueryMessage;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Session;

class RecivedEmailController extends Controller
{
  public function mailToAdmin()
  {
    $data = DB::table('vendors')->where('id', Auth::guard('vendor')->user()->id)->select('recived_email')->first();
    return view('vendors.email.mail-to-vendor', compact('data'));
  }

  public function updateMailToAdmin(Request $request)
  {
    $rule = [
      'to_mail' => 'required'
    ];

    $message = [
      'to_mail.required' => 'The mail address field is required.'
    ];

    $validator = Validator::make($request->all(), $rule, $message);


    if ($validator->fails()) {
      return Response::json(
        [
          'errors' => $validator->getMessageBag()->toArray()
        ],
        400
      );
    }

    DB::table('vendors')->updateOrInsert(
      ['id' => Auth::guard('vendor')->user()->id],
      ['recived_email' => $request->to_mail]
    );

    Session::flash('success', 'Mail info updated successfully!');

    return redirect()->back();
  }

  public function message()
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $information['messages'] = InqueryMessage::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->orderBy('id', 'DESC')
      ->get();
    return view('vendors.email.message', $information);
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
