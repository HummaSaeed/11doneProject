<?php

namespace App\Models\BasicSettings;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
  use HasFactory;
  protected $fillable = [
    'language_id',
    'title',
    'subtitle',
    'text',
    'button_text',
    'button_url',
    'about_section_image',
    'features_title'
  ];
  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id', 'id');
  }
}
