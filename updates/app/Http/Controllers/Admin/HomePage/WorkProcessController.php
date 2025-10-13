<?php

namespace App\Http\Controllers\Admin\HomePage;

use App\Http\Controllers\Controller;
use App\Http\Helpers\UploadFile;
use App\Models\BasicSettings\Basic;
use App\Models\HomePage\Methodology\WorkProcess;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Language;
use DB;

class WorkProcessController extends Controller
{
  public function sectionInfo(Request $request)
  {
    $language = Language::query()->where('code', '=', $request->language)->firstOrFail();
    $information['language'] = $language;

    $information['processes'] = $language->workProcess()->orderByDesc('id')->get();

    $information['langs'] = Language::all();

    return view('admin.home-page.work-process-section.index', $information);
  }

  public function storeWorkProcess(Request $request)
  {
    $themeVersion = Basic::query()->value('theme_version');

    $rules = [
      'language_id' => 'required',
      'title' => 'required|max:255',
      'serial_number' => 'required|numeric',
    ];

    if ($themeVersion == 2) {
      $rules['image'] = ['required', new ImageMimeTypeRule()];
    } else {
      $rules = array_merge($rules, [
        'icon' => 'required',
        'text' => 'required',
        'background_color'=>'required'
      ]);
    }

    $messages = [
      'language_id.required' => 'The language field is required.'
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return Response::json(['errors' => $validator->errors()], 400);
    }

    // Handle image upload if theme version is 2
    $data = $request->except('language', 'image');
    if ($themeVersion == 2 && $request->hasFile('image')) {
      $data['image'] = UploadFile::store(public_path('assets/img/workprocess/'), $request->file('image'));
    }
    WorkProcess::create($data);

    $request->session()->flash('success', 'New work process added successfully!');
    return Response::json(['status' => 'success'], 200);
  }


  public function updateWorkProcess(Request $request)
  {
    $themeVersion = Basic::query()->pluck('theme_version')->first();
    if ($themeVersion != 2) {
      $rules = [
        'title' => 'required|max:255',
        'text' => 'required',
        'serial_number' => 'required|numeric',
        'icon' => 'required',
        'background_color' => 'required'
      ];
    } else {
      $rules = [
        'title' => 'required|max:255',
        'serial_number' => 'required|numeric'
      ];
    }

    if ($request->hasFile('image')) {
      $rules['image'] =  new ImageMimeTypeRule();
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }
    $workProcess = WorkProcess::query()->find($request->id);
    if ($request->hasFile('image')) {
      $newImage = $request->file('image');
      $oldImage = $workProcess->image;
      $imgName = UploadFile::update(public_path('assets/img/workprocess/'), $newImage, $oldImage);
    }

    $workProcess->update($request->except('language', 'image') +
      [
        'image' => $request->hasFile('image') ? $imgName : $workProcess->image
      ]);

    $request->session()->flash('success', 'Work process updated successfully!');

    return Response::json(['status' => 'success'], 200);
  }

  public function destroyWorkProcess($id)
  {
    $workProcess = WorkProcess::query()->find($id);
    @unlink(public_path('assets/img/workprocess/') . $workProcess->image);
    $workProcess->delete();

    return redirect()->back()->with('success', 'Work process deleted successfully!');
  }

  public function bulkDestroyWorkProcess(Request $request)
  {
    $ids = $request['ids'];

    foreach ($ids as $id) {
      $workProcess = WorkProcess::query()->find($id);
      @unlink(public_path('assets/img/workprocess/') . $workProcess->image);
      $workProcess->delete();
    }

    $request->session()->flash('success', 'Work processes deleted successfully!');

    return Response::json(['status' => 'success'], 200);
  }
}
