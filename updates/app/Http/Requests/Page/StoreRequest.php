<?php

namespace App\Http\Requests\Page;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
   * @return array
   */
  public function rules()
  {
    $ruleArray = [
      'status' => 'required'
    ];

    $defaultLanguage = Language::where('is_default', 1)->first();
    // Default language fields should always be required
    $ruleArray[$defaultLanguage->code . '_title'] = 'required|max:255|unique:page_contents,title';
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
        $this->filled($code . '_title') ||
        $this->filled($code . '_content')
      ) {
        $ruleArray[$code . '_title'] = 'required|max:255|unique:page_contents,title';
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

    $languages = Language::all();

    foreach ($languages as $language) {
      $messageArray[$language->code . '_title.required'] = 'The title field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language.';

      $messageArray[$language->code . '_title.unique'] = 'The title field must be unique for ' . $language->name . ' language.';

      $messageArray[$language->code . '_content.min'] = 'The content field atleast have 15 characters for ' . $language->name . ' language.';
    }

    return $messageArray;
  }
}
