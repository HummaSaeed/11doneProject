<?php

namespace App\Http\Helpers;

use App\Models\Membership;
use App\Models\Package;
use App\Models\Services\ServiceBooking;
use App\Models\Services\Services;
use App\Models\Vendor;
use Illuminate\Support\Carbon;

class CheckLimitHelper
{
  public static function staffLimit($vendor_id)
  {
    $id = Membership::query()->where([
      ['vendor_id', '=', $vendor_id],
      ['status', '=', 1],
      ['start_date', '<=', Carbon::now()->format('Y-m-d')],
      ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
    ])
      ->pluck('package_id')
      ->first();
    if (isset($id)) {
      $staff = Package::query()->select('staff_limit')->findOrFail($id);
    }
    return isset($id) && isset($staff) ? $staff->staff_limit : 0;
  }
  public static function countImage($vendor_id)
  {
    $ids = [];
    $id = Membership::query()->where([
      ['vendor_id', '=', $vendor_id],
      ['status', '=', 1],
      ['start_date', '<=', Carbon::now()->format('Y-m-d')],
      ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
    ])
      ->pluck('package_id')
      ->first();

    $current_package = null;

    if (isset($id)) {
      $current_package = Package::query()->select('number_of_service_image')->findOrFail($id);
    }

    $countServices = Services::where('vendor_id', $vendor_id)->withCount('sliderImage')->get();

    foreach ($countServices as $service) {
      $serviceId = $service->id;
      $imageCount = $service->sliderImage()->count();
      if ($current_package && $imageCount > $current_package->number_of_service_image) {
        array_push($ids, $serviceId);
      }
    }
    return $ids;
  }


  //count appointment
  public static function countAppointment($vendor_id)
  {
    if ($vendor_id == 0) {
      return 999999;
    } else {
      $membership = Membership::query()->where([
        ['vendor_id', '=', $vendor_id],
        ['status', '=', 1],
        ['start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])->first();

      if (!empty($membership)) {
        $countAppointment = Vendor::where('id', $vendor_id)
          ->select('total_appointment')->first();
        return intval($countAppointment->total_appointment);
      } else {
        return 0;
      }
    }
  }

  //check appointment for vendor
  public static function appointmentLimit(int $vendor_id)
  {
    if ($vendor_id == 0) {
      return 99999;
    } else {
      $id = Membership::query()->where([
        ['vendor_id', '=', $vendor_id],
        ['status', '=', 1],
        ['start_date', '<=', Carbon::now()->format('Y-m-d')],
        ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
      ])
        ->pluck('package_id')
        ->first();
      if (isset($id)) {
        $appointmentLimit = Package::query()->select('number_of_appointment')->findOrFail($id);
      }
      return isset($id) && isset($appointmentLimit) ? $appointmentLimit->number_of_appointment : 0;
    }
  }


  //check service limit
  public static function serviceLimit(int $vendor_id)
  {
    $id = Membership::query()->where([
      ['vendor_id', '=', $vendor_id],
      ['status', '=', 1],
      ['start_date', '<=', Carbon::now()->format('Y-m-d')],
      ['expire_date', '>=', Carbon::now()->format('Y-m-d')]
    ])
      ->pluck('package_id')
      ->first();
    if (isset($id)) {
      $service = Package::query()->select('number_of_service_add')->find($id);
    }
    return isset($id) && isset($service) ? $service->number_of_service_add : 0;
  }
  //count service vendor wise
  public static function countService($vendor_id)
  {
    $countService = Services::where('vendor_id', $vendor_id);
    return $countService ? $countService->count() : 0;
  }

  public static function vendorFeaturesCount($vendor_id)
  {
    $serviceIds = CheckLimitHelper::countImage($vendor_id);
    $imageLimitCount = count($serviceIds);
    $vendor = Vendor::find($vendor_id);

    $vendorFeaturesCount = [];
    $vendorFeaturesCount['services'] = $vendor->service->count();
    $vendorFeaturesCount['staffs'] = $vendor->staff->whereNull('role')->count();
    $vendorFeaturesCount['appointments'] = $vendor->appointment->count();
    $vendorFeaturesCount['images'] = $imageLimitCount;

    return $vendorFeaturesCount;
  }
}
