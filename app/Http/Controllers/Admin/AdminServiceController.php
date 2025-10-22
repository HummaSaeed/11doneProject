<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\BasicMailer;
use App\Http\Helpers\UploadFile;
use App\Http\Helpers\VendorPermissionHelper;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\FeaturedService\ServicePromotion;
use App\Models\Language;
use App\Models\PaymentGateway\OfflineGateway;
use App\Models\PaymentGateway\OnlineGateway;
use App\Models\Services\InqueryMessage;
use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceContent;
use App\Models\Services\ServiceImage;
use App\Models\Services\ServiceReview;
use App\Models\Services\Services;
use App\Models\Services\ServiceContentSub;
use App\Models\Services\Wishlist;
use App\Models\Staff\StaffService;
use App\Models\Vendor;
use App\Models\VendorInfo;
use PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Purifier;
use Session;
use Validator;

class AdminServiceController extends Controller
{
  public function index(Request $request)
  {
    $language = Language::where('code', $request->language)->firstOrFail();
    $information['language'] = $language;
    $information['langs'] = Language::all();
    $language_id = $language->id;

    $vendor_id  = $serviceName = null;
    if (request()->filled('vendor_id')) {
      $vendor_id = $request->vendor_id;
    }

    if ($request->filled('name')) {
      $serviceName = $request['name'];
    }

    $information['vendors'] = Vendor::where('id', '!=', 0)->get();

    $serviceIds = [];
    if (request()->filled('name')) {
      $name = $request->name;
      $service_contents = ServiceContent::where([['name', 'like', '%' . $name . '%'], ['language_id', $language->id]])->get();

      foreach ($service_contents as $service_content) {
        if (!in_array($service_content->service_id, $serviceIds)) {
          array_push($serviceIds, $service_content->service_id);
        }
      }
    }

    $information['services'] = Services::with([
      'content' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      },
      'vendor'
    ])
      ->when($vendor_id, function ($query) use ($vendor_id) {
        if ($vendor_id == 'admin') {
          return $query->where('vendor_id', '0');
        } else {
          return $query->where('vendor_id', $vendor_id);
        }
      })
      ->when($serviceName, function ($query) use ($serviceIds) {
        return $query->whereIn('id', $serviceIds);
      })
      ->orderBy('id', 'desc')
      ->paginate(10);

    $information['promotionList'] = FeaturedServiceCharge::all();

    $information['currencyInfo'] = $this->getCurrencyInfo();

    $online = OnlineGateway::query()->where('status', 1)->get();
    $offline = OfflineGateway::where('status', 1)->get();
    $information['gateways'] = $online->merge($offline);

    $information['themeInfo'] = DB::table('basic_settings')->select('theme_version')->first();

    return view('admin.services.index', $information);
  }

  public static function generateInvoice($requestInfo)
  {
    $fileName = $requestInfo->order_number . '.pdf';

    $data['orderInfo'] = $requestInfo;

    $directory = public_path('assets/file/invoices/featured/service/');
    @mkdir($directory, 0775, true);

    $fileLocated = $directory . $fileName;

    PDF::loadView('frontend.services.featured-service.invoice', $data)->save($fileLocated);

    return $fileName;
  }

  public function featured(Request $request)
  {
    $currencyInfo = $this->getCurrencyInfo();
    $charge = FeaturedServiceCharge::where('id', $request->promotion_id)->firstOrFail();

    $currentDate = Carbon::now();
    $formattedCurrentDate = $currentDate->format('Y-m-d');

    $endDate = $currentDate->copy()->addDays($charge->day);
    $formattedEndDate = $endDate->format('Y-m-d');

    try {
      $featured = ServicePromotion::create([
        'order_number' => uniqid(),
        'amount' => $charge->amount,
        'day' => $charge->day,
        'currency_text' => $currencyInfo->base_currency_text,
        'currency_text_position' => $currencyInfo->base_currency_text_position,
        'currency_symbol' => $currencyInfo->base_currency_symbol,
        'currency_symbol_position' => $currencyInfo->base_currency_symbol_position,
        'payment_status' => 'completed',
        'order_status' => 'approved',
        'service_id' => $request->service_id,
        'vendor_id' => $request->vendor_id,
        'payment_method' => $request->gatway,
        'gateway_type' => 'online',
        'start_date' => $formattedCurrentDate,
        'end_date' => $formattedEndDate,
      ]);
      $invoice = $this->generateInvoice($featured);
      $featured->update(['invoice' => $invoice]);

      $featuredRequest = ServicePromotion::find($featured->id);

      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'featured_service_payment_accepted')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // get the website title info from db
      $info = Basic::select('website_title')->first();

      $service = $featuredRequest->serviceContent->first();
      $serviceName = $service->name;
      $url = route('frontend.service.details', ['slug' => $service->slug, 'id' => $featuredRequest->service_id]);

      $websiteTitle = $info->website_title;
      $vendorName = VendorInfo::where('vendor_id', $featuredRequest->vendor_id)->first()->name;

      // replacing with actual data
      $startDate = Carbon::parse($featuredRequest->start_date)->formatLocalized('%e %B %Y');
      $endDate = Carbon::parse($featuredRequest->end_date)->formatLocalized('%e %B %Y');

      $mailBody = str_replace('{service_name}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
      $mailBody = str_replace('{username}', $vendorName, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);
      $mailBody = str_replace('{start_date}', $startDate, $mailBody);
      $mailBody = str_replace('{end_date}', $endDate, $mailBody);
      $mailBody = str_replace('{day}', $featuredRequest->day . " Days", $mailBody);

      $mailData['body'] = $mailBody;
      $mailData['recipient'] = $featuredRequest->vendor->email;
      $mailData['invoice'] = public_path('assets/file/invoices/featured/service/') . $featuredRequest->invoice;

      BasicMailer::sendMail($mailData);

      Session::flash('success', 'Featured service is active now!');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
    }
    return redirect()->back();
  }

  public function vendorSelect()
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
    return view('admin.services.select-vendor', $information);
  }
  public function create(Request $request)
  {
    if ($request->vendor_id) {

      if ($request->vendor_id != 'admin') {
        $current_package = VendorPermissionHelper::packagePermission($request->vendor_id);

        if ($current_package == '[]') {
          Session::flash('warning', 'This vendor is not available');
          return redirect()->route('admin.service_managment.vendor_select');
        }
      }

      $information['languages'] = Language::all();
      $information['currencyInfo'] = $this->getCurrencyInfo();
      return view('admin.services.create', $information);
    } else {
      Session::flash('warning', 'This vendor is not available');
      return redirect()->route('admin.service_managment.vendor_select');
    }
  }

  //service slider image
  public function imagesstore(Request $request)
  {
    $img = $request->file('file');
    $allowedExts = array('jpg', 'png', 'jpeg', 'svg', 'webp');
    $rules = [
      'file' => [
        function ($attribute, $value, $fail) use ($img, $allowedExts) {
          $ext = $img->getClientOriginalExtension();
          if (!in_array($ext, $allowedExts)) {
            return $fail("Only png, jpg, jpeg images are allowed");
          }
        },
      ]
    ];
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      $validator->getMessageBag()->add('error', 'true');
      return response()->json($validator->errors());
    }
    $filename = uniqid() . '.jpg';

    $directory = public_path('assets/img/services/service-gallery/');
    @mkdir($directory, 0775, true);
    $img->move($directory, $filename);

    $pi = new ServiceImage();
    if (!empty($request->service_id)) {
      $pi->service_id = $request->service_id;
    }
    $pi->image = $filename;
    $pi->save();
    return response()->json(['status' => 'success', 'file_id' => $pi->id]);
  }

  //delete slider image after reload
  public function deleteSliderImage()
  {
    try {
      $images = ServiceImage::all();
      return response()->json(['status' => 'success', 'images' => $images]);
    } catch (\Exception $e) {
      return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
  }


  public function removeImage(Request $request)
  {
    $pi = ServiceImage::findOrFail($request->fileid);
    $image_count = ServiceImage::where('service_id', $pi->service_id)->get()->count();
    if ($image_count > 1) {
      @unlink(public_path('assets/img/services/service-gallery/') . $pi->image);
      $pi->delete();
      return $pi->id;
    } else {
      return 'false';
    }
  }

  //imagedbrmv
  public function imagedbrmv(Request $request)
  {
    $pi = ServiceImage::findOrFail($request->fileid);
    $image_count = ServiceImage::where('service_id', $pi->service_id)->get()->count();
    if ($image_count > 1) {
      @unlink(public_path('assets/img/services/service-gallery/') . $pi->image);
      $pi->delete();
      Session::flash('success', 'Slider image deleted successfully!');
      return 'success';
    } else {
      Session::flash('warning', "You can't delete all images.!");
      return 'success';
    }
  }


  public function store(ServiceStoreRequest $request)
  {
    // store featured image in storage
    $service_image = UploadFile::store(public_path('assets/img/services/'), $request->file('service_image'));


    $languages = Language::all();

    $service = Services::create([
      'price' => $request->price,
      'zoom_meeting' => $request->zoom_meeting,
      'calendar_status' => $request->calender_status,
      'service_image' => $service_image,
      'vendor_id' => $request->vendor_id ? $request->vendor_id : 0,
      'status' => $request->status,
      'prev_price' => $request->prev_price,
      'max_person' => $request->person,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
    ]);

    //store slider image
    $sliders = $request->slider_images;
    if ($sliders) {
      $pis = ServiceImage::findOrFail($sliders);
      foreach ($pis as $key => $pi) {
        $pi->service_id = $service->id;
        $pi->save();
      }
    }


    foreach ($languages as $language) {
      $code = $language->code;
      if (
        $language->is_default == 1 ||
        $request->filled($code . '_name') ||
        $request->filled($code . '_description') ||
        $request->filled($code . '_category_id')
      ) {
        $content = new ServiceContent();
        $content->service_id  = $service->id;
        $content->language_id = $language->id;
        $content->category_id = $request[$code . '_category_id'];
        $content->name = $request[$code . '_name'];
        $content->address = $request[$code . '_address'];
        $content->postcode = $request[$code . '_postcode'];
        $content->slug = createSlug($request[$code . '_name']);
        $content->description = Purifier::clean($request[$code . '_description']);
        $content->meta_keyword = $request[$code . '_meta_keyword'];
        $content->features = $request[$code . '_features'];
        $content->meta_description = $request[$code . '_meta_description'];
        $content->save();
      }
    }
    Session::flash('success', 'New service added successfully!');
    return 'success';
  }

  public function edit($id)
  {
    $information['service'] = Services::with('sliderImage')->findOrFail($id);
    $information['languages'] = Language::all();
    $information['currencyInfo'] = $this->getCurrencyInfo();
    
  
    
    return view('admin.services.edit', $information);
  }
  
  
  public function sub_service_add(Request $request, $service_content_id) {
      
      
      dd($request->all());
      
  } 


  public function update($id, ServiceUpdateRequest $request)
  {
      

      
    $service = Services::findOrFail($id);
    
    if ($request->vendor_id != 0) {
      $current_package = VendorPermissionHelper::packagePermission($request->vendor_id);

      if ($current_package == '[]') {
        Session::flash('warning', 'This vendor is not available!');
        return 'success';
      }
      if ($current_package != '[]') {
        $currentServiceImg =  vendorTotalSliderImage($id);
        $limitServiceImg = $current_package->number_of_service_image;

        if ($currentServiceImg > $limitServiceImg) {
          Session::flash('warning', 'You can\'t add image more than' . $limitServiceImg . ' images!');
          return 'success';
        }
      }
    }
    // store servic image in storage
    if ($request->hasFile('service_image')) {
      $newImage = $request->file('service_image');
      $oldImage = $service->service_image;
      $serviceImgName = UploadFile::update(public_path('assets/img/services/'), $newImage, $oldImage);
    }

    $sliders = $request->slider_images;
    if ($sliders) {
      $pis = ServiceImage::findOrFail($sliders);
      foreach ($pis as $key => $pi) {
        $pi->service_id = $request->service_id;
        $pi->save();
      }
    }

    $languages = Language::all();

    $service->update([
      'price' => $request->price,
      'zoom_meeting' => $request->zoom_meeting,
      'vendor_id' => $request->vendor_id,
      'calendar_status' => $request->calender_status,
      'service_image' => $request->hasFile('service_image') ? $serviceImgName : $service->service_image,
      'status' => $request->status,
      'prev_price' => $request->prev_price,
      'max_person' => $request->person,
      'latitude' => $request->latitude,
      'longitude' => $request->longitude,
    ]);


    foreach ($languages as $language) {
      $serviceContent = ServiceContent::where('service_id', $service->id)->where('language_id', $language->id)
        ->first();
      if (empty($serviceContent)) {
        $serviceContent = new ServiceContent();
      }

      if (
        $language->is_default == 1 ||
        $request->filled($language->code . '_name') ||
        $request->filled($language->code . '_description') ||
        $request->filled($language->code . '_category_id')
      ) {
        $serviceContent->language_id = $language->id;
        $serviceContent->service_id = $service->id;
        $serviceContent->category_id = $request[$language->code . '_category_id'];
        $serviceContent->name = $request[$language->code . '_name'];
        $serviceContent->address = $request[$language->code . '_address'];
        $serviceContent->postcode = $request[$language->code . '_postcode'];
        $serviceContent->slug = createSlug($request[$language->code . '_name']);
        $serviceContent->description = Purifier::clean($request[$language->code . '_description']);
        $serviceContent->meta_keyword = $request[$language->code . '_meta_keyword'];
        $serviceContent->features = $request[$language->code . '_features'];
        $serviceContent->meta_description = $request[$language->code . '_meta_description'];
        $serviceContent->save();
        
        if ($request->has('sub_services') && is_array($request->sub_services)) {
    $subServiceIds = [];

    foreach ($request->sub_services as $subService) {
        if (!isset($subService['name'], $subService['price'])) {
            continue; // Skip invalid entries
        }

        $updatedSubService = ServiceContentSub::updateOrCreate(
            ['id' => $subService['id'] ?? null, 'service_content_id' => $serviceContent->id],
            [
                'name' => $subService['name'],
                'price' => $subService['price'],
                'service_content_id' => $serviceContent->id,
            ]
        );
        $subServiceIds[] = $updatedSubService->id;
    }

    // Delete old sub-services that were removed from the request
    ServiceContentSub::where('service_content_id', $serviceContent->id)
        ->whereNotIn('id', $subServiceIds)
        ->delete();
}

        
      }
    }
    Session::flash('success', 'Service updated successfully!');


    return 'success';
  }


    public function subServiceDelete($service_id, $sub_service_id)
      {
    
          ServiceContentSub::where('id', $sub_service_id)->delete();
          return redirect()->route('admin.service_managment.edit', $service_id);
    
      }


  public function destroy($id)
  {
    $service = Services::find($id);
    $hasService = checkService($id);
    if ($hasService > 0) {
      return redirect()->back()->with('warning', 'First reject or delete the appointment for this service!');
    } else {
      /**
       *delete from appointment
       */
      $appointments = ServiceBooking::where('service_id', $id)->get();
      foreach ($appointments as $appointment) {
        @unlink(public_path('assets/file/invoices/service/') . $appointment->invoice);
        @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);
        $appointment->delete();
      }

      ServiceReview::where('service_id', $id)->delete();
      InqueryMessage::where('service_id', $id)->delete();
      ServicePromotion::where('service_id', $id)->delete();
      Wishlist::where('service_id', $id)->delete();

      /**
       * delete featured service
       */
      $featuredServices = ServicePromotion::where('service_id', $id)->get();
      foreach ($featuredServices as $featuredService) {
        // delete the attachment
        @unlink(public_path('assets/file/attachments/service-promotion/') . $featuredService->attachment);
        // delete the invoice
        @unlink(public_path('assets/file/invoices/featured/service/') . $featuredService->invoice);
        $featuredService->delete();
      }

      /**
       * delete staff assign service
       */
      $staffServices = StaffService::where('service_id', $id)->get();

      foreach ($staffServices as $staffService) {
        $staffService->delete();
      }

      /**
       * delete service slider image
       */
      $servicesContents = $service->content()->get();

      // delete the service_image
      @unlink(public_path('assets/img/services/') . $service->service_image);

      $galleries = $service->sliderImage()->get();

      foreach ($galleries as $gallery) {
        @unlink(public_path('assets/img/services/service-gallery/') . $gallery->image);
        $gallery->delete();
      }

      foreach ($servicesContents as $content) {
        $content->delete();
      }

      $service->delete();

      return redirect()->back()->with('success', 'Service deleted successfully!');
    }
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $service = Services::find($id);
      $hasService = checkService($id);
      if ($hasService > 0) {
        $request->session()->flash('warning', 'First reject or delete the appointment for this services!');
        return response()->json(['status' => 'success'], 200);
      } else {
        /**
         *delete from appointment
         */
        $appointments = ServiceBooking::where('service_id', $id)->get();
        foreach ($appointments as $appointment) {
          @unlink(public_path('assets/file/invoices/service/') . $appointment->invoice);
          @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);
          $appointment->delete();
        }

        if ($service) {
          ServiceReview::where('service_id', $id)->delete();
          InqueryMessage::where('service_id', $id)->delete();
          ServicePromotion::where('service_id', $id)->delete();
          Wishlist::where('service_id', $id)->delete();

          /**
           * delete featured service
           */
          $featuredServices = ServicePromotion::where('service_id', $id)->get();
          foreach ($featuredServices as $featuredService) {
            // delete the attachment
            @unlink(public_path('assets/file/attachments/service-promotion/') . $featuredService->attachment);
            // delete the invoice
            @unlink(public_path('assets/file/invoices/featured/service/') . $featuredService->invoice);
            $featuredService->delete();
          }

          /**
           * delete staff assign service
           */
          $staffServices = StaffService::where('service_id', $id)->get();

          foreach ($staffServices as $staffService) {
            $staffService->delete();
          }

          $servicesContent = ServiceContent::where('service_id', $service->id)->get();

          // delete the service_image
          @unlink(public_path('assets/img/services/') . $service->service_image);

          $galleries = $service->sliderImage()->get();

          foreach ($galleries as $gallery) {
            @unlink(public_path('assets/img/services/service-gallery/') . $gallery->image);
            $gallery->delete();
          }

          foreach ($servicesContent as $content) {
            $content->delete();
          }
          $service->delete();
        }
      }
    }

    $request->session()->flash('success', 'Services deleted successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function servicestatus(Request $request)
  {
    $staff = Services::where('id', $request->service_id)->first();

    $staff->update([
      'status' => $request->status,
    ]);
    $request->session()->flash('success', 'Status update successfully!');
    return back();
  }

  //onlineSuccess
  public function onlineSuccess()
  {
    return view('vendors.services.online-success');
  }
  public function offlineSuccess()
  {
    return view('vendors.services.offline-success');
  }
}
