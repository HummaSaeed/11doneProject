<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\BasicMailer;
use App\Http\Helpers\MegaMailer;
use App\Http\Helpers\UploadFile;
use App\Models\Admin;
use App\Models\Admin\Transaction;
use App\Models\Journal\Blog;
use App\Models\Language;
use App\Models\Membership;
use App\Models\Package;
use App\Models\Services\Services;
use App\Models\Shop\Product;
use App\Models\Shop\ProductOrder;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffContent;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Vendor;
use App\Rules\ImageMimeTypeRule;
use App\Rules\MatchEmailRule;
use App\Rules\MatchOldPasswordRule;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
  public function login()
  {
    return view('admin.login');
  }

  public function authentication(Request $request)
  {
    $rules = [
      'username' => 'required',
      'password' => 'required'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors());
    }

    // get the username and password which has provided by the admin
    $credentials = $request->only('username', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
      $authAdmin = Auth::guard('admin')->user();

      // check whether the admin's account is active or not
      if ($authAdmin->status == 0) {
        $request->session()->flash('alert', 'Sorry, your account has been deactivated!');

        // logout auth admin as condition not satisfied
        Auth::guard('admin')->logout();

        return redirect()->back();
      } else {
        return redirect()->route('admin.dashboard');
      }
    } else {
      return redirect()->back()->with('alert', 'Oops, username or password does not match!');
    }
  }

  public function forgetPassword()
  {
    return view('admin.forget-password');
  }

  public function forgetPasswordMail(Request $request)
  {
    // validation start
    $rules = [
      'email' => [
        'required',
        'email:rfc,dns',
        new MatchEmailRule('admin')
      ]
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors())->withInput();
    }
    // validation end

    // create a new password and store it in db
    $newPassword = uniqid();

    $admin = Admin::query()->where('email', '=', $request->email)->first();

    $admin->update([
      'password' => Hash::make($newPassword)
    ]);

    // prepare a mail to send newly created password to admin
    $mailData['subject'] = 'Reset Password';

    $mailData['body'] = 'Hi ' . $admin->first_name . ',<br/><br/>Your password has been reset. Your new password is: ' . $newPassword . '<br/>Now, you can login with your new password. You can change your password later.<br/><br/>Thank you.';

    $mailData['recipient'] = $admin->email;

    $mailData['sessionMessage'] = 'A mail has been sent to your email address.';

    BasicMailer::sendMail($mailData);

    return redirect()->back();
  }

  public function redirectToDashboard()
  {
    $information['authAdmin'] = Auth::guard('admin')->user();
    $information['totalProduct'] = Product::query()->count();
    $information['totalService'] = Services::query()->count();
    $information['totalOrder'] = ProductOrder::query()->count();
    $information['totalBlog'] = Blog::query()->count();
    $information['totalUser'] = User::query()->count();
    $information['totalSubscriber'] = Subscriber::query()->count();
    $information['payment_log'] = Membership::where('vendor_id', '!=', 0)->count();
    $information['vendors'] = Vendor::where('id', '!=', 0)->get()->count();
    $information['totalTransaction'] = Transaction::get()->count();

    //income of event bookings
    $monthWiseTotalIncomes = DB::table('transactions')
      ->select(
        DB::raw('month(created_at) as month'),
        DB::raw('SUM(CASE WHEN transaction_type != "booking_refund" THEN admin_profit ELSE 0 END) as total'),
        DB::raw('SUM(CASE WHEN vendor_id = 0 THEN refund_amount ELSE 0 END) as refund_amount'),
        DB::raw('sum(featured_refund) as featured_refund')
      )
      ->where('payment_status', 'completed')
      ->whereIn('transaction_type', ['service_booking', 'product_purchase', 'featured_service', 'membership_buy', 'booking_refund', 'withdraw', 'featured_service_reject'])
      ->groupBy('month')
      ->whereYear('created_at', '=', date('Y'))
      ->get();


    $monthlyAppointment = DB::table('service_bookings')
      ->select(DB::raw('month(created_at) as month'), DB::raw('count(id) as total'))
      ->groupBy('month')
      ->whereYear('created_at', '=', date('Y'))
      ->get();


    $adminProfit = DB::table('transactions')
      ->select(
        DB::raw('SUM(CASE WHEN transaction_type != "booking_refund" THEN admin_profit ELSE 0 END) as total'),
        DB::raw('SUM(CASE WHEN vendor_id = 0 THEN refund_amount ELSE 0 END) as refund_amount'),
        DB::raw('SUM(featured_refund) as featured_refund')
      )
      ->where('payment_status', 'completed')
      ->whereIn('transaction_type', ['service_booking', 'product_purchase', 'featured_service', 'membership_buy', 'withdraw', 'booking_refund', 'featured_service_reject'])
      ->get();


    $profitAmount = 0;

    foreach ($adminProfit as $profit) {
      $profitAmount += ($profit->total - ($profit->refund_amount + $profit->featured_refund));
    }


    //create a staff for admin
    $admin = Admin::whereNull('role_id')->first();
    $admin_staff_check = Staff::where('vendor_id', 0)->first();
    if (!$admin_staff_check) {
      $staff = Staff::create([
        'username' =>  $admin->username,
        'vendor_id' => 0,
        'email' => $admin->email,
        'status' => 1,
        'order_number' => 0,
        'allow_login' => 0,
        'role' => 'vendor',
        'is_day' => 0,
      ]);
      $languages = Language::all();
      foreach ($languages as $language) {
        StaffContent::create([
          'language_id' => $language->id,
          'staff_id' => $staff->id,
          'name' => $admin['first_name'],
          'location' => $admin['address'],
          'information' => $admin['details']
        ]);
      }
    }


    $months = [];
    $monthlyIncome = [];
    $monthlyAppoinment = [];

    //event icome calculation
    for ($i = 1; $i <= 12; $i++) {
      // get all 12 months name
      $monthNum = $i;
      $dateObj = DateTime::createFromFormat('!m', $monthNum);
      $monthName = $dateObj->format('M');
      array_push($months, $monthName);

      // get all 12 months's income
      $incomeFound = false;
      foreach ($monthWiseTotalIncomes as $appointment) {
        if ($appointment->month == $i) {
          $incomeFound = true;
          array_push($monthlyIncome, ($appointment->total - ($appointment->refund_amount + $appointment->featured_refund)));
          break;
        }
      }
      if ($incomeFound == false) {
        array_push($monthlyIncome, 0);
      }

      // get all 12 months's income
      $apFound = false;
      foreach ($monthlyAppointment as $totalUser) {
        if ($totalUser->month == $i) {
          $apFound = true;
          array_push($monthlyAppoinment, $totalUser->total);
          break;
        }
      }
      if ($apFound == false) {
        array_push($monthlyAppoinment, 0);
      }
    }

    $information['monthArr'] = $months;
    $information['monthlyIncome'] = $monthlyIncome;
    $information['monthlyAppoinment'] = $monthlyAppoinment;
    $information['totalProfitAmount'] = $profitAmount;


    return view('admin.dashboard', $information);
  }

  public function changeTheme(Request $request)
  {
    DB::table('basic_settings')->updateOrInsert(
      ['uniqid' => 12345],
      ['admin_theme_version' => $request->admin_theme_version]
    );

    return redirect()->back();
  }

  public function editProfile()
  {
    $adminInfo = Auth::guard('admin')->user();

    return view('admin.edit-profile', compact('adminInfo'));
  }

  public function updateProfile(Request $request)
  {
    $admin = Auth::guard('admin')->user();

    $rules = [];

    if (is_null($admin->image)) {
      $rules['image'] = 'required';
    }
    if ($request->hasFile('image')) {
      $rules['image'] = new ImageMimeTypeRule();
    }

    $rules['username'] = [
      'required',
      Rule::unique('admins')->ignore($admin->id)
    ];

    $rules['email'] = [
      'required',
      Rule::unique('admins')->ignore($admin->id)
    ];

    $rules['first_name'] = 'required';

    $rules['last_name'] = 'required';

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors());
    }

    if ($request->hasFile('image')) {
      $newImg = $request->file('image');
      $oldImg = $admin->image;
      $imageName = UploadFile::update(public_path('assets/img/admins/'), $newImg, $oldImg);
    }

    $admin->update([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'image' => $request->hasFile('image') ? $imageName : $admin->image,
      'username' => $request->username,
      'email' => $request->email,
      'address' => $request->address,
      'details' => $request->details,
    ]);

    $request->session()->flash('success', 'Profile updated successfully!');

    return redirect()->back();
  }

  public function changePassword()
  {
    return view('admin.change-password');
  }

  public function updatePassword(Request $request)
  {
    $rules = [
      'current_password' => [
        'required',
        new MatchOldPasswordRule('admin')
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

    $admin = Auth::guard('admin')->user();

    $admin->update([
      'password' => Hash::make($request->new_password)
    ]);

    $request->session()->flash('success', 'Password updated successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();

    // invalidate the admin's session
    $request->session()->invalidate();

    return redirect()->route('admin.login');
  }

  //membershipRequest
  public function membershipRequest()
  {
    $collections = Membership::where('memberships.status', '!=', 1)->paginate(10);
    $data['collections'] = $collections;
    return view('admin.admin.membership-request', $data);
  }
  public function membershipRequestUpdate(Request $request, $id)
  {
    $membership = Membership::findOrFail($id);
    $vendor = Vendor::findorFail($membership->vendor_id);
    $package = Package::findOrFail($membership->package_id);
    $settings = json_decode($membership->settings, true);
    $activation = Carbon::parse($package->start_date);
    $expire = Carbon::parse($package->expire_date);

    $membership->update([
      'status' => 1,
      'modified' => 1
    ]);

    if ($request->status != 0) {
      $mailer = new MegaMailer();
      $data = [
        'toMail' => $vendor->email,
        'toName' => $vendor->fname,
        'username' => $vendor->username,
        'package_title' => $package->title,
        'package_price' => ($settings['base_currency_symbol_position'] == 'left' ? $settings['base_currency_symbol'] . ' ' : '') . $package->price . ($settings['base_currency_symbol_position'] == 'right' ? ' ' . $settings['base_currency_symbol'] : ''),
        'activation_date' => $activation->toFormattedDateString(),
        'expire_date' => Carbon::parse($expire->toFormattedDateString())->format('Y') == '9999' ? 'Lifetime' : $expire->toFormattedDateString(),
        'website_title' => $settings['website_title'],
        'templateType' => $request->status == 1 ? 'package_purchase_membership_accepted' : 'package_purchase_membership_rejected',
      ];
      $mailer->mailFromAdmin($data);
    } else {
    }
    Session::flash('success', 'Updated payment status successfully.');
    return back();
  }


  public function monthly_profit(Request $request)
  {
    if ($request->filled('year')) {
      $date = $request->input('year');
    } else {
      $date = date('Y');
    }

    $monthWiseTotalIncomes = DB::table('transactions')
      ->select(
        DB::raw('month(created_at) as month'),
        DB::raw('SUM(CASE WHEN transaction_type != "booking_refund" THEN admin_profit ELSE 0 END) as total'),
        DB::raw('SUM(CASE WHEN vendor_id = 0 THEN refund_amount ELSE 0 END) as refund_amount'),
        DB::raw('sum(featured_refund) as featured_refund')
      )
      ->where('payment_status', 'completed')
      ->whereIn('transaction_type', ['withdraw', 'product_purchase', 'featured_service', 'membership_buy', 'service_booking', 'booking_refund', 'featured_service_reject'])
      ->groupBy('month')
      ->whereYear('created_at', '=', $date)
      ->get();

    $months = [];
    $incomes = [];

    for ($i = 1; $i <= 12; $i++) {
      // get all 12 months name
      $monthName =  $i;
      $dateObj = DateTime::createFromFormat('!m', $monthName);
      $monthName = $dateObj->format('M');
      array_push($months, $monthName);

      // get all 12 months's income of equipment profit
      $incomeFound = false;
      foreach ($monthWiseTotalIncomes as $incomeInfo) {
        if ($incomeInfo->month == $i) {
          $incomeFound = true;
          $actualAmount = $incomeInfo->featured_refund + $incomeInfo->refund_amount;
          array_push($incomes, ($incomeInfo->total - $actualAmount));
        }
      }

      if ($incomeFound == false) {
        array_push($incomes, 0);
      }
    }
    $information['months'] = $months;
    $information['incomes'] = $incomes;

    return view('admin.profit', $information);
  }
}
