<?php

namespace App\Http\Controllers\Vendor\Staff;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Http\Helpers\VendorPermissionHelper;
use App\Http\Requests\Staff\StaffStoreRequest;
use App\Http\Requests\Staff\StaffUpdateRequest;
use App\Models\Language;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffContent;
use App\Models\Staff\StaffDay;
use App\Models\Staff\StaffHoliday;
use App\Models\Staff\StaffPlugin;
use App\Models\Staff\StaffService;
use App\Models\Staff\StaffServiceHour;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Response;
use Session;
use Validator;

class StaffController extends Controller
{
  public function index()
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $information['language'] = $language;
    $language_id = $language->id;

    $information['langs'] = Language::all();


    $information['staffs'] = Staff::with([
      'StaffContent' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      },
    ])
      ->whereNull('role')
      ->where('staff.vendor_id', Auth::guard('vendor')->user()->id)
      ->orderBy('id', 'desc')
      ->get();

    return view('vendors.staff.staff', $information);
  }

  public function create()
  {
    $information['languages'] = Language::all();
    $information['currencyInfo'] = $this->getCurrencyInfo();
    return view('vendors.staff.add-staff', $information);
  }

  public function store(StaffStoreRequest $request)
  {
    if ($request->hasFile('staff_image')) {
      $staffImage = UploadFile::store(public_path('assets/img/staff/'), $request->file('staff_image'));
    }
    $staff = Staff::create([
      'username' =>  $request->username !== null ? $request->username : null,
      'password' => $request->password !== null ? Hash::make($request->password) : null,
      'vendor_id' => Auth::guard('vendor')->user()->id,
      'email' => $request->email,
      'phone' => $request->phone,
      'image' => $staffImage,
      'status' => $request->status,
      'email_status' => $request->show_email_addresss ?? 0,
      'info_status' => $request->show_information ?? 0,
      'phone_status' => $request->show_phone ?? 0,
      'order_number' => $request->order_number,
      'allow_login' => $request->login_allow_toggle,
    ]);

    $languages = Language::all();
    foreach ($languages as $language) {
      if (
        $language->is_default == 1 ||
        $request->filled($language->code . '_name') ||
        $request->filled($language->code . '_location') ||
        $request->filled($language->code . '_information')
      ) {
        StaffContent::create([
          'language_id' => $language->id,
          'staff_id' => $staff->id,
          'name' => $request[$language->code . '_name'],
          'location' => $request[$language->code . '_location'],
          'information' =>
          $request[$language->code . '_information'],
        ]);
      }
    }

    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    foreach ($days as $key => $day) {
      $staffHoliday = new StaffDay();
      $staffHoliday->staff_id = $staff->id;
      $staffHoliday->vendor_id = Auth::guard('vendor')->user()->id;
      $staffHoliday->day = $day;
      $staffHoliday->indx = $key;
      $staffHoliday->save();
    }

    $request->session()->flash('success', 'New staff added successfully!');
    return 'success';
  }


  public function edit($id)
  {
    $language = Language::query()->where('is_default', '=', 1)->first();
    $language_id = $language->id;


    $current_package = VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);

    if ($current_package == '[]') {
      session()->flash('warning', 'Please buy a package to use this panel!');
      return redirect()->route('vendor.staff_managment', ['language' => $language->code]);
    } else {
      $information['languages'] = Language::all();
      $vendorId = Auth::guard('vendor')->user()->id;

      $information['staff'] = Staff::with(['StaffContent' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      }])
        ->where('vendor_id', $vendorId)->findOrFail($id);

      return view('vendors.staff.edit-staff', $information);
    }
  }

  public function update($id, StaffUpdateRequest $request)
  {
    $staff = Staff::where('vendor_id', Auth::guard('vendor')->user()->id)
      ->find($id);

    if ($request->hasFile('staff_image')) {
      $staffImage = UploadFile::update(public_path('assets/img/staff/'), $request->staff_image, $staff->image);
    }

    $staff->update([
      'username' =>  $request->login_allow_toggle == 0 ? NULL : $request->username,
      'password' => $request->login_allow_toggle == 0 ? NULL : $staff->password,
      'vendor_id' => Auth::guard('vendor')->user()->id,
      'email' => $request->email,
      'phone' => $request->phone,
      'image' => $request->hasFile('staff_image') ? $staffImage : $staff->image,
      'order_number' => $request->order_number,
      'status' => $request->status,
      'email_status' => $request->show_email_addresss ?? 0,
      'info_status' => $request->show_information ?? 0,
      'phone_status' => $request->show_phone ?? 0,
      'allow_login' => $request->login_allow_toggle,
    ]);

    $languages = Language::all();

    foreach ($languages as $language) {
      $staffContent = StaffContent::where('language_id', $language->id)->where('staff_id', $staff->id)->first();
      if (empty($staffContent)) {
        $staffContent = new StaffContent();
      }

      if (
        $language->is_default == 1 ||
        $request->filled($language->code . '_name') ||
        $request->filled($language->code . '_location') ||
        $request->filled($language->code . '_information')
      ) {
        $staffContent->language_id = $language->id;
        $staffContent->staff_id = $staff->id;
        $staffContent->name = $request[$language->code . '_name'];
        $staffContent->location = $request[$language->code . '_location'];
        $staffContent->information =   $request[$language->code . '_information'];
        $staffContent->save();
      }
    }

    Session::flash('success', 'Staff update successfully!');
    return 'success';
  }

  public function destroy($id)
  {
    StaffHoliday::where('staff_id', $id)->delete();
    StaffService::where('staff_id', $id)->delete();
    StaffServiceHour::where('staff_id', $id)->delete();
    StaffDay::where('staff_id', $id)->delete();
    $staff = Staff::where('vendor_id', Auth::guard('vendor')->user()->id)->findOrFail($id);

    /**
     * update staff appointment
     */
    $appointments = ServiceBooking::where('staff_id', $id)->get();
    foreach ($appointments as $appointment) {
      $appointment->update([
        'staff_id' => null,
      ]);
    }

    /**
     * delete staff content
     */
    $staffcontent = $staff->StaffContent()->get();
    // unlink staff_image
    @unlink(public_path('assets/img/staff/') . $staff->image);
    foreach ($staffcontent as $content) {
      $content->delete();
    }
    $staff->delete();

    /**
     * delete staff plguin
     */
    $staffPlugin = StaffPlugin::where('staff_id', $id)->first();
    if ($staffPlugin) {
      @unlink(public_path('assets/file/calendar/' . $staffPlugin->google_calendar));
      $staffPlugin->delete();
    }

    return redirect()->back()->with('success', 'Service deleted successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      StaffHoliday::where('staff_id', $id)->delete();
      StaffService::where('staff_id', $id)->delete();
      StaffServiceHour::where('staff_id', $id)->delete();
      StaffDay::where('staff_id', $id)->delete();
      $staff = Staff::find($id);

      /**
       * delete staff content
       */
      if ($staff) {
        $staffContent = StaffContent::where('staff_id', $staff->id)->get();
        @unlink(public_path('assets/img/staff/') . $staff->image);
        foreach ($staffContent as $content) {
          $content->delete();
        }
        $staff->delete();
      }

      /**
       * update staff appointment
       */
      $appointments = ServiceBooking::where('staff_id', $id)->get();
      foreach ($appointments as $appointment) {
        $appointment->update([
          'staff_id' => null,
        ]);
      }

      /**
       * delete staff plguin
       */
      $staffPlugin = StaffPlugin::where('staff_id', $id)->first();
      if ($staffPlugin) {
        @unlink(public_path('assets/file/calendar/' . $staffPlugin->google_calendar));
        $staffPlugin->delete();
      }
    }
    $request->session()->flash('success', 'Staffs deleted successfully!');
    return response()->json(['status' => 'success'], 200);
  }

  public function staffstatus(Request $request)
  {
    $language = Language::query()->where('is_default', '=', 1)->first();
    $current_package = VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
    if ($current_package == '[]') {
      session()->flash('warning', 'Please buy a package to use this panel!');
      return redirect()->route('vendor.staff_managment', ['language' => $language->code]);
    } else {
      $staff = Staff::where('id', $request->staff_id)->first();

      $staff->update([
        'status' => $request->status,
      ]);
      $request->session()->flash('success', 'Status update successfully!');
      return back();
    }
  }

  public function secret_login($id)
  {
    Session::put('secret_login', 1);
    $staff = Staff::where('id', $id)->first();
    Auth::guard('staff')->login($staff);
    return redirect()->route('staff.dashboard');
  }


  public function permission($id)
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $information['staff'] = Staff::with(['StaffContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->select('id', 'service_add', 'service_edit', 'service_delete', 'time')->findOrFail($id);
    return view('vendors.staff.permission', $information);
  }

  public function changePassword($id)
  {
    $staffInfo = Staff::findOrFail($id);

    return view('vendors.staff.change-password', compact('staffInfo'));
  }

  public function updatePassword(Request $request, $id)
  {
    $rules = [
      'new_password' => 'required|confirmed',
      'new_password_confirmation' => 'required'
    ];

    $messages = [
      'new_password.confirmed' => 'Password confirmation does not match.',
      'new_password_confirmation.required' => 'The confirm new password field is required.'
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }

    $staff = Staff::find($id);

    $staff->update([
      'password' => Hash::make($request->new_password)
    ]);

    Session::flash('success', 'Password updated successfully!');

    return Response::json(['status' => 'success'], 200);
  }

  public function permissionUpdate($id, Request $request)
  {
    $staff = Staff::findOrFail($id);
    $staff->update([
      'service_add' => $request->service_add ? $request->service_add : 0,
      'service_edit' => $request->service_edit ? $request->service_edit : 0,
      'service_delete' => $request->service_delete ? $request->service_delete : 0,
      'time' => $request->time ? $request->time : 0,
    ]);

    return redirect()->back()->with('success', 'Permission update successfull');
  }
}
