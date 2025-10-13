<?php

namespace App\Http\Middleware;

use App\Http\Helpers\VendorPermissionHelper;
use Auth;
use Closure;
use Illuminate\Http\Request;

class CheckPackage
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
    if (Auth::guard('vendor')->check()) {
      $user = Auth::user();
      $package = VendorPermissionHelper::currentPackagePermission(Auth::guard('vendor')->user()->id);

      if (empty($package)) {
        session()->flash('warning', 'Please buy a package to use this panel!');
        return redirect()->back();
      }
    }
    return $next($request);
  }
}
