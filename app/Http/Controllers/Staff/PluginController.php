<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffPlugin;
use Auth;
use Illuminate\Http\Request;

class PluginController extends Controller
{
  public function index()
  {
    $vendorId = Staff::where('id', Auth::guard('staff')->user()->id)->value('vendor_id');
    $permission = $vendorId != 0 ? VendorPermissionHelper::packagePermission($vendorId) : null;

    if ($permission && $permission->calendar_status == 0 && $permission->zoom_meeting_status == 0) {
      return redirect()->back();
    }

    return view('staffs.plugins.index', [
      'vendorId' => $vendorId,
      'packagePersmission' => $permission,
      'data' => StaffPlugin::where('staff_id', Auth::guard('staff')->user()->id)->first(['google_calendar', 'calender_id'])
    ]);
  }



  public function updateCalendar(Request $request)
  {
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
    StaffPlugin::query()->updateOrInsert(
      ['staff_id' => Auth::guard('staff')->user()->id],
      [
        'staff_id' => Auth::guard('staff')->user()->id,
        'google_calendar' => $file,
        'calender_id' => $request->calender_id,
      ]
    );

    // Flash success message
    $request->session()->flash('success', 'Calendar info updated successfully!');

    // Redirect back to the previous page
    return redirect()->back();
  }
}
