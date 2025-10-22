<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
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
use App\Models\Vendor;
use Auth;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Response;
use Session;
use Validator;

class StaffController extends Controller
{
  public function index(Request $request)
  {
    $language = Language::where('code', $request->language)->firstOrFail();
    $language_id = $language->id;

    $information['langs'] = Language::all();

    $vendor_id  = $staffName = null;
    if ($request->filled('vendor_id')) {
      $vendor_id = $request->vendor_id;
    }

    if ($request->filled('name')) {
      $staffName = $request['name'];
    }

    $staffIds = [];
    if (request()->filled('name')) {
      $name = $request->name;
      $staff_contents = StaffContent::where([['name', 'like', '%' . $name . '%'], ['language_id', $language->id]])->get();
      foreach ($staff_contents as $staff_content) {
        if (!in_array($staff_content->staff_id, $staffIds)) {
          array_push($staffIds, $staff_content->staff_id);
        }
      }
    }

    $information['vendors'] = Vendor::join('memberships', 'vendors.id', '=', 'memberships.vendor_id')
      ->where([
        ['memberships.status', '=', 1],
        ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])
      ->select('vendors.id', 'vendors.username')
      ->get();

    $information['staffs'] = Staff::with([
      'StaffContent' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      },
      'vendor'
    ])
      ->whereNull('role')
      ->when($vendor_id, function ($query) use ($vendor_id) {
        if ($vendor_id == 'admin') {
          return $query->where('vendor_id', '0');
        } else {
          return $query->where('vendor_id', $vendor_id);
        }
      })
      ->when($staffName, function ($query) use ($staffIds) {
        return $query->whereIn('id', $staffIds);
      })
      ->orderBy('id', 'desc')
      ->paginate(10);

    return view('admin.staff.staff', $information);
  }
  public function checkPackge(Request $request)
  {
    if ($request->vendor_id != 0) {
      $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($request->vendor_id);
      $staffLitmit = vendorTotalAddedStaff($request->vendor_id) >= $current_package->staff_limit;

      if ($current_package == '[]' || $staffLitmit) {
        return response()->json('success');
      }
    }
  }
  public function create()
  {
    $information['vendors'] = Vendor::join('memberships', 'vendors.id', '=', 'memberships.vendor_id')
      ->where([
        ['memberships.status', '=', 1],
        ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])
      ->where('vendors.status', 1)
      ->select('vendors.id', 'vendors.username')
      ->get();

    $information['languages'] = Language::all();
    $information['currencyInfo'] = $this->getCurrencyInfo();
    return view('admin.staff.add-staff', $information);
  }

  public function store(StaffStoreRequest $request)
  {
    $staffImage = null;

    if ($request->hasFile('staff_image') && $request->file('staff_image')->isValid()) {
      $staffImage = UploadFile::store(public_path('assets/img/staff/'), $request->file('staff_image'));
    }

    $staffData = [
      'username' => $request->filled('username') ? $request->username : null,
      'password' => $request->filled('password') ? Hash::make($request->password) : null,
      'vendor_id' => $request->vendor_id,
      'email' => $request->email,
      'phone' => $request->phone,
      'image' => $staffImage,
      'status' => $request->status,
      'email_status' => $request->show_email_addresss ?? 0,
      'info_status' => $request->show_information ?? 0,
      'phone_status' => $request->show_phone ?? 0,
      'order_number' => $request->order_number,
      'allow_login' => $request->login_allow_toggle,
    ];

    if ($request->vendor_id != 0) {
      $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($request->vendor_id);
      $staffLimit = vendorTotalAddedStaff($request->vendor_id) >= $current_package->staff_limit;
      if ($current_package == '[]' || $staffLimit) {
        Session::flash("warning", "You can't add staff for this vendor");
        return 'success';
      }
    }

    $staff = Staff::create($staffData);

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
          'information' => $request[$language->code . '_information'],
        ]);
      }
    }

    $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    foreach ($days as $key => $day) {
      $staffHoliday = new StaffDay();
      $staffHoliday->staff_id = $staff->id;
      $staffHoliday->vendor_id = $request->vendor_id;
      $staffHoliday->day = $day;
      $staffHoliday->indx = $key;
      $staffHoliday->save();
    }

    $request->session()->flash('success', 'New staff added successfully!');
    return 'success';
  }



  public function edit($id)
  {
    $information['languages'] = Language::all();
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $information['vendors'] = Vendor::where('id', '!=', 0)->get();
    $information['staff'] = Staff::with(['StaffContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($id);
    return view('admin.staff.edit-staff', $information);
  }

  public function update($id, StaffUpdateRequest $request)
  {
    $staff = Staff::findOrFail($id);

    if ($request->vendor_id != 0) {
      $current_package = \App\Http\Helpers\VendorPermissionHelper::packagePermission($request->vendor_id);
      if ($current_package == '[]') {
        Session::flash('warning', 'This vendor is not available!');
        return 'success';
      }
      $staffLimit = vendorTotalAddedStaff($request->vendor_id) >= $current_package->staff_limit;
      if ($current_package == '[]' || $staffLimit) {
        Session::flash("warning", "You can't edit staff for this vendor");
        return 'success';
      }
    }

    if ($request->hasFile('staff_image')) {
      $staffImage = UploadFile::update(public_path('assets/img/staff/'), $request->staff_image, $staff->image);
    }

    $staff->update([
      'username' =>  $request->login_allow_toggle == 0 ? NULL : $request->username,
      'password' => $request->login_allow_toggle == 0 ? NULL : $staff->password,
      'vendor_id' => $staff->vendor_id,
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

    $staff = Staff::findOrFail($id);
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
       * delete staff inforamtion
       */
      if ($staff) {
        $staffContent = StaffContent::where('staff_id', $staff->id)->get();

        foreach ($staffContent as $content) {
          $content->delete();
        }

        @unlink(public_path('assets/img/staff/') . $staff->image);
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

    $request->session()->flash('success', 'Staff deleted successfully!');
    return response()->json(['status' => 'success'], 200);
  }



  public function staffstatus(Request $request)
  {
    $staff = Staff::where('id', $request->staff_id)->first();

    $staff->update([
      'status' => $request->status,
    ]);
    $request->session()->flash('success', 'Status update successfully!');
    return back();
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
    return view('admin.staff.permission', $information);
  }

  public function changePassword($id)
  {
    $staffInfo = Staff::findOrFail($id);

    return view('admin.staff.change-password', compact('staffInfo'));
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
