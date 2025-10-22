<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StoreRequest;
use App\Http\Requests\Page\UpdateRequest;
use App\Models\BasicSettings\PageHeading;
use App\Models\BasicSettings\SEO;
use App\Models\CustomPage\Page;
use App\Models\CustomPage\PageContent;
use App\Models\Language;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class CustomPageController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // first, get the language info from db
    $language = Language::query()->where('code', '=', $request->language)->firstOrFail();
    $information['language'] = $language;

    // then, get the custom pages of that language from db
    $information['pages'] = Page::query()->join('page_contents', 'pages.id', '=', 'page_contents.page_id')
      ->where('page_contents.language_id', '=', $language->id)
      ->orderByDesc('pages.id')
      ->get();

    // also, get all the languages from db
    $information['langs'] = Language::all();

    return view('admin.custom-page.index', $information);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // get all the languages from db
    $information['languages'] = Language::all();

    return view('admin.custom-page.create', $information);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreRequest $request)
  {
    $page = new Page();

    $page->status = $request->status;
    $page->save();

    $languages = Language::all();

    foreach ($languages as $language) {
      $code = $language->code;
      if (
        $language->is_default == 1 ||
        $request->filled($code . '_title') ||
        $request->filled($code . '_content')
      ) {
        $pageContent = new PageContent();
        $pageContent->language_id = $language->id;
        $pageContent->page_id = $page->id;
        $pageContent->title = $request[$code . '_title'];
        $pageContent->slug = createSlug($request[$code . '_title']);
        $pageContent->content = Purifier::clean($request[$code . '_content'], 'youtube');
        $pageContent->save();
      }
    }

    $request->session()->flash('success', 'New page added successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $information['page'] = Page::query()->findOrFail($id);

    // get all the languages from db
    $information['languages'] = Language::all();

    return view('admin.custom-page.edit', $information);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateRequest $request, $id)
  {
    $page = Page::query()->findOrFail($id);

    $page->update([
      'status' => $request->status
    ]);

    $languages = Language::all();
    foreach ($languages as $language) {
      $code = $language->code;

      $pageContent = PageContent::query()->where('page_id', $id)
        ->where('language_id', $language->id)
        ->first();

      if (empty($pageContent)) {
        $pageContent = new PageContent();
      }

      if (
        $language->is_default == 1 ||
        $request->filled($code . '_title') ||
        $request->filled($code . '_content')
      ) {
        $pageContent->language_id = $language->id;
        $pageContent->page_id = $page->id;
        $pageContent->title = $request[$language->code . '_title'];
        $pageContent->slug = createSlug($request[$language->code . '_title']);
        $pageContent->content = Purifier::clean($request[$language->code . '_content'], 'youtube');
        $pageContent->save();
      }
    }

    $request->session()->flash('success', 'Page updated successfully!');

    return response()->json(['status' => 'success'], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $page = Page::query()->findOrFail($id);

    //delete page heading info
    $headings = PageHeading::query()->get();
    foreach ($headings as $heading) {
      $customPageHeadings = json_decode($heading->custom_page_heading, true);
      if (isset($customPageHeadings[$page->id])) {
        unset($customPageHeadings[$page->id]);
        $heading->custom_page_heading = json_encode($customPageHeadings);
        $heading->save();
      };
    }

    //delete seo info
    $seos = SEO::query()->get();
    foreach ($seos as $seo) {
      $keywords = json_decode($seo->custome_page_meta_keyword, true);
      $descriptions = json_decode($seo->custome_page_meta_description, true);
      if (isset($keywords[$page->id])) {
        unset($keywords[$page->id]);
        $seo->custome_page_meta_keyword = json_encode($keywords);
        $seo->save();
      };
      if (isset($descriptions[$page->id])) {
        unset($descriptions[$page->id]);
        $seo->custome_page_meta_description = json_encode($descriptions);
        $seo->save();
      };
    }

    $pageContents = $page->content()->get();

    foreach ($pageContents as $pageContent) {
      $pageContent->delete();
    }

    $page->delete();

    return redirect()->back()->with('success', 'Page deleted successfully!');
  }

  /**
   * Remove the selected or all resources from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $page = Page::query()->findOrFail($id);

      $pageContents = $page->content()->get();

      foreach ($pageContents as $pageContent) {
        $pageContent->delete();
      }

      $page->delete();
    }

    $request->session()->flash('success', 'Pages deleted successfully!');

    return response()->json(['status' => 'success'], 200);
  }
}
