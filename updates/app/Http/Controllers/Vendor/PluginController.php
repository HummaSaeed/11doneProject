<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\VendorPlugins\VendorPlugin;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;
use Validator;

class PluginController extends Controller
{
  public function index()
  {
    $permission = VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);

    if ($permission->calendar_status == 0 && $permission->zoom_meeting_status == 0) {
      return redirect()->back();
    }
    $data = VendorPlugin::where('vendor_id', Auth::guard('vendor')->user()->id)
      ->select('zoom_account_id', 'zoom_client_id', 'zoom_client_secret', 'google_calendar', 'calender_id')
      ->first();

    return view('vendors.plugins.index', compact('data'));
  }

  public function zoomUpdate(Request $request)
  {
    $rules = [
      'zoom_account_id' => 'required',
      'zoom_client_id' => 'required',
      'zoom_client_secret' => 'required',
    ];

    $messages = [
      'zoom_account_id.required' => 'The zoom account id field is required.',
      'zoom_client_id.required' => 'The zoom client id field is required.',
      'zoom_client_secret.required' => 'The zoom client secret field is required.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors());
    }

    DB::table('vendor_plugins')->updateOrInsert(
      ['vendor_id' => Auth::guard('vendor')->user()->id],
      [
        'vendor_id' => Auth::guard('vendor')->user()->id,
        'zoom_account_id' => $request->zoom_account_id,
        'zoom_client_id' => $request->zoom_client_id,
        'zoom_client_secret' => $request->zoom_client_secret,
      ]
    );

    Session::flash('success', 'Zoom info updated successfully!');

    return redirect()->back();
  }



  public function updateCalendar(Request $request)
  {
    $data = VendorPlugin::where('vendor_id', Auth::guard('vendor')->user()->id)
      ->select('google_calendar')
      ->first();

    $request->validate([
      'google_calendar' => 'required|mimes:json',
      'calender_id' => 'required',
    ], [
      'google_calendar.required' => 'The google calendar file is required.',
      'google_calendar.mimes' => 'Only JSON files are supported for Google Calendar.',
    ]);

    // Store the uploaded file
    $file = UploadFile::store(public_path('assets/file/calendar/'), $request->file('google_calendar'));

    // Update or insert into the database
    VendorPlugin::query()->updateOrInsert(
      ['vendor_id' => Auth::guard('vendor')->user()->id],
      [
        'vendor_id' => Auth::guard('vendor')->user()->id,
        'google_calendar' => $request->hasFile('google_calendar') ? $file : $data->google_calendar,
        'calender_id' => $request->calender_id,
      ]
    );

    // Flash success message
    $request->session()->flash('success', 'Calendar info updated successfully!');

    // Redirect back to the previous page
    return redirect()->back();
  }
}
