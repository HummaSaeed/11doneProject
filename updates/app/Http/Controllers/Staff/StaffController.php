<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Http\Helpers\UploadFile;
use App\Models\BasicSettings\Basic;
use App\Models\Language;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffContent;
use App\Models\Staff\StaffService;
use App\Rules\MatchOldPasswordRule;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Response;
use Session;
use Validator;

class StaffController extends Controller
{
  public function login()
  {
    $misc = new MiscellaneousController();

    $language = $misc->getLanguage();

    $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_staff_login_page', 'meta_description_staff_login_page')->first();

    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    $queryResult['bgImg'] = $misc->getBreadcrumb();
    $queryResult['bs'] = Basic::query()->select('google_recaptcha_status', 'facebook_login_status', 'google_login_status')->first();

    return view('staffs.auth.login', $queryResult);
  }

  public function loginSubmit(Request $request)
  {
    $rules = [
      'username' => 'required',
      'password' => 'required'
    ];

    $messages = [];
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->route('staff.login')->withErrors($validator->errors())->withInput();
    }

    // get the email and password which has provided by the user
    $credentials = $request->only('username', 'password');

    // login attempt
    if (Auth::guard('staff')->attempt($credentials)) {
      $staff = Auth::guard('staff')->user();

      if ($staff->status == 0) {
        Session::flash('error', 'Sorry, your account has been deactivated');
        // logout auth user as condition not satisfied
        // Auth::guard('staff')->logout();
        return redirect()->back();
      }

      // otherwise, redirect auth user to next url
      return redirect()->route('staff.dashboard');
    } else {
      Session::flash('error', 'Incorrect username or password');

      return redirect()->back()->withInput();
    }
  }

  public function index()
  {
    $language = Language::where('is_default', 1)->first();
    $language_id = $language->id;

    $staffId = Auth::guard('staff')->user()->id;
    $information['totalServices'] = StaffService::query()->where('staff_id', $staffId)->count();

    $information['totalAppointment'] = ServiceBooking::query()->where('staff_id', $staffId)->count();
    $information['totalPendingAppointment'] = ServiceBooking::query()
      ->where('order_status', 'pending')
      ->where('staff_id', $staffId)->count();
    $information['totalCompleteAppointment'] = ServiceBooking::query()
      ->where('order_status', 'rejected')
      ->where('staff_id', $staffId)->count();

    $information['totalRejectedAppointment'] = ServiceBooking::query()
      ->where('order_status', 'complete')
      ->where('staff_id', $staffId)->count();

    $information['recent_appointments'] = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->where('staff_id', $staffId)
      ->where('order_status', '=', 'pending')
      ->take(5)
      ->latest()
      ->get();

    return view('staffs.index', $information);
  }

  //edit_profile
  public function edit_profile()
  {
    $misc = new MiscellaneousController();

    $language = $misc->getLanguage();

    $information['language'] = $language;
    $information['languages'] = Language::get();

    $staff_id = Auth::guard('staff')->user()->id;
    $information['staff'] = Staff::findOrFail($staff_id);
    return view('staffs.auth.edit-profile', $information);
  }

  //update_profile
  public function update_profile(Request $request, $id)
  {
    $rules = [
      'phone' => 'required',
      'username' => [
        'required',
        'not_in:admin,vendor',
        Rule::unique('staff', 'username')->ignore($id),
      ],
      'email' => [
        'required',
        'email',
        Rule::unique('staff', 'email')->ignore($id)
      ]
    ];

    $defaultLanguage = Language::where('is_default', 1)->first();
    $rules[$defaultLanguage->code . '_name'] = 'required|max:255';


    $languages = Language::get();
    foreach ($languages as $language) {
      $code = $language->code;
      // Skip the default language as it's always required
      if ($language->id == $defaultLanguage->id) {
        continue;
      }
      if (
        $request->filled($code . '_location') ||
        $request->filled($code . '_name') ||
        $request->filled($code . '_information')
      ) {
        $rules[$language->code . '_name'] = 'required';
      }
    }
    $validator = Validator::make($request->all(), $rules);

    if ($request->hasFile('staff_image')) {
      $rules['staff_image'] = 'mimes:png,jpeg,jpg|dimensions:min_width=80,max_width=80,min_width=80,min_height=80';
    }
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    $staff = Staff::findOrFail($id);
    $vendor_id = $staff->vendor_id;

    if ($request->hasFile('staff_image')) {
      $staffImage = UploadFile::update(public_path('assets/img/staff/'), $request->staff_image, $staff->image);
    }

    $staff->update([
      'username' =>  $request->username !== null ? $request->username : null,
      'vendor_id' => $vendor_id,
      'email' => $request->email,
      'phone' => $request->phone,
      'email_status' => $request->show_email_addresss ?? 0,
      'info_status' => $request->show_information ?? 0,
      'phone_status' => $request->show_phone ?? 0,
      'image' => $request->hasFile('staff_image') ? $staffImage : $staff->image,
    ]);

    $languages = Language::all();
    foreach ($languages as $language) {
      $code = $language->code;
      $staff_content = StaffContent::where('language_id', $language->id)->where('staff_id', $staff->id)->first();
      if (empty($staff_content)) {
        $staff_content = new StaffContent();
      }
      if (
        $language->is_default == 1 ||
        $request->filled($code . '_location') ||
        $request->filled($code . '_name') ||
        $request->filled($code . '_information')
      ) {
        $staff_content->language_id = $language->id;
        $staff_content->staff_id = $staff->id;
        $staff_content->name = $request[$language->code . '_name'];
        $staff_content->location = $request[$language->code . '_location'];
        $staff_content->information = $request[$language->code . '_information'];
        $staff_content->save();
      }
    }
    Session::flash('success', 'Staff update successfully!');
    return 'success';
  }

  public function change_password()
  {
    return view('staffs.auth.change-password');
  }
  //update_password
  public function updated_password(Request $request)
  {
    $rules = [
      'current_password' => [
        'required',
        new MatchOldPasswordRule('staff')

      ],
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

    $vendor = Auth::guard('staff')->user();

    $vendor->update([
      'password' => Hash::make($request->new_password)
    ]);

    Session::flash('success', 'Password updated successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function changeTheme(Request $request)
  {
    Session::put('staff_theme_version', $request->staff_theme_version);
    return redirect()->back();
  }

  public function logout(Request $request)
  {
    Auth::guard('staff')->logout();
    Session::forget('secret_login');
    return redirect()->route('staff.login');
  }
}
