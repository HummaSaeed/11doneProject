<?php

namespace App\Http\Requests\Staff;

use App\Models\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffUpdateRequest extends FormRequest
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
    $ruleArray = [
      'status' => 'required',
      'email' => 'required',
      'phone' => 'required',
      'login_allow_toggle' => 'required',
      'order_number' => 'required',
    ];

    $defaultLanguage = Language::where('is_default', 1)->first();
    $ruleArray[$defaultLanguage->code . '_name'] = 'required|max:255';


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
        $this->filled($code . '_location') ||
        $this->filled($code . '_information')
      ) {
        $ruleArray[$code . '_name'] = 'required|max:255';
      }
    }

    $vendorId = $this->input('vendorId');
    $staffId = $this->input('staffId');

    if ($this->input('login_allow_toggle') == 1) {
      $ruleArray['username'] = [
        'required',
        Rule::unique('staff', 'username')->where(function ($query) use ($vendorId) {
          return $query->where('vendor_id', $vendorId);
        })->ignore($staffId, 'id')
      ];
    }
    if ($this->hasFile('staff_image')) {
      $ruleArray['staff_image'] = [
        'required',
        new ImageMimeTypeRule()
      ];
    }
    return $ruleArray;
  }

  public function messages()
  {
    $messageArray = [];


    $languages = Language::all();

    foreach ($languages as $language) {
      $messageArray[$language->code . '_name.required'] = 'The name field is required for ' . $language->name . ' language.';
      $messageArray[$language->code . '_location.required'] = 'The location field is required for ' . $language->name . ' language.';
      $messageArray[$language->code . '_name.max'] = 'The name field cannot contain more than 255 characters for ' . $language->name . ' language.';
    }

    return $messageArray;
  }
}
