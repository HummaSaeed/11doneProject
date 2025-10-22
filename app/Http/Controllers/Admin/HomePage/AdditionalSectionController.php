<?php

namespace App\Http\Controllers\Admin\HomePage;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings\Basic;
use App\Http\Requests\AddtionalSectionStore;
use App\Http\Requests\AddtionalSectionUpdate;
use App\Models\CustomSection;
use App\Models\HomePage\Section;
use App\Models\CustomSectionContent;
use App\Models\Language;
use Illuminate\Http\Request;
use Purifier;

class AdditionalSectionController extends Controller
{
  public function index(Request $request)
  {
    $lang = Language::where('code', $request->language)->first();
    $information['langs'] = Language::all();

    $information['sections'] = CustomSection::join('custom_section_contents', 'custom_section_contents.custom_section_id', '=', 'custom_sections.id')
      ->where('language_id', $lang->id)
      ->where('page_type', 'home')
      ->select('custom_sections.*', 'custom_section_contents.section_name')
      ->get();

    return view('admin.home-page.custom-section.index', $information);
  }

  public function create(Request $request)
  {
    $information['themeVersion'] = Basic::query()->pluck('theme_version')->first();
    $information['languages'] = Language::all();
    return view('admin.home-page.custom-section.create', $information);
  }

  public function store(AddtionalSectionStore $request)
  {
    $languages = Language::all();
    $section = new CustomSection();
    $section->order = $request->order;
    $section->page_type = $request->page_type;
    $section->serial_number = $request->serial_number;
    $section->save();


    foreach ($languages as $language) {
      $code = $language->code;
      if (
        $language->is_default == 1 ||
        $request->filled($code . '_name') ||
        $request->filled($code . '_content')
      ) {
        $content = new CustomSectionContent();
        $content->language_id = $language->id;
        $content->custom_section_id = $section->id;
        $content->section_name = $request[$code . '_name'];
        $content->content = Purifier::clean($request[$code . '_content'], 'youtube');
        $content->save();
      }
    }

    $sectionInfo = Section::query()->first();
    $arr = json_decode($sectionInfo->custom_section_status, true);
    $arr["$section->id"] = "1";
    $sectionInfo->update([
      "custom_section_status" => json_encode($arr)
    ]);


    $request->session()->flash('success', 'New section create successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function edit($id, Request $request)
  {
    $information['languages'] = Language::all();
    $information['themeVersion'] = Basic::query()->pluck('theme_version')->first();
    $information['section'] = CustomSection::where('page_type', 'home')->where('id', $id)->firstOrFail();
    return view('admin.home-page.custom-section.edit', $information);
  }

  public function update($id, AddtionalSectionUpdate $request)
  {
    $section = CustomSection::findOrFail($id);
    $section->order = $request->order;
    $section->page_type = $request->page_type;
    $section->serial_number = $request->serial_number;
    $section->save();

    $languages = Language::all();

    foreach ($languages as $language) {
      $content = CustomSectionContent::where('custom_section_id', $id)->where('language_id', $language->id)->first();
      if (empty($content)) {
        $content = new CustomSectionContent();
      }
      $code = $language->code;
      if (
        $language->is_default == 1 ||
        $request->filled($code . '_name') ||
        $request->filled($code . '_content')
      ) {
        // Retrieve the content for the given section and language, or create a new one if it doesn't exist
        $content = CustomSectionContent::firstOrNew([
          'custom_section_id' => $section->id,
          'language_id' => $language->id
        ]);
        $content->section_name = $request[$code . '_name'];
        $content->content = Purifier::clean($request[$code . '_content'], 'youtube');
        $content->save();
      }
    }

    $request->session()->flash('success', 'Section updated successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  public function delete($id)
  {
    $section = CustomSection::findOrFail($id);
    $contents = CustomSectionContent::where('custom_section_id', $id)->get();
    foreach ($contents as $content) {
      $content->delete();
    }
    $section->delete();
    return redirect()->back()->with('success', 'Section delete successfully!');
  }

  public function bulkdelete(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $page = CustomSection::query()->findOrFail($id);

      $contents = CustomSectionContent::where('custom_section_id', $id)->get();

      foreach ($contents as $pageContent) {
        $pageContent->delete();
      }

      $page->delete();
    }

    $request->session()->flash('success', 'Sections deleted successfully!');

    return response()->json(['status' => 'success'], 200);
  }
}
