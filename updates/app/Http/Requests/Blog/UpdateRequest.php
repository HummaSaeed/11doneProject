<?php

namespace App\Http\Requests\Blog;

use App\Models\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
      'image' => $this->hasFile('image') ? new ImageMimeTypeRule() : '',
      'serial_number' => 'required|numeric'
    ];

    $defaultLanguage = Language::where('is_default', 1)->first();
    // Default language fields should always be required
    $ruleArray[$defaultLanguage->code . '_title'] = [
      'required',
      'max:255',
      Rule::unique('blog_informations', 'title')->ignore($this->id, 'blog_id')
    ];
    $ruleArray[$defaultLanguage->code . '_author'] = 'required|max:255';
    $ruleArray[$defaultLanguage->code . '_category_id'] = 'required';
    $ruleArray[$defaultLanguage->code . '_content'] = 'min:30';


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
        $this->filled($code . '_author') ||
        $this->filled($code . '_category_id') ||
        $this->filled($code . '_content') ||
        $this->filled($code . '_meta_keywords') ||
        $this->filled($code . '_meta_description')
      ) {
        $ruleArray[$code . '_title'] = [
          'required',
          'max:255',
          Rule::unique('blog_informations', 'title')->ignore($this->id, 'blog_id')
        ];
        $ruleArray[$code . '_author'] = 'required|max:255';
        $ruleArray[$code . '_category_id'] = 'required';
        $ruleArray[$code . '_content'] = 'min:30';
      }
    }

    return $ruleArray;
  }

  public function messages()
  {
    $messageArray = [];

    $languages = Language::all();

    foreach ($languages as $language) {
      $messageArray[$language->code . '_title.required'] = 'The title field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters for ' . $language->name . ' language.';

      $messageArray[$language->code . '_title.unique'] = 'The title field must be unique for ' . $language->name . ' language.';

      $messageArray[$language->code . '_author.required'] = 'The author field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_author.max'] = 'The author field cannot contain more than 255 characters for ' . $language->name . ' language.';

      $messageArray[$language->code . '_category_id.required'] = 'The category field is required for ' . $language->name . ' language.';

      $messageArray[$language->code . '_content.min'] = 'The content must be at least 30 characters for ' . $language->name . ' language.';
    }

    return $messageArray;
  }
}
