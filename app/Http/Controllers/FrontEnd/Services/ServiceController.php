<?php

namespace App\Http\Controllers\FrontEnd\Services;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Http\Helpers\BasicMailer;
use App\Http\Helpers\CheckLimitHelper;
use App\Models\Admin;
use App\Models\Admin\AdminGlobalDay;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Language;
use App\Models\PaymentGateway\OfflineGateway;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Services\InqueryMessage;
use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceCategory;
use App\Models\Services\ServiceContent;
use App\Models\Services\ServiceReview;
use App\Models\Services\Services;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffDay;
use App\Models\Staff\StaffGlobalDay;
use App\Models\Staff\StaffGlobalHoliday;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffHoliday;
use App\Models\Staff\StaffService;
use App\Models\Staff\StaffServiceHour;
use App\Models\Vendor;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Response;
use Session;

class ServiceController extends Controller
{
  /**
   * services page
   */
  public function index(Request $request)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $information['pageHeading'] = $misc->getPageHeading($language);
    //active or deactive vendor check
    $vendorStatus = Vendor::where('status', 1)->select('id')->get()->toArray();


    //service count category wise
    $categories = ServiceCategory::where('language_id', $language->id)->get();
    foreach ($categories as $category) {
      $serviceCount = Services::join(
        'service_contents',
        'service_contents.service_id',
        '=',
        'services.id',
      )
        ->where(function ($query) use ($vendorStatus) {
          $query->whereIn('services.vendor_id', $vendorStatus)
            ->orWhere('services.vendor_id', 0);
        })
        ->when('services.vendor_id' != '0', function ($query) {
          return $query
            ->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
            ->where(function ($query) {
              $query
                ->where([
                  ['memberships.status', '=', 1],
                  ['memberships.start_date', '<=', now()->format('Y-m-d')],
                  ['memberships.expire_date', '>=', now()->format('Y-m-d')],
                ])
                ->orWhere('services.vendor_id', '=', 0);
            });
        })
        ->where('service_contents.category_id', $category->id)
        ->where('services.status', 1)
        ->where('service_contents.language_id', $category->language_id)
        ->count();
      $category->service_count = $serviceCount;
    }
    $information['categories'] = $categories;

    $information['seoInfo'] = $language->seoInfo()->select('meta_keyword_services', 'meta_description_services')->first();
    $information['bgImg'] = $misc->getBreadcrumb();

    $location  = $serviceName = $category = null;

    //search by category
    $category_serviceId = [];
    if ($request->filled('category')) {
      $category = $request->category;
      $category_content = ServiceCategory::where([['language_id', $language->id], ['slug', $category]])->first();

      if (!empty($category_content)) {
        $category_id = $category_content->id;
        $contents = ServiceContent::where('language_id', $language->id)
          ->where('category_id', $category_id)
          ->get()
          ->pluck('service_id');
        foreach ($contents as $content) {
          if (!in_array($content, $category_serviceId)) {
            array_push($category_serviceId, $content);
          }
        }
      }
    }

$locationIds = [];

if ($request->filled('location')) {
    $location = preg_replace('/\s+/', '', $request->location); // Remove spaces
    $inputLength = strlen($location);

    $prefixes = [];

    // Build prefix list from most specific to least
    if ($inputLength >= 3) {
        $prefixes[] = substr($location, 0, 3);
        $prefixes[] = substr($location, 0, 2);
        $prefixes[] = substr($location, 0, 1);
    } elseif ($inputLength == 2) {
        $prefixes[] = substr($location, 0, 2);
        $prefixes[] = substr($location, 0, 1);
    } elseif ($inputLength == 1) {
        $prefixes[] = substr($location, 0, 1);
    }

    foreach ($prefixes as $prefix) {
        // Escape special regex characters
        $safePrefix = preg_quote($prefix, '/');

        $locationIds = ServiceContent::where('language_id', $language->id)
            ->where(function ($query) use ($safePrefix) {
                $query->whereRaw(
                        "postcode REGEXP ?",
                        ["(^|,)" . $safePrefix . "[0-9]*($|,)"]
                    )
                    ->orWhereNull('postcode')
                    ->orWhere('postcode', '');
            })
            ->pluck('service_id')
            ->unique()
            ->toArray();

        if (!empty($locationIds)) {
            break; // Stop if matches found
        }
    }
}



    //search by service name
    $serviceNameIds = [];
    if ($request->filled('service_title')) {
      $serviceName = $request->service_title;

      $contents = ServiceContent::where('language_id', $language->id)
        ->where('name', 'like', '%' . $serviceName . '%')
        ->get()
        ->pluck('service_id');
      foreach ($contents as $content) {
        if (!in_array($content, $serviceNameIds)) {
          array_push($serviceNameIds, $content);
        }
      }
    }

    $featuredServices = Services::join('service_promotions', 'service_promotions.service_id', '=', 'services.id')
      ->join('service_contents', 'services.id', '=', 'service_contents.service_id')
      ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
      ->where('service_contents.language_id', $language->id)
      ->where('services.status', 1)
      ->where(function ($query) use ($vendorStatus) {
        $query->whereIn('services.vendor_id', $vendorStatus)
          ->orWhere('services.vendor_id', 0);
      })
      ->where('service_promotions.order_status', '=', 'approved')
      ->where('service_promotions.payment_status', '=', 'completed')
      ->whereDate('service_promotions.end_date', '>=', Carbon::now()->format('Y-m-d'))
      ->when('services.vendor_id' != "0", function ($query) {
        return $query->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
          ->where(function ($query) {
            $query->where([
              ['memberships.status', '=', 1],
              ['memberships.start_date', '<=', now()->format('Y-m-d')],
              ['memberships.expire_date', '>=', now()->format('Y-m-d')],
            ])->orWhere('services.vendor_id', '=', 0);
          });
      })
      ->when($category, function ($query) use ($category_serviceId) {
        return $query->whereIn('services.id', $category_serviceId);
      })
      ->when($location, function ($query) use ($locationIds) {
        return $query->whereIn('services.id', $locationIds);
      })
      ->when($serviceName, function ($query) use ($serviceNameIds) {
        return $query->whereIn('services.id', $serviceNameIds);
      })
      ->select(
        'services.*',
        'service_contents.name',
        'service_contents.slug',
        'service_contents.address',
        'service_categories.name as categoryName',
        'service_categories.id as categoryid',
      )
      ->inRandomOrder()
      ->take(3)
      ->get();

    $information['featuredServices'] = $featuredServices;

    $numFeaturedServices = $featuredServices->count();
    $numRegularServices = max(0, 12 - $numFeaturedServices);

    $featuredServiceIds = $featuredServices->pluck('id')->toArray();

    $services = Services::with('vendor')
      ->join('service_contents', 'services.id', '=', 'service_contents.service_id')
      ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
      ->where('service_contents.language_id', $language->id)
      ->where('services.status', 1)
      ->whereNotIn('services.id', $featuredServiceIds)
      ->where(function ($query) use ($vendorStatus) {
        $query->whereIn('services.vendor_id', $vendorStatus)
          ->orWhere('services.vendor_id', 0);
      })
      ->when('services.vendor_id' != "0", function ($query) {
        return $query->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
          ->where(function ($query) {
            $query->where([
              ['memberships.status', '=', 1],
              ['memberships.start_date', '<=', now()->format('Y-m-d')],
              ['memberships.expire_date', '>=', now()->format('Y-m-d')],
            ])->orWhere('services.vendor_id', '=', 0);
          });
      })
      ->when($category, function ($query) use ($category_serviceId) {
        return $query->whereIn('services.id', $category_serviceId);
      })
      ->when($location, function ($query) use ($locationIds) {
        return $query->whereIn('services.id', $locationIds);
      })
      ->when($serviceName, function ($query) use ($serviceNameIds) {
        return $query->whereIn('services.id', $serviceNameIds);
      })
      ->select(
        'services.*',
        'service_contents.name',
        'service_contents.slug',
        'service_contents.address',
        'service_categories.name as categoryName',
        'service_categories.id as categoryid',
      )
      ->orderBy('services.created_at', 'desc')
      ->paginate($numRegularServices);

    //total service count
    $information['services'] = $services;
    $featuredServiceCount = $featuredServices->count();
    $serviceCount = $services->total();
    $information['total_services'] = $featuredServiceCount + $serviceCount;

    //admin info
    $information['admin'] = Admin::whereNull('role_id')->firstOrFail();

    //sidebara search
    $information['min'] = Services::where('status', 1)->min('price');
    $information['max'] = Services::where('status', 1)->max('price');

    //Strip payment
    $stripe = OnlineGateway::where('keyword', 'stripe')->first();
    $stripe_info = json_decode($stripe->information, true);
    $information['stripe_key'] = $stripe_info['key'];

    //Authorize.Net payment
    $authorizeNet = OnlineGateway::where('keyword', 'authorize.net')->first();
    $authorizeInfo = json_decode($authorizeNet->information, true);

    if ($authorizeInfo['sandbox_check'] == 1) {
      $information['authorizeUrl'] = 'https://jstest.authorize.net/v1/Accept.js';
    } else {
      $information['authorizeUrl'] = 'https://js.authorize.net/v1/Accept.js';
    }

    $information['authorize_login_id'] = $authorizeInfo['login_id'];
    $information['authorize_public_key'] = $authorizeInfo['public_key'];

    return view('frontend.services.service_list', $information);
  }

  /**
   * service search pagination & sort
   */
  public function searchService(Request $request)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    //admin info
    $information['admin'] = Admin::whereNull('role_id')->firstOrFail();
    $information['seoInfo'] = $language->seoInfo()->select('meta_keyword_services', 'meta_description_services')->first();
    $information['bgImg'] = $misc->getBreadcrumb();


    $min = $max = $category = $rating = $sort = $location = $service_type = $serviceName = null;

    //search by category
    $category_serviceId = [];
    if ($request->filled('category')) {
      $category = $request->category;
      $category_content = ServiceCategory::where([['language_id', $language->id], ['slug', $category]])->first();
      if (!empty($category_content)) {
        $category_id = $category_content->id;
        $contents = ServiceContent::where('language_id', $language->id)
          ->where('category_id', $category_id)
          ->get()
          ->pluck('service_id');
        foreach ($contents as $content) {
          if (!in_array($content, $category_serviceId)) {
            array_push($category_serviceId, $content);
          }
        }
      }
    }
    //search by price
    $priceIds = [];
    if ($request->filled('min_val') && $request->filled('max_val')) {
      $min = intval($request->min_val);
      $max = intval(($request->max_val));
      $price_servicess = DB::table('services')
        ->select('*')
        ->where('price', '>=', $min)
        ->where('price', '<=', DB::raw($max))
        ->get();
      foreach ($price_servicess as $service) {
        if (!in_array($service->id, $priceIds)) {
          array_push($priceIds, $service->id);
        }
      }
    }
    //search by location
    $locationIds = [];
    if ($request->filled('location_val')) {
      $location = $request->location_val;
      $contents = ServiceContent::where('language_id', $language->id)
        ->where('address', 'like', '%' . $location . '%')
        ->get()
        ->pluck('service_id');
      foreach ($contents as $content) {
        if (!in_array($content, $locationIds)) {
          array_push($locationIds, $content);
        }
      }
    }

    //search by service name
    $serviceNameIds = [];
    if ($request->filled('service_title')) {
      $serviceName = $request->service_title;

      $contents = ServiceContent::where('language_id', $language->id)
        ->where('name', 'like', '%' . $serviceName . '%')
        ->get()
        ->pluck('service_id');
      foreach ($contents as $content) {
        if (!in_array($content, $serviceNameIds)) {
          array_push($serviceNameIds, $content);
        }
      }
    }

    //search by service type
    $serviceTypeId = [];
    if ($request->filled('service_type')) {
      $service_type = $request->service_type;

      if ($service_type == 'online') {
        $services = Services::where('zoom_meeting', 1)->get()->pluck('id');
      } elseif ($service_type == 'offline') {
        $services = Services::where('zoom_meeting', 0)->get()->pluck('id');
      } else {
        $services = Services::query()->get()->pluck('id');
      }
      foreach ($services as $service) {
        if (!in_array($service, $serviceTypeId)) {
          array_push($serviceTypeId, $service);
        }
      }
    }


    //search by rating
    if ($request->filled('rating')) {
      $rating = floatval($request['rating']);
    }
    if ($request->filled('sort_val')) {
      $sort = $request['sort_val'];
    }

    $vendorStatus = Vendor::where('status', 1)->select('id')->get()->toArray();

    $featuredServices = Services::join('service_promotions', 'service_promotions.service_id', '=', 'services.id')
      ->join('service_contents', 'services.id', '=', 'service_contents.service_id')
      ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
      ->where('service_contents.language_id', $language->id)
      ->where('services.status', 1)
      ->where(function ($query) use ($vendorStatus) {
        $query->whereIn('services.vendor_id', $vendorStatus)
          ->orWhere('services.vendor_id', 0);
      })
      ->where('service_promotions.order_status', '=', 'approved')
      ->whereDate('service_promotions.end_date', '>=', Carbon::now()->format('Y-m-d'))
      ->when('services.vendor_id' != "0", function ($query) {
        return $query->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
          ->where(function ($query) {
            $query->where([
              ['memberships.status', '=', 1],
              ['memberships.start_date', '<=', now()->format('Y-m-d')],
              ['memberships.expire_date', '>=', now()->format('Y-m-d')],
            ])->orWhere('services.vendor_id', '=', 0);
          });
      })
      ->when($category, function ($query) use ($category_serviceId) {
        return $query->whereIn('services.id', $category_serviceId);
      })
      ->when(($min && $max), function ($query) use ($priceIds) {
        return $query->whereIn('services.id', $priceIds);
      })
      ->when($rating, function ($query, $rating) {
        return $query->where('services.average_rating', '>=', $rating);
      })
      ->when($location, function ($query) use ($locationIds) {
        return $query->whereIn('services.id', $locationIds);
      })
      ->when($serviceName, function ($query) use ($serviceNameIds) {
        return $query->whereIn('services.id', $serviceNameIds);
      })
      ->when($service_type, function ($query) use ($serviceTypeId) {
        return $query->whereIn('services.id', $serviceTypeId);
      })
      ->select(
        'services.*',
        'service_contents.name',
        'service_contents.slug',
        'service_contents.address',
        'service_categories.name as categoryName',
        'service_categories.id as categoryid',
      )
      ->inRandomOrder()
      ->limit(3)
      ->get();

    $information['featuredServices'] = $featuredServices;

    $numFeaturedServices = $featuredServices->count();
    $numRegularServices = max(0, 12 - $numFeaturedServices);

    $featuredServiceIds = $featuredServices->pluck('id')->toArray();

    $services = Services::join('service_contents', 'services.id', '=', 'service_contents.service_id')
      ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
      ->where('service_contents.language_id', $language->id)
      ->where('services.status', 1)
      ->where(function ($query) use ($vendorStatus) {
        $query->whereIn('services.vendor_id', $vendorStatus)
          ->orWhere('services.vendor_id', 0);
      })
      ->whereNotIn('services.id', $featuredServiceIds)
      ->when('services.vendor_id' != "0", function ($query) {
        return $query->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
          ->where(function ($query) {
            $query->where([
              ['memberships.status', '=', 1],
              ['memberships.start_date', '<=', now()->format('Y-m-d')],
              ['memberships.expire_date', '>=', now()->format('Y-m-d')],
            ])->orWhere('services.vendor_id', '=', 0);
          });
      })
      ->when($category, function ($query) use ($category_serviceId) {
        return $query->whereIn('services.id', $category_serviceId);
      })
      ->when(($min && $max), function ($query) use ($priceIds) {
        return $query->whereIn('services.id', $priceIds);
      })
      ->when($rating, function ($query, $rating) {
        return $query->where('services.average_rating', '>=', $rating);
      })
      ->when($location, function ($query) use ($locationIds) {
        return $query->whereIn('services.id', $locationIds);
      })
      ->when($serviceName, function ($query) use ($serviceNameIds) {
        return $query->whereIn('services.id', $serviceNameIds);
      })
      ->when($service_type, function ($query) use ($serviceTypeId) {
        return $query->whereIn('services.id', $serviceTypeId);
      })
      ->select(
        'services.*',
        'service_contents.name',
        'service_contents.slug',
        'service_contents.address',
        'service_categories.name as categoryName',
        'service_categories.id as categoryid',
      )->when($sort, function ($query, $sort) {
        if ($sort == 'newest') {
          return $query->orderBy('services.created_at', 'desc');
        } else if ($sort == 'old') {
          return $query->orderBy('services.created_at', 'asc');
        } else if ($sort == 'high-to-low') {
          return $query->orderBy('services.price', 'desc');
        } else if ($sort == 'low-to-high') {
          return $query->orderBy('services.price', 'asc');
        }
      }, function ($query) {
        return $query->orderByDesc('services.created_at');
      })
      ->paginate($numRegularServices);
    $information['services'] = $services;


    $information['min'] = Services::where('status', 1)->min('price');
    $information['max'] = Services::where('status', 1)->max('price');

    //Strip payment
    $stripe = OnlineGateway::where('keyword', 'stripe')->first();
    $stripe_info = json_decode($stripe->information, true);
    $information['stripe_key'] = $stripe_info['key'];

    //Authorize.Net payment
    $authorizeNet = OnlineGateway::where('keyword', 'authorize.net')->first();
    $authorizeInfo = json_decode($authorizeNet->information, true);

    if ($authorizeInfo['sandbox_check'] == 1) {
      $information['authorizeUrl'] = 'https://jstest.authorize.net/v1/Accept.js';
    } else {
      $information['authorizeUrl'] = 'https://js.authorize.net/v1/Accept.js';
    }

    $information['authorize_login_id'] = $authorizeInfo['login_id'];
    $information['authorize_public_key'] = $authorizeInfo['public_key'];


    return view('frontend.services.search.search-services', $information)->render();
  }

  /**
   * show staff content
   */
  public function staffcontent($id)
  {
    try {
      // Get service info
      $service = Services::find($id);
      
      if (!$service) {
        return response()->json(['error' => 'Service not found.'], 404);
      }

      // Create minimal required data
      $information = [];
      
      // Create a default staff entry for general booking
      $defaultStaff = (object) [
        'id' => '11done',
        'name' => '11DONE Service',
        'is_day' => 0,
        'role' => 'vendor',
        'vendor_id' => $service->vendor_id,
        'email' => '',
        'image' => 'default.png',
        'email_status' => 0,
        'status' => 1,
        'username' => '11done'
      ];

      $information['staffs'] = collect([$defaultStaff]);
      $information['staffCount'] = 1;
      $information['staffService'] = 1;

      // Store service data in session
      Session::put('serviceData', [
        'vendor_id' => $service->vendor_id,
        'service_ammount' => $service->price,
        'service_id' => $service->id,
        'zoom_status' => $service->zoom_meeting ?? 0,
        'calendar_status' => $service->calendar_status ?? 0,
      ]);

      // Get basic settings
      $information['bs'] = Basic::select('google_recaptcha_status')->first();
      $information['authUser'] = Auth::guard('web')->check() ? Auth::guard('web')->user() : null;
      $information['groupService'] = Services::where('id', $id)->select('max_person')->first();

      // Get payment gateways
      $information['online_gateways'] = OnlineGateway::where('status', 1)->get();
      $information['offline_gateways'] = OfflineGateway::where('status', 1)->orderBy('serial_number', 'desc')->get();

      return view('frontend.services.booking-modal.service-modal', $information);
      
    } catch (\Exception $e) {
      \Log::error('Staff content error: ' . $e->getMessage());
      return response()->json(['error' => 'Service temporarily unavailable. Please try again.'], 500);
    }
  }

  /**
   * service details page
   */
  public function details($slug, $id)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();

    $currentLang =  Language::where('is_default', 1)->first();

    $information['admin'] = Admin::whereNull('role_id')->firstOrFail();

    $information['seoInfo'] = $language->seoInfo()->select('meta_keyword_services', 'meta_description_services')->first();
    $information['bgImg'] = $misc->getBreadcrumb();
    $queryResult['pageHeading'] = $misc->getPageHeading($language);

    //service details
    $serviceDetails = Services::with(['content' => function ($query) use ($language) {
      return $query->where('language_id', $language->id);
    }, 'sliderImage'])
      ->with(['vendorInfo' => function ($query) use ($language) {
        return $query->where('language_id', $language->id);
      }])
      ->when('services.vendor_id' != "0", function ($query) {
        return $query->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
          ->where(function ($query) {
            $query->where([
              ['memberships.status', '=', 1],
              ['memberships.start_date', '<=', now()->format('Y-m-d')],
              ['memberships.expire_date', '>=', now()->format('Y-m-d')],
            ])->orWhere('services.vendor_id', '=', 0);
          });
      })
      ->where('services.status', 1)
      ->select('services.*')
      ->where('services.id', $id)->firstOrFail();
       if ($serviceDetails->content->isEmpty()) {
      session()->put('currentLocaleCode', $currentLang->code);
      return redirect()->back()->with('warning', 'Content not available. Please try another language.');
    }

    $information['details'] = $serviceDetails;

    $information['reviews'] = ServiceReview::where('service_id', $id)->get();


    //category related service
    $service_content = ServiceContent::where('language_id', $language->id)->where('service_id', $id)->first();
    if ($service_content) {
      $category_id = $service_content->category_id;
      $information['related_services'] = Services::join('service_contents', 'services.id', '=', 'service_contents.service_id')
        ->join('service_categories', 'service_contents.category_id', '=', 'service_categories.id')
        ->where('service_contents.language_id', $language->id)
        ->where('service_categories.language_id', $language->id)
        ->where('services.id', '!=', $id)
        ->where('services.status', 1)
        ->where('service_contents.category_id', $category_id)
        ->when('services.vendor_id' != "0", function ($query) {
          return $query->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
            ->where(function ($query) {
              $query->where([
                ['memberships.status', '=', 1],
                ['memberships.start_date', '<=', now()->format('Y-m-d')],
                ['memberships.expire_date', '>=', now()->format('Y-m-d')],
              ])->orWhere('services.vendor_id', '=', 0);
            });
        })
        ->select('services.*', 'service_contents.slug', 'service_contents.name', 'service_contents.address', 'service_categories.name as category_name', 'service_categories.id as category_id')
        ->orderBy('services.created_at', 'desc')
        ->get();
    } else {
      $information['related_services'] = collect();
    }

    $globalDaysTable = ($serviceDetails->vendor_id != 0) ? 'staff_global_days' : 'admin_global_days';

    $serviceDays = StaffGlobalHour::join($globalDaysTable, 'staff_global_hours.global_day_id', '=', $globalDaysTable . '.id')
      ->where('staff_global_hours.vendor_id', $serviceDetails->vendor_id)
      ->selectRaw('min(start_time) AS minTime, max(end_time) AS maxTime, ' . $globalDaysTable . '.indx, ' . $globalDaysTable . '.is_weekend, ' . $globalDaysTable . '.day, ' . $globalDaysTable . '.id')
      ->groupBy('staff_global_hours.global_day_id', $globalDaysTable . '.indx', $globalDaysTable . '.is_weekend', $globalDaysTable . '.day', $globalDaysTable . '.id')
      ->get();

    $reordered = $serviceDays->map(function ($item, $key) {
      return [
        'dayId' => $item['id'],
        'minTime' => $item['minTime'],
        'maxTime' => $item['maxTime'],
        'day' => $item['day'],
        'is_weekend' => $item['is_weekend'],
        'indx' => $item['indx'],
      ];
    })->sortBy('indx');
    $information['allDays'] = $reordered;


    //Strip payment
    $stripe = OnlineGateway::where('keyword', 'stripe')->first();
    $stripe_info = json_decode($stripe->information, true);
    $information['stripe_key'] = $stripe_info['key'];

    //Authorize.Net payment
    $authorizeNet = OnlineGateway::where('keyword', 'authorize.net')->first();
    $authorizeInfo = json_decode($authorizeNet->information, true);

    if ($authorizeInfo['sandbox_check'] == 1) {
      $information['authorizeUrl'] = 'https://jstest.authorize.net/v1/Accept.js';
    } else {
      $information['authorizeUrl'] = 'https://js.authorize.net/v1/Accept.js';
    }

    $information['authorize_login_id'] = $authorizeInfo['login_id'];
    $information['authorize_public_key'] = $authorizeInfo['public_key'];

    return view('frontend.services.details', $information);
  }

  /**
   * show staff service hour
   */
  public function staffHour(Request $request)
  {
    $staff = Staff::find($request->staff_id);
    $information['staff'] = $staff;

    //count same hour from booking table
    $bookedIds = [];

    $service_bookings = ServiceBooking::where('staff_id', $request->staff_id)
      ->where('booking_date', $request->bookingDate)
      ->select('service_hour_id')->get();

    foreach ($service_bookings as $service_booking) {
      array_push($bookedIds, $service_booking->service_hour_id);
    }

    $bookedCount = count($bookedIds);
    $information['staff_time'] = StaffServiceHour::leftJoin('staff_days', 'staff_days.id', '=', 'staff_service_hours.staff_day_id')
      ->leftJoin('service_bookings', function ($join) use ($request, $bookedCount) {
        $join->on('service_bookings.service_hour_id', '=', 'staff_service_hours.id')
          ->where('service_bookings.booking_date', '=', $request->bookingDate)
          ->where(function ($query) use ($bookedCount) {
            $query->where('staff_service_hours.max_booking', '<=', $bookedCount);
          })
          ->where('service_bookings.order_status', '!=', 'rejected')
          ->where('service_bookings.staff_id', '=', $request->staff_id);
      })
      ->whereNull('service_bookings.id')
      ->where('staff_days.staff_id', $request->staff_id)
      ->where('staff_service_hours.staff_id', $request->staff_id)
      ->where('staff_days.day', $request->dayName)
      ->select('staff_days.day', 'staff_service_hours.start_time', 'staff_service_hours.end_time', 'staff_service_hours.id', 'staff_service_hours.staff_id', 'staff_service_hours.max_booking')
      ->get();

    if ($request->vendor_id != 0) {
      $information['global_time'] = StaffGlobalHour::join('staff_global_days', 'staff_global_days.id', '=', 'staff_global_hours.global_day_id')
        ->leftJoin('service_bookings', function ($join) use ($request, $bookedCount) {
          $join->on('service_bookings.service_hour_id', '=', 'staff_global_hours.id')
            ->where('service_bookings.booking_date', '=', $request->bookingDate)
            ->where(function ($query) use ($bookedCount) {
              $query->where('staff_global_hours.max_booking', '<=', $bookedCount);
            })
            ->where('service_bookings.order_status', '!=', 'rejected')
            ->where('service_bookings.staff_id', '=', $request->staff_id);
        })
        ->whereNull('service_bookings.id')
        ->where('staff_global_hours.vendor_id', $request->vendor_id)
        ->where('staff_global_days.day', $request->dayName)
        ->select('staff_global_days.day', 'staff_global_hours.start_time', 'staff_global_hours.end_time', 'staff_global_hours.id')
        ->get();
    } else {
      $information['global_time'] = StaffGlobalHour::join('admin_global_days', 'admin_global_days.id', '=', 'staff_global_hours.global_day_id')
        ->leftJoin('service_bookings', function ($join) use ($request, $bookedCount) {
          $join->on('service_bookings.service_hour_id', '=', 'staff_global_hours.id')
            ->where('service_bookings.booking_date', '=', $request->bookingDate)
            ->where(function ($query) use ($bookedCount) {
              $query->where('staff_global_hours.max_booking', '<=', $bookedCount);
            })
            ->where('service_bookings.order_status', '!=', 'rejected')
            ->where('service_bookings.staff_id', '=', $request->staff_id);
        })
        ->whereNull('service_bookings.id')
        ->where('staff_global_hours.vendor_id', $request->vendor_id)
        ->where('admin_global_days.day', $request->dayName)
        ->select('admin_global_days.day', 'staff_global_hours.start_time', 'staff_global_hours.end_time', 'staff_global_hours.id')
        ->get();
    }

    $service = Services::findOrFail($request->serviceId);
    if (!empty($service->max_person)) {
      $information['maxPerson'] = $service->max_person;
    }
    return view('frontend.services.booking-modal.time', $information);
  }

  //show staff holiday
  public function staffHoliday($id)
  {
    $staff = Staff::find($id);
    $vendor_id = $staff->vendor_id;

    if (Session::has('serviceData')) {
      $service = Session::get('serviceData');
    }

    $holiday = StaffHoliday::where('staff_id', $id)
      ->where('vendor_id', $vendor_id)
      ->get();

    $globalWeekend = StaffGlobalDay::where('is_weekend', 1)
      ->where('vendor_id', $vendor_id)
      ->get();

    $adminGlobalWeekend = AdminGlobalDay::where('is_weekend', 1)
      ->get();

    $staffWeekend = StaffDay::where('is_weekend', 1)
      ->where('staff_id', $id)
      ->where('vendor_id', $vendor_id)
      ->get();

    $serviceHoure = StaffServiceHour::where('staff_id', $id)
      ->get();

    $globalHoliday = StaffGlobalHoliday::where('vendor_id', $vendor_id)
      ->select('date')
      ->get();

    $array = [
      'holiday' => $holiday,
      'globalHoliday' => $globalHoliday,
      'staffWeekend' => $staffWeekend,
      'globalWeekend' => $globalWeekend,
      'adminGlobalWeekend' => $adminGlobalWeekend,
      'serviceHoure' => $serviceHoure,
      'vendor_id' => $vendor_id,
      'serviceId' => $service['service_id'],
    ];

    return $array;
  }

  //curstomer login
  public function login(Request $request)
  {
    $rules = [
      'username' => 'required',
      'password' => 'required'
    ];

    $info = Basic::select('google_recaptcha_status')->first();
    if ($info->google_recaptcha_status == 1) {
      $rules['g-recaptcha-response'] = 'required|captcha';
    }

    $messages = [];

    if ($info->google_recaptcha_status == 1) {
      $messages['g-recaptcha-response.required'] = 'Please verify that you are not a robot.';
      $messages['g-recaptcha-response.captcha'] = 'Captcha error! try again later or contact site admin.';
    }

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    // get the email and password which has provided by the user
    $credentials = $request->only('username', 'password');

    // login attempt
    if (Auth::guard('web')->attempt($credentials)) {
      $authUser = Auth::guard('web')->user();

      if ($authUser->email_verified_at == null) {
        return response()->json(['error' => 'Please verify your email address']);
      }
      if ($authUser->status == 0) {
        return response()->json(['error' => 'Sorry, your account has been deactivated']);
      }
      $billingData = [
        'name' => $authUser->name,
        'email' => $authUser->email,
        'address' => $authUser->address,
        'zip_code' => $authUser->zip_code,
        'country' => $authUser->country,
        'user_id' => $authUser->id,
        'phone' => $authUser->phone,
      ];
      return response()->json([
        'success' => 'Login successful',
        'billingData' => $billingData,
      ]);
    } else {
      return response()->json(['error' => 'Incorrect username or password']);
    }
  }

  public function sessionForget()
  {
    Session::forget('complete');
    Session::forget('paymentInfo');
    Session::forget('serviceData');
  }

  //staff search
  public function staffSearch(Request $request, $id)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $vendor_id = Services::where('id', $id)->pluck('vendor_id')->first();
    // Initial query to find staff based on service ID and other criteria
    $staffs = Staff::join('staff_contents', 'staff.id', '=', 'staff_contents.staff_id')
      ->join('staff_services', 'staff.id', '=', 'staff_services.staff_id')
      ->where('staff_services.service_id', $id)
      ->where('staff_contents.language_id', $language->id)
      ->where(function ($query) use ($request) {
        $query->where('staff_contents.name', 'like', '%' . $request->searchVal . '%')
          ->orWhere('staff.email', 'like', '%' . $request->searchVal . '%')
          ->orWhere('staff_contents.location', 'like', '%' . $request->searchVal . '%');
      })
      ->where('status', 1)
      ->select(
        'staff.id',
        'staff.email',
        'staff.image',
        'staff.is_day',
        'staff_contents.name',
        'staff_contents.staff_id'
      )
      ->get();
    return view('frontend.services.booking-modal.staff-search-data', compact('staffs'));
  }


  //customer message
  public function message(Request $request)
  {
    try {
      $rules = [
        'first_name' => 'required',
        'email' => 'required',
        'message' => 'required'
      ];

      $message = [
        'first_name.required' => 'The name field is required.',
        'email.required' => 'The email field is required.',
        'message.required' => 'The message field is required.',
      ];

      $validator = Validator::make($request->all(), $rules, $message);

      if ($validator->fails()) {
        return redirect()->back()
          ->withErrors($validator)
          ->withInput()
          ->with('error', 'Field is missing !');
      }

      $bookingInfo = InqueryMessage::create([
        'vendor_id' => $request->vendor_id,
        'service_id' => $request->service_id,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'message' => $request->message,
      ]);

      $bs = DB::table('basic_settings')->select('to_mail')->first();
      $admin = Admin::whereNull('role_id')->select('email', 'username')->first();
      if ($bs->to_mail != null) {
        $admin_email = $bs->to_mail;
      } else {
        $admin_email = $admin->email;
      }

      if ($request->vendor_id != 0) {
        $to_mail = DB::table('vendors')
          ->where('id', $request->vendor_id)
          ->select('recived_email')->first();
        $vendor_mail =  $to_mail->recived_email;
      } else {
        $vendor_mail = $admin_email;
      }

      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'service_inquery')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // get the website title info from db
      $info = Basic::select('website_title')->first();

      $name = $request->first_name . '' . $request->last_name;
      $message = $request->message;
      $email = $bookingInfo->email;
      $service_name = $bookingInfo->service->name;
      $url = route('frontend.service.details', ['slug' => $bookingInfo->service->slug, 'id' => $bookingInfo->service_id]);

      if ($request->vendor_id != 0) {
        $vendor_name = $bookingInfo->vendor->name;
      } else {
        $vendor_name = $admin->username;
      }
      $websiteTitle = $info->website_title;
      // replacing with actual data
      $mailBody = str_replace('{username}', $vendor_name, $mailBody);
      $mailBody = str_replace('{enquirer_name}', "<a href=" . $url . ">$service_name</a>", $mailBody);
      $mailBody = str_replace('{service_name}', $service_name, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);
      $mailBody = str_replace('{enquirer_email}', $email, $mailBody);
      $mailBody = str_replace('{enquirer_message}', $message, $mailBody);

      $mailData['body'] = $mailBody;

      $mailData['recipient'] = $vendor_mail;

      BasicMailer::sendMail($mailData);

      Session::flash('message', 'Message sent successfully');
      Session::flash('alert-type', 'success');
      return redirect()->back();
    } catch (\Exception $e) {
      Session::flash('message', 'Something went wrong.');
      Session::flash('alert-type', 'error');
      return redirect()->back();
    }
  }


  //review store
  public function storeReview(Request $request, $id)
  {
    $rule = ['rating' => 'required'];

    $validator = Validator::make($request->all(), $rule);

    if ($validator->fails()) {
      return redirect()->back()
        ->with('error', 'The rating field is required for product review.')
        ->withInput();
    }

    $serviceBooking = false;

    // get the authenticate user
    $user = Auth::guard('web')->user();

    // then, get the purchases of that user
    $booking = $user->serviceBooking()->where('payment_status', 'completed')->get();

    if (count($booking) > 0) {
      foreach ($booking as $bookItem) {
        if ($bookItem->service_id == $id) {
          $serviceBooking = true;
        }
      }

      if ($serviceBooking == true) {
        ServiceReview::updateOrCreate(
          ['user_id' => $user->id, 'service_id' => $id, 'vendor_id' => $request->vendor_id],
          ['comment' => $request->comment, 'rating' => $request->rating]
        );

        // now, get the average rating of this product
        $reviews = ServiceReview::where('service_id', $id)->get();

        $totalRating = 0;

        foreach ($reviews as $review) {
          $totalRating += $review->rating;
        }

        $numOfReview = count($reviews);

        $averageRating = number_format($totalRating / $numOfReview, 1);

        // finally, store the average rating of this product
        Services::find($id)->update(['average_rating' => $averageRating]);

        Session::flash('success', 'Your review submitted successfully.');
      } else {
        Session::flash('error', 'You have not bought this service yet!');
      }
    } else {
      Session::flash('error', 'You have not booking anything yet!');
    }

    return redirect()->back();
  }

  //payment success message
  public function paymentSuccess($id)
  {
    $misc = new MiscellaneousController();
    $language = $misc->getLanguage();
    $language_id = $language->id;

    $information['staffs'] = Staff::join('staff_contents', 'staff.id', '=', 'staff_contents.staff_id')
      ->join('staff_services', 'staff.id', '=', 'staff_services.staff_id')
      ->where('staff_services.service_id', $id)
      ->where('staff_contents.language_id', $language->id)
      ->where('status', 1)
      ->select(
        'staff.is_day',
        'staff.id',
        'staff.email',
        'staff.image',
        'staff_contents.name',
        'staff.vendor_id as vendor_id',
        'staff_contents.staff_id',
      )
      ->get();

    $information['bs'] = Basic::query()->select('google_recaptcha_status')->first();
    $information['authUser'] = Auth::guard('web')->check() == true ? Auth::guard('web')->user() : null;
    $information['admin'] = Admin::whereNull('role_id')->first();


    $information['online_gateways'] = OnlineGateway::where('status', 1)->get();
    $information['offline_gateways'] = OfflineGateway::where('status', 1)->orderBy('serial_number', 'asc')->get();

    $appointment  = Session::get('paymentInfo');
    $information['bookingInfo'] = ServiceBooking::with(['serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->findOrFail($appointment->id);

    return view('frontend.services.booking-modal.service-modal', $information);
  }

  //billing form
  public function billing(Request $request)
  {
    $rules = [
      'name' => 'required',
      'phone' => 'required',
      'email' => 'required',
      'address' => 'required',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    $data = [
      'name' => $request->name,
      'phone' => $request->phone,
      'email' => $request->email,
      'address' => $request->address,
      'zip_code' => $request->zip_code,
      'country' => $request->country,
      'booking_date' => $request->booking_date,
      'user_id' => $request->user_id,
      'staff_id' => '11done', // Set default staff ID
      'service_hour_id' => $request->service_hour_id,
      'max_person' => $request->max_person,
    ];

    return response()->json($data);
  }

  //show general holiday and availability for service
  public function generalHoliday($serviceId)
  {
    $service = Services::find($serviceId);
    $vendor_id = $service->vendor_id;

    // Store service data in session for later use
    Session::put('serviceData', ['service_id' => $serviceId]);

    // Get global holidays for the vendor
    $globalHoliday = StaffGlobalHoliday::where('vendor_id', $vendor_id)
      ->select('date')
      ->get();

    // Get global weekends for the vendor
    $globalWeekend = StaffGlobalDay::where('is_weekend', 1)
      ->where('vendor_id', $vendor_id)
      ->get();

    // Get admin global weekends if vendor is admin
    $adminGlobalWeekend = AdminGlobalDay::where('is_weekend', 1)
      ->get();

    $array = [
      'holiday' => collect(), // Empty collection since we're not using staff holidays
      'globalHoliday' => $globalHoliday,
      'staffWeekend' => collect(), // Empty collection since we're not using staff weekends
      'globalWeekend' => $globalWeekend,
      'adminGlobalWeekend' => $adminGlobalWeekend,
      'serviceHoure' => collect(), // Empty collection since we're using global hours
      'vendor_id' => $vendor_id,
      'serviceId' => $serviceId,
    ];

    return $array;
  }

  //show general time slots for a specific date
  public function showGeneralHour(Request $request, $serviceId)
  {
    $service = Services::find($serviceId);
    $vendor_id = $service->vendor_id;
    
    // Debug logging
    \Log::info('showGeneralHour called', [
      'serviceId' => $serviceId,
      'vendor_id' => $vendor_id,
      'dayName' => $request->dayName,
      'bookingDate' => $request->bookingDate
    ]);

    // Get all available global time slots for the selected day
    $globalTimeSlots = StaffGlobalHour::join('admin_global_days', 'admin_global_days.id', '=', 'staff_global_hours.global_day_id')
      ->where('staff_global_hours.vendor_id', $vendor_id)
      ->where('admin_global_days.day', $request->dayName)
      ->select('admin_global_days.day', 'staff_global_hours.start_time', 'staff_global_hours.end_time', 'staff_global_hours.id', 'staff_global_hours.max_booking')
      ->get();

    // If no global time slots, try admin global time slots
    if ($globalTimeSlots->isEmpty() && $vendor_id == 0) {
      $globalTimeSlots = StaffGlobalHour::join('admin_global_days', 'admin_global_days.id', '=', 'staff_global_hours.global_day_id')
        ->where('staff_global_hours.vendor_id', 0)
        ->where('admin_global_days.day', $request->dayName)
        ->select('admin_global_days.day', 'staff_global_hours.start_time', 'staff_global_hours.end_time', 'staff_global_hours.id', 'staff_global_hours.max_booking')
        ->get();
    }

    // Filter out booked time slots
    $availableSlots = [];
    foreach ($globalTimeSlots as $slot) {
      $bookedCount = ServiceBooking::where('service_hour_id', $slot->id)
        ->where('booking_date', $request->bookingDate)
        ->where('order_status', '!=', 'rejected')
        ->count();

      if ($bookedCount < $slot->max_booking) {
        $availableSlots[] = $slot;
      }
    }

    // Debug logging
    \Log::info('showGeneralHour result', [
      'globalTimeSlots_count' => $globalTimeSlots->count(),
      'availableSlots_count' => count($availableSlots),
      'availableSlots' => $availableSlots
    ]);

    return view('frontend.services.booking-modal.time-slots', compact('availableSlots'));
  }
}
