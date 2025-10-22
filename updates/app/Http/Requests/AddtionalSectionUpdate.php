<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddtionalSectionUpdate extends FormRequest
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
      'order' => 'required',
      'serial_number' => 'required'
    ];

    $defaultLanguage = Language::where('is_default', 1)->first();
    // Default language fields should always be required
    $ruleArray[$defaultLanguage->code . '_name'] = [
      'required',
      'max:255',
      Rule::unique('custom_section_contents', 'section_name')->ignore($this->id, 'custom_section_id')
    ];

    $ruleArray[$defaultLanguage->code . '_content'] = 'min:15';


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
        $this->filled($code . '_content')
      ) {
        $ruleArray[$code . '_name'] = [
          'required',
          'max:255',
          Rule::unique('custom_section_contents', 'section_name')->ignore($this->id, 'custom_section_id')
        ];
        $ruleArray[$code . '_content'] = 'min:15';
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
    $messageArray = [
      'order.required' => 'The position field is required.',
      'serial_number.required' => 'The order number field is required.',
    ];
    $languages = Language::all();

    foreach ($languages as $language) {
      $messageArray[$language->code . '_name.required'] = 'The name field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_name.max'] = 'The name field cannot contain more than 255 characters for ' . $language->name . ' language.';

      $messageArray[$language->code . '_name.unique'] = 'The name field must be unique for ' . $language->name . ' language.';

      $messageArray[$language->code . '_content.min'] = 'The content field atleast have 15 characters for ' . $language->name . ' language.';
    }

    return $messageArray;
  }
}
