<?php

namespace App\Models\Services;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'icon',
    'image',
    'slug',
    'language_id',
    'serial_number',
    'status',
    'background_color'
  ];

  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id', 'id');
  }

  public function service_content()
  {
    return $this->hasMany(ServiceContent::class, 'category_id', 'id');
  }
}
