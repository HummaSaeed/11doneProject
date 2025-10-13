<?php

namespace App\Http\Controllers\Admin\HomePage;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Models\Admin\SectionContent;
use App\Models\BasicSettings\Basic;
use App\Models\CustomSection;
use App\Models\HomePage\Section;
use App\Models\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
  public function index()
  {
    $sectionInfo = Section::query()->first();

    $themeVersion = Basic::query()->pluck('theme_version')->first();
    $customSectons = CustomSection::where('page_type', 'home')->get();

    return view('admin.home-page.section-customization', compact('sectionInfo', 'themeVersion', 'customSectons'));
  }

  public function update(Request $request)
  {
    $sectionInfo = Section::query()->first();

    $sectionInfo->update($request->all());

    $request->session()->flash('success', 'Section status updated successfully!');

    return redirect()->back();
  }

  /**
   * home page section content
   */
  public function sectionContent(Request $request)
  {
    $Language = Language::where('code', $request->language)->first();
    $information['langs'] = Language::all();
    $Language_id = $Language->id;


    $information['data'] = SectionContent::where('language_id', $Language_id)->first();
    return view('admin.home-page.section_title', $information);
  }
  /**
   * home page section update
   */
  public function updateContent(Request $request)
  {
    $Language = Language::where('code', $request->language)->first();
    $information['languages'] = Language::all();
    $Language_id = $Language->id;

    $content = SectionContent::where('Language_id', $Language_id)->first();

    $rules = [
      'category_section_title' => 'max:255',
      'latest_service_section_title' => 'max:255',
      'featured_service_section_title' => 'max:255',
      'vendor_section_title' => 'max:255',
      'hero_section_title' => 'max:255',
      'hero_section_subtitle' => 'max:255',
      'workprocess_section_title' => 'max:255',
      'workprocess_section_subtitle' => 'max:255',
      'workprocess_section_btn' => 'max:255',
      'call_to_action_url' => 'max:255',
      'workprocess_section_url' => 'max:255',
      'workprocess_icon' => 'max:255',
      'call_to_action_section_title' => 'max:255',
      'call_to_action_section_btn' => 'max:255',
      'call_to_action_icon' => 'max:255',
      'action_section_text' => 'max:255',
      'testimonial_section_title' => 'max:255',
      'testimonial_section_subtitle' => 'max:255',
      'testimonial_section_clients' => 'max:255',
    ];

    if ($request->hasFile('hero_section_background_img')) {
      $rules['hero_section_background_img'] = new ImageMimeTypeRule();
    }

    if ($request->hasFile('work_process_background_img')) {
      $rules['work_process_background_img'] = new ImageMimeTypeRule();
    }
    if ($request->hasFile('call_to_action_section_image')) {
      $rules['call_to_action_section_image'] = new ImageMimeTypeRule();
    }
    if ($request->hasFile('call_to_action_section_inner_image')) {
      $rules['call_to_action_section_inner_image'] = new ImageMimeTypeRule();
    }
    if ($request->hasFile('testimonial_section_image')) {
      $rules['testimonial_section_image'] = new ImageMimeTypeRule();
    }
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }
    if ($request->hasFile('hero_section_background_img')) {
      $newHeroImage = $request->file('hero_section_background_img');
      if (!empty($content->hero_section_background_img)) {
        $oldHeroImage = $content->hero_section_background_img;
        $heroImageName = UploadFile::update(public_path('assets/img/hero/'), $newHeroImage, $oldHeroImage);
      } else {
        $heroImageName = UploadFile::store(public_path('assets/img/hero/'), $newHeroImage);
      }
    }

    if ($request->hasFile('work_process_background_img')) {
      $newWorkImage = $request->file('work_process_background_img');
      if (!empty($content->work_process_background_img)) {
        $oldWorkImage = $content->work_process_background_img;
        $workImageName = UploadFile::update(public_path('assets/img/'), $newWorkImage, $oldWorkImage);
      } else {
        $workImageName = UploadFile::store(public_path('assets/img/'), $newWorkImage);
      }
    }
    if ($request->hasFile('call_to_action_section_image')) {
      $newCallImage = $request->file('call_to_action_section_image');
      if (!empty($content->call_to_action_section_image)) {
        $oldCallImage = $content->call_to_action_section_image;
        $CallImageName = UploadFile::update(public_path('assets/img/'), $newCallImage, $oldCallImage);
      } else {
        $CallImageName = UploadFile::store(public_path('assets/img/'), $newCallImage);
      }
    }
    if ($request->hasFile('call_to_action_section_inner_image')) {
      $newCallInnerImage = $request->file('call_to_action_section_inner_image');
      if (!empty($content->call_to_action_section_inner_image)) {
        $oldCAllInnerImage = $content->call_to_action_section_inner_image;
        $InnerImageName = UploadFile::update(public_path('assets/img/'), $newCallInnerImage, $oldCAllInnerImage);
      } else {
        $InnerImageName = UploadFile::store(public_path('assets/img/'), $newCallInnerImage);
      }
    }
    if ($request->hasFile('testimonial_section_image')) {
      $newTestImage = $request->file('testimonial_section_image');
      if (!empty($$content->testimonial_section_image)) {
        $oldTestImage = $content->testimonial_section_image;
        $TestImage = UploadFile::update(public_path('assets/img/'), $newTestImage, $oldTestImage);
      } else {
        $TestImage = UploadFile::store(public_path('assets/img/'), $newTestImage);
      }
    }
    if (!empty($content)) {
      $content->Language_id = $Language_id;
      $content->category_section_title = $request->category_section_title;
      $content->latest_service_section_title = $request->latest_service_section_title;
      $content->featured_service_section_title = $request->featured_service_section_title;
      $content->vendor_section_title = $request->vendor_section_title;
      $content->hero_section_background_img = $request->hasFile('hero_section_background_img') ? $heroImageName : $content->hero_section_background_img;
      $content->hero_section_title = $request->hero_section_title;
      $content->hero_section_subtitle = $request->hero_section_subtitle;
      $content->workprocess_section_title = $request->workprocess_section_title;
      $content->workprocess_section_subtitle = $request->workprocess_section_subtitle;
      $content->workprocess_section_btn = $request->workprocess_section_btn;
      $content->call_to_action_url = $request->call_to_action_url;
      $content->workprocess_section_url = $request->workprocess_section_url;
      $content->workprocess_icon = $request->workprocess_icon;
      $content->work_process_background_img = $request->hasFile('work_process_background_img') ? $workImageName : $content->work_process_background_img;
      $content->call_to_action_section_image = $request->hasFile('call_to_action_section_image') ? $CallImageName : $content->call_to_action_section_image;
      $content->call_to_action_section_inner_image = $request->hasFile('call_to_action_section_inner_image') ? $InnerImageName : $content->call_to_action_section_inner_image;
      $content->call_to_action_section_title = $request->call_to_action_section_title;
      $content->call_to_action_section_btn = $request->call_to_action_section_btn;
      $content->call_to_action_icon = $request->call_to_action_icon;
      $content->action_section_text = $request->action_section_text;
      $content->testimonial_section_image = $request->hasFile('testimonial_section_image') ? $TestImage : $content->testimonial_section_image;
      $content->testimonial_section_title = $request->testimonial_section_title;
      $content->testimonial_section_subtitle = $request->testimonial_section_subtitle;
      $content->testimonial_section_clients = $request->testimonial_section_clients;
      $content->save();
    } else {
      $content =  new SectionContent();
      $content->Language_id = $Language_id;
      $content->category_section_title = $request->category_section_title;
      $content->latest_service_section_title = $request->latest_service_section_title;
      $content->featured_service_section_title = $request->featured_service_section_title;
      $content->vendor_section_title = $request->vendor_section_title;
      $content->hero_section_background_img = $request->hasFile('hero_section_background_img') ? $heroImageName : null;
      $content->hero_section_title = $request->hero_section_title;
      $content->hero_section_subtitle = $request->hero_section_subtitle;
      $content->workprocess_section_title = $request->workprocess_section_title;
      $content->workprocess_section_subtitle = $request->workprocess_section_subtitle;
      $content->workprocess_section_btn = $request->workprocess_section_btn;
      $content->call_to_action_url = $request->call_to_action_url;
      $content->workprocess_section_url = $request->workprocess_section_url;
      $content->workprocess_icon = $request->workprocess_icon;
      $content->work_process_background_img = $request->hasFile('work_process_background_img') ? $workImageName : null;
      $content->call_to_action_section_image = $request->hasFile('call_to_action_section_image') ? $CallImageName : null;
      $content->call_to_action_section_inner_image = $request->hasFile('call_to_action_section_inner_image') ? $InnerImageName : null;
      $content->call_to_action_section_title = $request->call_to_action_section_title;
      $content->call_to_action_section_btn = $request->call_to_action_section_btn;
      $content->call_to_action_icon = $request->call_to_action_icon;
      $content->action_section_text = $request->action_section_text;
      $content->testimonial_section_image = $request->hasFile('testimonial_section_image') ? $TestImage : null;
      $content->testimonial_section_title = $request->testimonial_section_title;
      $content->testimonial_section_subtitle = $request->testimonial_section_subtitle;
      $content->testimonial_section_clients = $request->testimonial_section_clients;
      $content->save();
    }
    $request->session()->flash('success', 'Images & Texts section updated successfully!');
    return response()->json(['status' => 'success']);
  }
}
