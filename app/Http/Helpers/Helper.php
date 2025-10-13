<?php

use App\Http\Controllers\Frontend\GoogleCalendarController;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Http\Controllers\Vendor\Staff\ZoomController;
use App\Http\Controllers\Staff\GoogleCalendarController as StaffCalendarController;
use App\Http\Helpers\BasicMailer;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Admin\Transaction;
use App\Models\Advertisement;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Language;
use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceContent;
use App\Models\Services\ServiceImage;
use App\Models\Services\Services;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffPlugin;
use Carbon\Carbon;

if (!function_exists('createSlug')) {
  function createSlug($string)
  {
    $slug = preg_replace('/\s+/u', '-', trim($string));
    $slug = str_replace('/', '', $slug);
    $slug = str_replace('?', '', $slug);
    $slug = str_replace(',', '', $slug);

    return mb_strtolower($slug);
  }
}
if (!function_exists('truncateString')) {
  function truncateString($string, $maxLength)
  {
    return strlen($string) > $maxLength ? mb_substr($string, 0, $maxLength, 'UTF-8') . '...' : $string;
  }
}

if (!function_exists('make_input_name')) {
  function make_input_name($string)
  {
    return preg_replace('/\s+/u', '_', trim($string));
  }
}

if (!function_exists('replaceBaseUrl')) {
  function replaceBaseUrl($html, $type)
  {
    $startDelimiter = 'src=""';
    if ($type == 'summernote') {
      $endDelimiter = '/assets/img/summernote';
    } elseif ($type == 'pagebuilder') {
      $endDelimiter = '/assets/img';
    }

    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;

    while (false !== ($contentStart = strpos($html, $startDelimiter, $startFrom))) {
      $contentStart += $startDelimiterLength;
      $contentEnd = strpos($html, $endDelimiter, $contentStart);

      if (false === $contentEnd) {
        break;
      }

      $html = substr_replace($html, url('/'), $contentStart, $contentEnd - $contentStart);
      $startFrom = $contentEnd + $endDelimiterLength;
    }

    return $html;
  }
}

if (!function_exists('setEnvironmentValue')) {
  function setEnvironmentValue(array $values)
  {
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    if (count($values) > 0) {
      foreach ($values as $envKey => $envValue) {
        $str .= "\n"; // In case the searched variable is in the last line without \n
        $keyPosition = strpos($str, "{$envKey}=");
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

        // If key does not exist, add it
        if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
          $str .= "{$envKey}={$envValue}\n";
        } else {
          $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
        }
      }
    }

    $str = substr($str, 0, -1);
    if (!file_put_contents($envFile, $str)) return false;
    return true;
  }
}

if (!function_exists('showAd')) {
  function showAd($resolutionType)
  {
    $ad = Advertisement::where('resolution_type', $resolutionType)->inRandomOrder()->first();
    $adsenseInfo = Basic::query()->select('google_adsense_publisher_id')->first();

    if (!is_null($ad)) {
      if ($resolutionType == 1) {
        $maxWidth = '300px';
        $maxHeight = '250px';
      } else if ($resolutionType == 2) {
        $maxWidth = '300px';
        $maxHeight = '600px';
      } else {
        $maxWidth = '728px';
        $maxHeight = '90px';
      }

      if ($ad->ad_type == 'banner') {
        $markUp = '<a href="' . url($ad->url) . '" target="_blank" onclick="adView(' . $ad->id . ')" class="ad-banner">
          <img data-src="' . asset('assets/img/advertisements/' . $ad->image) . '" alt="advertisement" style="width: ' . $maxWidth . '; height: ' . $maxHeight . ';" class="lazyload blur-up">
        </a>';

        return $markUp;
      } else {
        $markUp = '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . $adsenseInfo->google_adsense_publisher_id . '" crossorigin="anonymous"></script>
        <ins class="adsbygoogle" style="display: block;" data-ad-client="' . $adsenseInfo->google_adsense_publisher_id . '" data-ad-slot="' . $ad->slot . '" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
        </script>';

        return $markUp;
      }
    } else {
      return;
    }
  }
}

if (!function_exists('onlyDigitalItemsInCart')) {
  function onlyDigitalItemsInCart()
  {
    $cart = session()->get('productCart');
    if (!empty($cart)) {
      foreach ($cart as $key => $cartItem) {
        if ($cartItem['type'] != 'digital') {
          return false;
        }
      }
    }
    return true;
  }
}

if (!function_exists('onlyDigitalItems')) {
  function onlyDigitalItems($order)
  {

    $oitems = $order->orderitems;
    foreach ($oitems as $key => $oitem) {

      if ($oitem->item->type != 'digital') {
        return false;
      }
    }

    return true;
  }
}

if (!function_exists('get_href')) {
  function get_href($data)
  {
    $link_href = '';

    if ($data->type == 'home') {
      $link_href = route('index');
    } else if ($data->type == 'vendors') {
      $link_href = route('frontend.vendors');
    } else if ($data->type == 'shop') {
      $link_href = route('shop.products');
    } else if ($data->type == 'cart') {
      $link_href = route('shop.cart');
    } else if ($data->type == 'checkout') {
      $link_href = route('shop.checkout');
    } else if ($data->type == 'blog') {
      $link_href = route('blog');
    } else if ($data->type == 'faq') {
      $link_href = route('faq');
    } else if ($data->type == 'contact') {
      $link_href = route('contact');
    } else if ($data->type == 'about-us') {
      $link_href = route('about_us');
    } else if ($data->type == 'custom') {
      /**
       * this menu has created using menu-builder from the admin panel.
       * this menu will be used as drop-down or to link any outside url to this system.
       */
      if ($data->href == '') {
        $link_href = '#';
      } else {
        $link_href = $data->href;
      }
    } else {
      // this menu is for the custom page which has been created from the admin panel.
      $link_href = route('dynamic_page', ['slug' => $data->type]);
    }

    return $link_href;
  }
}

if (!function_exists('format_price')) {
  function format_price($value): string
  {
    if (session()->has('lang')) {
      $currentLang = Language::where('code', session()
        ->get('lang'))
        ->first();
    } else {
      $currentLang = Language::where('is_default', 1)
        ->first();
    }
    $bs = Basic::first();
    if ($bs->base_currency_symbol_position == 'left') {
      return $bs->base_currency_symbol . $value;
    } else {
      return $value . $bs->base_currency_symbol;
    }
  }
}

if (!function_exists('symbolPrice')) {
  function symbolPrice($price)
  {
    $basic = Basic::where('uniqid', 12345)->select('base_currency_symbol_position', 'base_currency_symbol')->first();
    if ($basic->base_currency_symbol_position == 'left') {
      $data = $basic->base_currency_symbol . round($price, 2);
      return str_replace(' ', '', $data);
    } elseif ($basic->base_currency_symbol_position == 'right') {
      $data = round($price, 2) . $basic->base_currency_symbol;
      return str_replace(' ', '', $data);
    }
  }
}

if (!function_exists('checkWishList')) {
  function checkWishList($service_id, $user_id)
  {
    $check = App\Models\Services\Wishlist::where('service_id', $service_id)
      ->where('user_id', $user_id)
      ->first();
    if ($check) {
      return true;
    } else {
      return false;
    }
  }
}

if (!function_exists('vendorTotalAddedService')) {
  function vendorTotalAddedService($vendor_id)
  {
    $total = Services::where('vendor_id', $vendor_id)->count();
    return $total;
  }
}

if (!function_exists('zoomCreate')) {
  function zoomCreate($data)
  {
    if ($data['zoom_status'] == 1) {
      $permission = $data['vendor_id'] != 0 ? VendorPermissionHelper::packagePermission($data['vendor_id']) : null;

      if (!$permission || $permission->zoom_meeting_status == 1) {
        (new ZoomController())->createMeeting($data);
      }
    }
  }
}

if (!function_exists('calendarEventCreate')) {
  function calendarEventCreate($data)
  {
    $staffCalender = StaffPlugin::where('staff_id', $data['staff_id'])->select('google_calendar', 'calender_id')->first();

    if ($data['calender_status'] == 1) {
      $permission = $data['vendor_id'] != 0 ? VendorPermissionHelper::packagePermission($data['vendor_id']) : null;

      if (!$permission || $permission->calendar_status == 1) {
        (new GoogleCalendarController())->createEvent($data);
        if (!empty($staffCalender)) {
          if (!empty($staffCalender->google_calendar) && !empty($staffCalender->calender_id)) {
            (new StaffCalendarController())->createEvent($data);
          }
        }
      }
    }
  }
}


if (!function_exists('vendorTotalAddedStaff')) {
  function vendorTotalAddedStaff($vendor_id)
  {
    $total = Staff::where('vendor_id', $vendor_id)->whereNull('role')->get()->count();
    return $total;
  }
}
if (!function_exists('vendorTotalSliderImage')) {
  function vendorTotalSliderImage($serviceId)
  {

    $total = ServiceImage::where('service_id', $serviceId)->count();
    return $total;
  }
}


if (!function_exists('store_transaction')) {
  function store_transaction($data)
  {
    $prev_admin_profit = DB::table('basic_settings')->pluck('admin_profit')->first();

    if ($data['transaction_type'] == 'featured_service_reject') {
      $admin_profit = $data['actual_total'] - $prev_admin_profit;
      $refundAmount = $data['actual_total'];
    } else {
      $admin_profit = $data['actual_total'] + $prev_admin_profit;
      $refundAmount = 0;
    }

    //admin profit update on basic_settings start
    DB::table('basic_settings')->updateOrInsert(
      ['uniqid' => 12345],
      [
        'admin_profit' => $admin_profit,
      ]
    );
    $actaulTotal = null;
    Transaction::create([
      'transaction_id' => time(),
      'actual_total' => $data['transaction_type'] == 'featured_service_reject' ? $actaulTotal : $data['actual_total'],
      'transaction_type' => $data['transaction_type'],
      'vendor_id' => $data['vendor_id'],
      'payment_status' => $data['payment_status'],
      'payment_method' => $data['payment_method'],
      'pre_balance' => $data['pre_balance'],
      'admin_profit' => $data['transaction_type'] == 'featured_service_reject' ? $actaulTotal : $data['admin_profit'],
      'featured_refund' => $refundAmount,
      'after_balance' => $data['after_balance'],
      'currency_symbol' => $data['currency_symbol'],
      'currency_symbol_position' => $data['currency_symbol_position'],
    ]);
  }
}

//check service id's from appointment
if (!function_exists('checkService')) {
  function checkService($id)
  {
    $hasService = Services::where('id', $id)
      ->whereHas('appointment', function ($query) {
        $query->where('order_status', 'pending');
      })
      ->count();

    return $hasService;
  }
}

if (!function_exists('checkMembersipExpireDate')) {
  function checkMembersipExpireDate($vendor_id)
  {
    $currentPackage = VendorPermissionHelper::packagePermission($vendor_id);
    if ($currentPackage != '[]' && $vendor_id != 0) {
      $nextPackage = VendorPermissionHelper::nextPackage($vendor_id);
      if ($nextPackage == null) {
        $membership = VendorPermissionHelper::currMembOrPending($vendor_id);
      } else {
        $membership = VendorPermissionHelper::nextMembership($vendor_id);
      }
      $expireDate = $membership->expire_date;
      return $expireDate;
    }
  }
}

//appoitntment payment confirmation mail
if (!function_exists('payemntStatusMail')) {
  function payemntStatusMail($type, $id)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();

    $booking = ServiceBooking::select('id', 'service_id', 'currency_symbol', 'customer_paid', 'customer_name', 'customer_email', 'start_date', 'end_date', 'created_at', 'booking_date')->findOrFail($id);

    // get the mail template info from db
    $mailTemplate = MailTemplate::query()->where('mail_type', '=', $type)->first();
    $mailData['subject'] = $mailTemplate->mail_subject;
    $mailBody = $mailTemplate->mail_body;


    $serviceInfo = ServiceContent::query()
      ->where('service_id', $booking->service_id)
      ->where('language_id', $language->id)
      ->select('name', 'slug')
      ->firstOrFail();

    //service title with ther details link
    $url = route('frontend.service.details', ['slug' => $serviceInfo->slug, 'id' => $booking->service_id]);
    $serviceName = truncateString($serviceInfo->name, 50);

    // get the website title info from db
    $info = Basic::select('website_title')->first();

    $price = $booking->currency_symbol . $booking->customer_paid;
    $appointmentTime = $booking->start_date . ' to ' . $booking->end_date;

    // replacing with actual data
    $mailBody = str_replace('{service_title}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
    $mailBody = str_replace('{customer_name}', $booking->customer_name, $mailBody);
    $mailBody = str_replace('{booking_date}', date_format($booking->created_at, 'M d, Y'), $mailBody);
    $mailBody = str_replace('{appointment_date}', Carbon::parse($booking->booking_date)->format('M d, Y'), $mailBody);
    $mailBody = str_replace('{appointment_time}', $appointmentTime, $mailBody);
    $mailBody = str_replace('{website_title}', $info->website_title, $mailBody);
    $mailBody = str_replace('{price}', $price, $mailBody);

    $mailData['body'] = $mailBody;
    $mailData['recipient'] = $booking->customer_email;

    BasicMailer::sendMail($mailData);

    return;
  }
}
