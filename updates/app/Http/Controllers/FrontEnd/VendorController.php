<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BasicSettings\Basic;
use App\Models\HomePage\Section;
use App\Models\Language;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Services\ServiceCategory;
use App\Models\Services\ServiceReview;
use App\Models\Services\Services;
use App\Models\Vendor;
use App\Models\VendorInfo;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;

class VendorController extends Controller
{
  //index
  public function index(Request $request)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $queryResult['language'] = $language;

    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    $queryResult['seoInfo'] = $language->seoInfo()->select('meta_keywords_vendor_page', 'meta_description_vendor_page')->first();
    $name = $location = null;
    $vendorIds = [];
    if ($request->filled('name')) {
      $name = $request->name;
      $u_infos = Vendor::where('vendors.username', 'like', '%' . $name . '%')->get();
      $v_infos = VendorInfo::where([['vendor_infos.name', 'like', '%' . $name . '%'], ['language_id', $language->id]])->get();

      foreach ($u_infos as $info) {
        if (!in_array($info->id, $vendorIds)) {
          array_push($vendorIds, $info->id);
        }
      }
      foreach ($v_infos as $v_info) {
        if (!in_array($v_info->vendor_id, $vendorIds)) {
          array_push($vendorIds, $v_info->vendor_id);
        }
      }
    }

    if ($request->filled('location')) {
      $location = $request->location;
    }

    $secInfo = Section::query()->select('subscribe_section_status')->first();
    $queryResult['secInfo'] = $secInfo;

    if ($request->filled('location')) {
      $vendor_contents = VendorInfo::where('country', 'like', '%' . $location . '%')
        ->orWhere('city', 'like', '%' . $location . '%')
        ->orWhere('state', 'like', '%' . $location . '%')
        ->orWhere('zip_code', 'like', '%' . $location . '%')
        ->orWhere('address', 'like', '%' . $location . '%')
        ->get();
      foreach ($vendor_contents as $vendor_content) {
        if (!in_array($vendor_content->vendor_id, $vendorIds)) {
          array_push($vendorIds, $vendor_content->vendor_id);
        }
      }
    }

    $queryResult['bgImg'] = $misc->getBreadcrumb();

    // Modified query to include admins
    $admin = Admin::whereNull('role_id')
      ->when($name, function ($query) use ($name) {
        return $query->where('username', 'like', '%' . $name . '%')
          ->orWhere('first_name', 'like', '%' . $name . '%')
          ->orWhere('last_name', 'like', '%' . $name . '%');
      })
      ->when($location, function ($query) use ($location) {
        return $query->where('address', 'like', '%' . $location . '%');
      })
      ->first();

    $vendors = Vendor::join('memberships', 'memberships.vendor_id', 'vendors.id')
      ->join('vendor_infos', 'vendors.id', '=', 'vendor_infos.vendor_id')
      ->where([
        ['memberships.status', 1],
        ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')],
      ])
      ->where('vendors.status', 1)
      ->when($name, function ($query) use ($vendorIds) {
        return $query->whereIn('vendors.id', $vendorIds);
      })
      ->when($location, function ($query) use ($vendorIds) {
        return $query->whereIn('vendors.id', $vendorIds);
      })
      ->where('vendor_infos.language_id', $language->id)
      ->where('vendors.id', '!=', 0)
      ->select('vendors.*', 'vendors.id as vendorId')
      ->orderBy('vendors.created_at', 'desc')
      ->paginate(8);

    $queryResult['vendors'] = $vendors;
    $queryResult['admin'] = $admin;

    return view('frontend.vendor.index', $queryResult);
  }
  //details
  public function details(Request $request, $d)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();

    $queryResult['language'] = $language;

    $queryResult['bgImg'] = $misc->getBreadcrumb();
    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    if ($d == 'admin') {
      $vendor = Admin::first();
      $vendor_id = 0;
      $queryResult['total_service'] = Services::where('vendor_id', 0)
        ->where('status', 1)
        ->count();
    } else {

      $vendor = Vendor::join('memberships', 'memberships.vendor_id', 'vendors.id')
        ->where([
          ['memberships.status', 1],
          ['memberships.start_date', '<=', Carbon::now()->format('Y-m-d')],
          ['memberships.expire_date', '>=', Carbon::now()->format('Y-m-d')],
        ])
        ->where('vendors.status', 1)
        ->where('vendors.status', 1)
        ->where('vendors.username', $request->username)
        ->select('vendors.*')
        ->firstOrFail();
      $currentLang =  Language::where('is_default', 1)->first();
      $vendorInfo = VendorInfo::where('vendor_id', $vendor->id)->where('language_id', $language->id)->first();
      if (empty($vendorInfo)) {
        session()->put('currentLocaleCode', $currentLang->code);
        return redirect()->back()->with('warning', 'Content not available. Please try another language.');
      }
      $vendorInfo = VendorInfo::where([['vendor_id', $vendor->id], ['language_id', $language->id]])->firstOrFail();
      $queryResult['vendorInfo'] = $vendorInfo;
      $vendor_id = $vendor->id;
      $queryResult['total_service'] = Services::where('vendor_id', $vendor_id)
        ->where('status', 1)
        ->count();
    }
    $queryResult['vendor'] = $vendor;
    $queryResult['vendor_details'] = ($d == 'admin') ? $vendor->details : $vendorInfo->details;
    $queryResult['vendor_address'] = ($d == 'admin') ? $vendor->address : $vendorInfo->address;

    $reviews = ServiceReview::where('vendor_id', $vendor_id)->get();

    if ($reviews != '[]') {

      $totalRating = 0;

      foreach ($reviews as $review) {
        $totalRating += $review->rating;
      }

      $numOfReview = count($reviews);

      $queryResult['averageRating'] = number_format($totalRating / $numOfReview, 1);
    }

    //service category
    $queryResult['categories'] = ServiceCategory::has('service_content')->where([['language_id', $language->id], ['status', 1]])->get();

    //services
    $queryResult['services'] = Services::join('service_contents', 'services.id', '=', 'service_contents.service_id')
      ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
      ->where('services.vendor_id', $vendor_id)
      ->where('service_contents.language_id', $language->id)
      ->where('services.status', 1)
      ->select(
        'services.*',
        'service_contents.name',
        'service_contents.slug',
        'service_categories.name as categoryName',
        'service_categories.id as categoryid',
        'service_contents.address'
      )
      ->orderBy('id', 'desc')
      ->paginate(9);

    $secInfo = Section::query()->select('subscribe_section_status')->first();
    $queryResult['secInfo'] = $secInfo;
    $queryResult['currencyInfo'] = $this->getCurrencyInfo();
    $queryResult['info'] = Basic::select('google_recaptcha_status')->first();


    //Strip payment
    $stripe = OnlineGateway::where('keyword', 'stripe')->first();
    $stripe_info = json_decode($stripe->information, true);
    $queryResult['stripe_key'] = $stripe_info['key'];

    //Authorize.Net payment
    $authorizeNet = OnlineGateway::where('keyword', 'authorize.net')->first();
    $authorizeInfo = json_decode($authorizeNet->information, true);

    if ($authorizeInfo['sandbox_check'] == 1) {
      $queryResult['authorizeUrl'] = 'https://jstest.authorize.net/v1/Accept.js';
    } else {
      $queryResult['authorizeUrl'] = 'https://js.authorize.net/v1/Accept.js';
    }

    $queryResult['authorize_login_id'] = $authorizeInfo['login_id'];
    $queryResult['authorize_public_key'] = $authorizeInfo['public_key'];

    return view('frontend.vendor.details', $queryResult);
  }

  //contact
  public function contact(Request $request)
  {
    $rules = [
      'name' => 'required',
      'email' => 'required|email:rfc,dns',
      'subject' => 'required',
      'message' => 'required'
    ];
    $info = Basic::select('google_recaptcha_status')->first();
    if ($info->google_recaptcha_status == 1) {
      $rules['g-recaptcha-response'] = 'required|captcha';
    }
    $messageArray = [];

    if ($info->google_recaptcha_status == 1) {
      $messageArray['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
      $messageArray['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';
    }

    $validator = Validator::make($request->all(), $rules, $messageArray);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->getMessageBag()->toArray()], 400);
    }


    $be = Basic::select('smtp_status', 'smtp_host', 'smtp_port', 'encryption', 'smtp_username', 'smtp_password', 'from_mail', 'from_name')->firstOrFail();

    $c_message = nl2br($request->message);
    $msg = "<h4>Name : $request->name</h4>
            <h4>Email : $request->email</h4>
            <p>Message : </p>
            <p>$c_message</p>
            ";

    $data = [
      'to' => $request->vendor_email,
      'subject' => $request->subject,
      'message' => $msg,
    ];

    if ($be->smtp_status == 1) {
      try {
        $smtp = [
          'transport' => 'smtp',
          'host' => $be->smtp_host,
          'port' => $be->smtp_port,
          'encryption' => $be->encryption,
          'username' => $be->smtp_username,
          'password' => $be->smtp_password,
          'timeout' => null,
          'auth_mode' => null,
        ];
        Config::set('mail.mailers.smtp', $smtp);
      } catch (\Exception $e) {
        Session::flash('error', $e->getMessage());
        return back();
      }
    }
    try {
      if ($be->smtp_status == 1) {
        Mail::send([], [], function (Message $message) use ($data, $be) {
          $fromMail = $be->from_mail;
          $fromName = $be->from_name;
          $message->to($data['to'])
            ->subject($data['subject'])
            ->from($fromMail, $fromName)
            ->html($data['message'], 'text/html');
        });
      }
      Session::flash('message', 'Message sent successfully');
      Session::flash('alert-type', 'success');
      return 'success';
    } catch (\Exception $e) {
      Session::flash('message', 'Something went wrong.');
      Session::flash('alert-type', 'error');
      return 'success';
    }
  }
}
