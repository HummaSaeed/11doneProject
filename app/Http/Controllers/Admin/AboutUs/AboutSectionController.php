<?php

namespace App\Http\Controllers\Admin\AboutUs;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Models\BasicSettings\AboutUs;
use App\Models\CustomSection;
use App\Models\HomePage\Section;
use App\Models\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutSectionController extends Controller
{
  public function about_us(Request $request)
  {
    $language = Language::query()->where('code', '=', $request->language)->firstOrFail();
    $information['language'] = $language;
    $information['langs'] = Language::all();
    $information['data'] = AboutUs::query()->where('language_id', $language->id)->first();
    $information['features'] = $language->features()->orderByDesc('id')->get();

    return view('admin.about-us.about-us', $information);
  }

  public function update_about_us(Request $request)
  {
    $rules = [
      'title' => 'max:255',
      'subtitle' => 'max:255',
    ];
    if ($request->hasFile('about_section_image')) {
      $rules['about_section_image'] = new ImageMimeTypeRule();
    }
    if ($request->button_text != null) {
      $rules['button_url'] = 'required:max:255';
    }
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $language = Language::where('code', $request->language)->firstOrFail();
    $aboutUs = AboutUs::where('language_id', $language->id)->first();

    if ($request->hasFile('about_section_image')) {
      $newImage = $request->file('about_section_image');
      if (!empty($aboutUs->about_section_image)) {
        $oldImage = $aboutUs->about_section_image;
        $imageName = UploadFile::update(public_path('assets/img/about-us/'), $newImage, $oldImage);
      } else {
        $imageName = UploadFile::store(public_path('assets/img/about-us/'), $newImage);
      }
    }

    if (!empty($aboutUs)) {
      $aboutUs->update($request->except('language_id', 'about_section_image') + [
        'language_id' => $language->id,
        'about_section_image' => isset($imageName) ? $imageName : $aboutUs->about_section_image,
      ]);
    } else {
      AboutUs::create($request->except('language_id', 'about_section_image') + [
        'language_id' => $language->id,
        'about_section_image' => $imageName ?? null,
      ]);
    }

    $request->session()->flash('success', 'About us section updated successfully!');

    return redirect()->back();
  }

  public function customizeSection()
  {
    $aboutSec = Section::select('about_work_status', 'about_testimonial_section_status', 'features_section_status', 'about_section_status', 'about_custom_section_status')->first();
    $customSectons = CustomSection::where('page_type', 'about')->get();
    return view('admin.about-us.section-customization', compact('aboutSec', 'customSectons'));
  }

  public function customizeUpdate(Request $request)
  {
    $section =  Section::first();
    $section->about_work_status = $request->about_work_status;
    $section->about_testimonial_section_status = $request->about_testimonial_section_status;
    $section->features_section_status = $request->features_section_status;
    $section->about_section_status = $request->about_section_status;
    $section->about_custom_section_status = $request->about_custom_section_status;
    $section->save();

    return redirect()->back()->with('success', 'Section update successfully!');
  }
}
