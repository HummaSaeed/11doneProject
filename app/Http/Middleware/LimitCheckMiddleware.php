<?php

namespace App\Http\Middleware;

use App\Http\Helpers\CheckLimitHelper;
use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Staff\Staff;
use App\Models\Vendor;
use Auth;
use Closure;
use Illuminate\Http\Request;

class LimitCheckMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, $feature = null, $method = null, $type = null)
  {

    if (Auth::guard('vendor')->check()) {
      $vendor_id = Auth::guard('vendor')->user()->id;
    } elseif (Auth::guard('staff')->check()) {
      $staffId = Auth::guard('staff')->user()->id;
      $staff = Staff::select('vendor_id')->findOrFail($staffId);
      $vendor_id = $staff->vendor_id;
    }

    if ($vendor_id != 0) {

      $package = VendorPermissionHelper::currentPackagePermission($vendor_id);

      $vendor = Vendor::find($vendor_id);

      if ($type == "downgrade" && empty($package)) {
        return redirect()->back()->with('warning', 'Please buy a package to use this panel!');
      }
      if (empty($package)) {
        return response()->json('empty_package');
      }

      $vendorFeaturesCount = CheckLimitHelper::vendorFeaturesCount($vendor->id);

      if ($method == 'store') {
        //services
        if ($feature == 'service') {
          if ($package->number_of_service_add > $vendorFeaturesCount['services'] && $this->checkFeaturesNotDowngraded($feature, $package, $vendorFeaturesCount)) {
            return $next($request);
          } else {
            if ($type == 'downgrade') {
              session()->put('modal-show', true);
              return redirect()->back()->with('warning', 'Limit is reached of exceeded!');
            } elseif ($type == 'staff_downgrade') {
              return redirect()->back()->with('warning', 'Something went wrong. Please contact with your owner!');
            } elseif ($type == 'staff_downgrade_js') {
              return response()->json('staff_downgrad_js');
            } else {
              return response()->json('downgrade');
            }
          }
        }

        //staffs
        if ($feature == 'staff') {
          if ($package->staff_limit > $vendorFeaturesCount['staffs'] && $this->checkFeaturesNotDowngraded($feature, $package, $vendorFeaturesCount)) {
            return $next($request);
          } else {
            if ($type == 'downgrade') {
              session()->put('modal-show', true);
              return redirect()->back()->with('warning', 'Limit is reached of exceeded!');
            } elseif ($type == 'staff_downgrade') {
              return redirect()->back()->with('warning', 'Something went wrong. Please contact with your owner!');
            } else {
              return response()->json('downgrade');
            }
          }
        }
      }

      if ($method == 'update') {
        //service
        if ($feature == 'service') {
          if ($package->number_of_service_add >= $vendorFeaturesCount['services'] && $this->checkFeaturesNotDowngraded($feature, $package, $vendorFeaturesCount)) {
            return $next($request);
          } else {
            if ($type == 'downgrade') {
              session()->put('modal-show', true);
              return redirect()->back()->with('warning', 'Limit is reached of exceeded!');
            } elseif ($type == 'staff_downgrade') {
              return redirect()->back()->with('warning', 'Something went wrong. Please contact with your owner!');
            } elseif ($type == 'staff_downgrade_js') {
              return response()->json('staff_downgrad_js');
            } else {
              return response()->json('downgrade');
            }
          }
        }

        //staff
        if ($feature == 'staff') {
          if ($package->staff_limit >= $vendorFeaturesCount['staffs'] && $this->checkFeaturesNotDowngraded($feature, $package, $vendorFeaturesCount)) {
            return $next($request);
          } else {
            if ($type == 'downgrade') {
              session()->put('modal-show', true);
              return redirect()->back()->with('warning', 'Limit is reached of exceeded!');
            } elseif ($type == 'staff_downgrade') {
              return redirect()->back()->with('warning', 'Something went wrong. Please contact with your owner!');
            } else {
              return response()->json('downgrade');
            }
          }
        }
      }
    } else {
      return $next($request);
    }
  }

  private function checkFeaturesNotDowngraded($feature, $package, $vendorFeaturesCount)
  {
    $response = true;

    if ($feature != 'service') {
      if ($package->number_of_service_add < $vendorFeaturesCount['services']) {
        return  $response = false;
      }
    }

    if ($feature != 'image') {
      if ($vendorFeaturesCount['images'] > 0) {
        return  $response = false;
      }
    }

    if ($feature != 'staff') {
      if ($package->staff_limit < $vendorFeaturesCount['staffs']) {
        return  $response = false;
      }
    }

    return $response;
  }
}
