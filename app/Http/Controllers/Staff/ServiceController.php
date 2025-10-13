<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Http\Helpers\VendorPermissionHelper;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\FeaturedService\ServicePromotion;
use App\Models\Language;
use App\Models\Services\InqueryMessage;
use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceContent;
use App\Models\Services\ServiceImage;
use App\Models\Services\ServiceReview;
use App\Models\Services\Services;
use App\Models\Services\Wishlist;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Purifier;
use Session;
use Validator;

class ServiceController extends Controller
{
  public function index(Request $request)
  {
    $language = Language::where('code', $request->language)->firstOrFail();
    $information['language_id'] = $language->id;

    $information['langs'] = Language::all();

    //staff
    $staffId = Auth::guard('staff')->user()->id;
    $vendorId = Staff::pluck('vendor_id')->where('id', $staffId)->first();

    $package = null;
    if ($vendorId != 0) {
      $package = VendorPermissionHelper::packagePermission($vendorId);
    }
    $information['package'] = $package;

    //check package
    if ($package != null && $package != []) {
      if (vendorTotalAddedService($vendorId) > $package->number_of_service_add) {
        $information['service_add'] = 'over';
      } else {
        $information['service_add'] = '';
      }
    } else {
      $information['service_add'] = 0;
    }

    //staff service
    $information['staffServices'] = StaffService::where('staff_id', $staffId)->select('service_id')->get();
    $information['currencyInfo'] = $this->getCurrencyInfo();
    return view('staffs.services.index', $information);
  }

  public function create()
  {
    //staff
    $staffId = Auth::guard('staff')->user()->id;
    $staff = Staff::findOrFail($staffId);
    if ($staff->service_add == 0) {
      return redirect()->route('staff.service_managment')->with('warning', 'You do not have permission!');
    }
    $information['staff'] = $staff;

    $information['languages'] = Language::all();
    $information['currencyInfo'] = $this->getCurrencyInfo();

    return view('staffs.services.create', $information);
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
    DB::transaction(function () use ($request) {
      // store featured image in storage
      $service_image = UploadFile::store(public_path('assets/img/services/'), $request->file('service_image'));


      $languages = Language::all();

      $service = Services::create([
        'price' => $request->price,
        'zoom_meeting' => $request->zoom_meeting,
        'calendar_status' => $request->calender_status,
        'service_image' => $service_image,
        'vendor_id' => $request->vendor_id,
        'status' => $request->status,
        'staff_id' => $request->staff_id,
        'prev_price' => $request->prev_price,
        'max_person' => $request->person,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
      ]);

      //staff service assign
      StaffService::create([
        'vendor_id' => $service->vendor_id,
        'service_id' => $service->id,
        'staff_id' => $service->staff_id,
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
          $service_content = new ServiceContent();
          $service_content->service_id  = $service->id;
          $service_content->language_id = $language->id;
          $service_content->category_id = $request[$code . '_category_id'];
          $service_content->name = $request[$code . '_name'];
          $service_content->address = $request[$code . '_address'];
          $service_content->slug = createSlug($request[$code . '_name']);
          $service_content->description = Purifier::clean($request[$code . '_description']);
          $service_content->meta_keyword = $request[$code . '_meta_keyword'];
          $service_content->meta_description = $request[$code . '_meta_description'];
          $service_content->features = $request[$code . '_features'];
          $service_content->save();
        }
      }
    });

    Session::flash('success', 'New service added successfully!');
    return 'success';
  }


  public function edit($id)
  {
    //staff
    $staffId = Auth::guard('staff')->user()->id;
    $staff = Staff::select('vendor_id', 'service_edit')->where('id', $staffId)->first();
    if ($staff->service_edit == 0) {
      return redirect()->route('staff.service_managment')->with('warning', 'You do not have permission!');
    }

    $vendorId = $staff->vendor_id;
    $information['vendorId'] = $vendorId;
    $serviceImage = vendorTotalSliderImage($id);

    $package = null;
    if ($vendorId != 0) {
      $package = VendorPermissionHelper::packagePermission($vendorId);

      if ($package != []) {
        $pack_image = $package->number_of_service_image;
        $information['sliderImage'] = $pack_image - $serviceImage;

        if (vendorTotalAddedService($vendorId) > $package->number_of_service_add) {
          $information['can_service_add'] = 'downgrad';
        } else {
          $information['can_service_add'] = 1;
        }
      } else {
        $information['sliderImage'] = 0;
      }
    } else {
      $information['sliderImage'] = 999999 - $serviceImage;
      $information['can_service_add'] = 999999;
    }

    $information['service'] = Services::with('sliderImage')
      ->where('vendor_id', $vendorId)
      ->where('staff_id', $staffId)
      ->findOrFail($id);

    $information['languages'] = Language::all();
    $information['currencyInfo'] = $this->getCurrencyInfo();
    $information['package'] = $package;



    return view('staffs.services.edit', $information);
  }

  public function update($id, ServiceUpdateRequest $request)
  {
    $service = Services::findOrFail($id);

    if ($request->vendor_id != 0) {
      $current_package = VendorPermissionHelper::packagePermission($request->vendor_id);

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
      'calendar_status' => $request->calender_status,
      'vendor_id' => $request->vendor_id,
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
        $serviceContent->slug = createSlug($request[$language->code . '_name']);
        $serviceContent->description = Purifier::clean($request[$language->code . '_description']);
        $serviceContent->meta_keyword = $request[$language->code . '_meta_keyword'];
        $serviceContent->meta_description = $request[$language->code . '_meta_description'];
        $serviceContent->features = $request[$language->code . '_features'];
        $serviceContent->save();
      }
    }
    Session::flash('success', 'Service updated successfully!');
    return 'success';
  }

  public function servicestatus(Request $request)
  {
    //staff
    $staffId = Auth::guard('staff')->user()->id;
    $staff = Staff::findOrFail($staffId);
    $information['staff'] = $staff;

    $current_package = VendorPermissionHelper::packagePermission($staff->vendor_id);

    if ($current_package == '[]') {
      session::flash('warning', 'Please buy a package to use this panel!');
      return redirect()->back();
    } else {
      $staff = Services::where('id', $request->service_id)->first();

      $staff->update([
        'status' => $request->status,
      ]);
      $request->session()->flash('success', 'Status update successfully!');
      return back();
    }
  }

  public function destroy($id)
  {
    $staffId = Auth::guard('staff')->user()->id;
    $staff = Staff::findOrFail($staffId);
    $information['staff'] = $staff;

    $service = Services::findOrFail($id);
    $hasService = checkService($id);

    if ($hasService > 0) {
      return redirect()->back()->with('warning', 'First reject or delete the appointment for this service!');
    } else {
      ServiceReview::where('service_id', $id)->delete();
      InqueryMessage::where('service_id', $id)->delete();
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

      $appointments = ServiceBooking::where('service_id', $id)->get();

      foreach ($appointments as $appointment) {
        @unlink(public_path('assets/file/invoices/service/') . $appointment->invoice);
        @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);
        $appointment->delete();
      }

      /**
       * delete staff assign service
       */
      $staffServices = StaffService::where('service_id', $id)->get();

      foreach ($staffServices as $staffService) {
        $staffService->delete();
      }
      $servicesContents = $service->content()->get();

      // delete the service_image
      @unlink(public_path('assets/img/services/') . $service->service_image);

      foreach ($servicesContents as $content) {
        $content->delete();
      }
      if ($staff->service_delete == 0) {
        return redirect()->route('staff.service_managment')->with('warning', 'You do not have permission!');
      } else {
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted successfully!');
      }
    }
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $service = Services::findOrFail($id);
      $hasService = checkService($id);
      if ($hasService > 0) {
        $request->session()->flash('warning', 'First reject or delete the appointment for this services!');
        return response()->json(['status' => 'success'], 200);
      } else {
        if ($service) {
          ServiceReview::where('service_id', $id)->delete();
          InqueryMessage::where('service_id', $id)->delete();
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

          $appointments = ServiceBooking::where('service_id', $id)->get();

          foreach ($appointments as $appointment) {
            @unlink(public_path('assets/file/invoices/service/') . $appointment->invoice);
            @unlink(public_path('assets/file/attachments/service/') . $appointment->attachment);
            $appointment->delete();
          }

          /**
           * delete staff assign service
           */
          $staffServices = StaffService::where('service_id', $id)->get();

          foreach ($staffServices as $staffService) {
            $staffService->delete();
          }

          $servicesContent = ServiceContent::where('service_id', $service->id)->get();

          foreach ($servicesContent as $content) {
            $content->delete();
          }

          $galleries = $service->sliderImage()->get();

          foreach ($galleries as $gallery) {
            @unlink(public_path('assets/img/services/service-gallery/') . $gallery->image);
            $gallery->delete();
          }

          @unlink(public_path('assets/img/services/') . $service->service_image);
          $service->delete();
        }
      }
    }

    $request->session()->flash('success', 'Services deleted successfully!');
    return response()->json(['status' => 'success'], 200);
  }
}
