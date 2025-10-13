<?php

namespace App\Http\Middleware;

use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Staff\Staff;
use App\Models\Vendor;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;

class StaffPermission
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    $staffId = Auth::guard('staff')->user()->id;
    $vendor = Staff::where('id', $staffId)->select('vendor_id', 'status')->firstOrFail();
    if ($vendor->vendor_id != 0) {
      $status = Vendor::where('id', $vendor->vendor_id)->pluck('status')->firstOrFail();
      $packagePermission = VendorPermissionHelper::packagePermission($vendor->vendor_id);

      if ($packagePermission != '[]' && $status == 1 && $vendor->status == 1) {
        return $next($request);
      } else {
        Session::flash('error', 'Something went wrong. Please contact with your vendor.');
        return redirect()->route('staff.login');
      }
    } else {
      return $next($request);
    }
  }
}
