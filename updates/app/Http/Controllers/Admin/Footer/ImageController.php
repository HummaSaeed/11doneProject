<?php

namespace App\Http\Controllers\Admin\Footer;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
  public function index()
  {
    $data = DB::table('basic_settings')->select('footer_logo', 'footer_background_image')->first();

    return view('admin.footer.logo', ['data' => $data]);
  }

  public function updateLogo(Request $request)
  {
    $data = DB::table('basic_settings')->select('footer_logo')->first();

    $rules = [];

    if (!$request->filled('footer_logo') && is_null($data->footer_logo)) {
      $rules['footer_logo'] = 'required';
    }
    if ($request->hasFile('footer_logo')) {
      $rules['footer_logo'] = new ImageMimeTypeRule();
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors());
    }

    if ($request->hasFile('footer_logo')) {
      $newLogo = $request->file('footer_logo');
      $oldLogo = $data->footer_logo;
      $logoName = UploadFile::update(public_path('assets/admin/img/footer/'), $newLogo, $oldLogo);

      // finally, store the footer-logo into db
      DB::table('basic_settings')->updateOrInsert(
        ['uniqid' => 12345],
        ['footer_logo' => $logoName]
      );

      $request->session()->flash('success', 'Footer logo updated successfully!');
    }

    return redirect()->back();
  }
}
