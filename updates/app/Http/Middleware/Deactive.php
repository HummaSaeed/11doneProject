<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Deactive
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $setting = DB::table('basic_settings')->where('uniqid', 12345)->select('vendor_email_verification', 'vendor_admin_approval', 'admin_approval_notice')->first();

    if (Auth::guard('vendor')->user()->status == 0) {
      if ($request->isMethod('POST') || $request->isMethod('PUT')) {
        session()->flash('warning', $setting->admin_approval_notice);
        return redirect()->back();
      }
    }
    if (Auth::guard('vendor')->user()->email_verified_at == null && $setting->vendor_email_verification == 1) {
      return redirect()->route('vendor.login');
    }
    return $next($request);
  }
}
