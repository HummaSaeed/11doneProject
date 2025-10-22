<?php

namespace App\Http\Controllers\Admin\HomePage;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Http\Requests\Testimonial\StoreRequest;
use App\Http\Requests\Testimonial\UpdateRequest;
use App\Models\Admin\SectionContent;
use App\Models\HomePage\Testimony\Testimonial;
use App\Models\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
  public function index(Request $request)
  {
    $language = Language::query()->where('code', '=', $request->language)->firstOrFail();
    $information['language'] = $language;

    $information['testimonials'] = $language->testimonial()->orderByDesc('id')->get();
    $information['testSection'] = SectionContent::where('language_id', $language->id)->select('testimonial_section_image', 'testimonial_section_title', 'testimonial_section_subtitle', 'testimonial_section_clients')->first();
    $information['langs'] = Language::all();

    return view('admin.home-page.testimonial-section.index', $information);
  }

  public function storeTestimonial(StoreRequest $request)
  {
    // store image in storage
    $imgName = UploadFile::store(public_path('assets/img/clients/'), $request->file('image'));
    Testimonial::query()->create($request->except('language', 'image') + [
      'image' => $request->hasFile('image') ? $imgName : NULL
    ]);

    $request->session()->flash('success', 'New testimonial added successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function updateTestimonial(UpdateRequest $request)
  {
    $testimonial = Testimonial::query()->find($request->id);

    if ($request->hasFile('image')) {
      $newImage = $request->file('image');
      $oldImage = $testimonial->image;
      $imgName = UploadFile::update(public_path('assets/img/clients/'), $newImage, $oldImage);
      @unlink(public_path('assets/img/clients/') . $oldImage);
    }

    $testimonial->update($request->except('language', 'image') + [
      'image' => $request->hasFile('image') ? $imgName : $testimonial->image
    ]);

    $request->session()->flash('success', 'Testimonial updated successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function destroyTestimonial($id)
  {
    $testimonial = Testimonial::query()->find($id);

    @unlink(public_path('assets/img/clients/') . $testimonial->image);

    $testimonial->delete();

    return redirect()->back()->with('success', 'Testimonial deleted successfully!');
  }

  public function bulkDestroyTestimonial(Request $request)
  {
    $ids = $request['ids'];

    foreach ($ids as $id) {
      $testimonial = Testimonial::query()->find($id);

      @unlink(public_path('assets/img/clients/') . $testimonial->image);

      $testimonial->delete();
    }

    $request->session()->flash('success', 'Testimonials deleted successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function updateSection(Request $request)
  {
    $Language = Language::where('code', $request->language)->first();
    $Language_id = $Language->id;
    $rules = [];
    if ($request->hasFile('testimonial_section_image')) {
      $rules['testimonial_section_image'] = new ImageMimeTypeRule();
    }
    $request->validate($rules);
    if ($request->hasFile('testimonial_section_image')) {
      $newTestImage = $request->file('testimonial_section_image');
      if (!empty($$content->testimonial_section_image)) {
        $oldTestImage = $content->testimonial_section_image;
        $TestImage = UploadFile::update(public_path('assets/img/'), $newTestImage, $oldTestImage);
      } else {
        $TestImage = UploadFile::store(public_path('assets/img/'), $newTestImage);
      }
    }

    $content = SectionContent::where('Language_id', $Language_id)->first();
    if (!empty($content)) {
      $content->Language_id = $Language_id;
      $content->testimonial_section_image = $request->hasFile('testimonial_section_image') ? $TestImage : $content->testimonial_section_image;
      $content->testimonial_section_title = $request->testimonial_section_title;
      $content->testimonial_section_subtitle = $request->testimonial_section_subtitle;
      $content->testimonial_section_clients = $request->testimonial_section_clients;
      $content->save();
    } else {
      $content = new SectionContent();
      $content->Language_id = $Language_id;
      $content->testimonial_section_image = $request->hasFile('testimonial_section_image') ? $TestImage : $content->testimonial_section_image;
      $content->testimonial_section_title = $request->testimonial_section_title;
      $content->testimonial_section_subtitle = $request->testimonial_section_subtitle;
      $content->testimonial_section_clients = $request->testimonial_section_clients;
      $content->save();
    }

    return redirect()->back()->with('success', 'Testimonial section update successfully!');
  }
}
