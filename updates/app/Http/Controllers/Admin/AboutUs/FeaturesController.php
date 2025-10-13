<?php

namespace App\Http\Controllers\Admin\AboutUs;

use App\Http\Controllers\Controller;
use App\Models\Features;
use App\Models\FeaturesSection;
use App\Models\Language;
use Illuminate\Http\Request;
use Response;
use Validator;

class FeaturesController extends Controller
{
  public function storeFeatures(Request $request)
  {
    $rules = [
      'language_id' => 'required',
      'title' => 'required|max:255',
      'serial_number' => 'required|numeric',
      'icon' => 'required',
      'text' => 'required'
    ];

    $message = [
      'language_id.required' => 'The language field is required.'
    ];

    $validator = Validator::make($request->all(), $rules, $message);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    Features::query()->create($request->except('language'));

    $request->session()->flash('success', 'New features added successfully!');

    return Response::json(['status' => 'success'], 200);
  }


  public function updateFeatures(Request $request)
  {
    $rules = [
      'title' => 'required|max:255',
      'text' => 'required',
      'serial_number' => 'required|numeric'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }
    $features = Features::query()->find($request->id);

    $features->update($request->except('language'));

    $request->session()->flash('success', 'Features updated successfully!');

    return Response::json(['status' => 'success'], 200);
  }

  public function destroy($id)
  {
    $Features = Features::query()->find($id);
    $Features->delete();

    return redirect()->back()->with('success', 'Features deleted successfully!');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request['ids'];

    foreach ($ids as $id) {
      $Features = Features::query()->find($id);
      $Features->delete();
    }

    $request->session()->flash('success', 'Features deleted successfully!');

    return Response::json(['status' => 'success'], 200);
  }
}
