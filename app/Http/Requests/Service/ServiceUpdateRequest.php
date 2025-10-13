<?php

namespace App\Http\Requests\Service;

use App\Http\Helpers\VendorPermissionHelper;
use App\Models\Language;
use App\Models\Services\ServiceImage;
use App\Models\VendorPlugins\VendorPlugin;
use App\Rules\ImageMimeTypeRule;
use DB;
use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    $vendorId = $this->vendor_id;

    $ruleArray = [
      'slider_images' => 'sometimes|array|max:' . $this->getSliderImageCount(),
      'service_image' => $this->hasFile('service_image') ? new ImageMimeTypeRule() : '',
      'status' => 'required',
      'price' => 'required|numeric',
      'latitude' => [
        'sometimes',
        'numeric',
        'between:-90,90',
        'nullable'
      ],
      'longitude' => [
        'sometimes',
        'numeric',
        'between:-180,180',
        'nullable'
      ],
    ];

    if ($vendorId != 0) {
      $plugin = VendorPlugin::where('vendor_id', $vendorId)->first();
    } else {
      $plugin = DB::table('basic_settings')->select('zoom_account_id', 'zoom_client_id', 'zoom_client_secret', 'google_calendar', 'calender_id')->first();
    }

    if ($this->zoom_meeting == 1 && ($plugin == null || $plugin->zoom_account_id == "" || $plugin->zoom_client_id == "" || $plugin->zoom_client_secret == "")) {
      $ruleArray['zoom'] = 'required';
    }

    if ($this->calender_status == 1 && ($plugin == null || $plugin->google_calendar == "" || $plugin->calender_id == "")) {
      $ruleArray['calender'] = 'required';
    }

    if ($this->person_type == 0) {
      $ruleArray['person'] = 'required';
    }

    $defaultLanguage = Language::where('is_default', 1)->first();
    // Default language fields should always be required
    $ruleArray[$defaultLanguage->code . '_name'] = 'required|max:255';
    $ruleArray[$defaultLanguage->code . '_description'] = 'required|min:15';
    $ruleArray[$defaultLanguage->code . '_category_id'] = 'required';


    $languages = Language::all();
    foreach ($languages as $language) {
      $code = $language->code;

      // Skip the default language as it's always required
      if ($language->id == $defaultLanguage->id) {
        continue;
      }

      // Check if any field for this language is filled
      if (
        $this->filled($code . '_name') ||
        $this->filled($code . '_description') ||
        $this->filled($code . '_address') ||
        $this->filled($code . '_features') ||
        $this->filled($code . '_meta_keyword') ||
        $this->filled($code . '_meta_description') ||
        $this->filled($code . '_category_id')
      ) {
        // If any field is filled, make all fields required for both the language and default language
        $ruleArray["$code" . '_name'] = 'required|max:255';
        $ruleArray["$code" . '_description'] = 'required|min:15';
        $ruleArray["$code" . '_category_id'] = 'required';
      }
    }

    return $ruleArray;
  }

  /**
   * Get the validation messages that apply to the request.
   *
   * @return array
   */
  public function messages()
  {
    $messageArray = [];

    $url = route('vendor.plugins.index');
    $messageArray = [
      'zoom.required' => 'If you enable zoom, then you have to set your zoom credentials. <a href="' . $url . '" class="link-primary" target="_blank">Click here</a>.',
      'calendar.required' => 'If you enable the calendar, then you have to set your calendar credentials. <a href="' . $url . '" class="link-primary" target="_blank">Click here</a>.',
    ];
    $languages = Language::all();

    foreach ($languages as $language) {
      $messageArray[$language->code . '_name.required'] = 'The title field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_name.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language.';

      $messageArray[$language->code . '_description.required'] = 'The description field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_description.min'] = 'The description field atleast have 15 characters for ' . $language->name . ' language';
      $messageArray[$language->code . '_category_id.required'] = 'The category field is required for ' . $language->name . ' language.';
    }

    return $messageArray;
  }

  private function getSliderImageCount()
  {
    $vendorId = $this->vendor_id;

    if ($vendorId == 0) {
      return PHP_INT_MAX;
    } else {

      $current_package =  VendorPermissionHelper::packagePermission($vendorId);
      if ($current_package != '[]') {
        $sliderImageCount = $current_package->number_of_service_image;
        //count service gallary images
        $serviceId = $this->request->get('service_id');
        $serviceImageCount = ServiceImage::where('service_id', $serviceId)->count();

        return $requiredImage = $sliderImageCount - $serviceImageCount;
      }
    }
  }
}
