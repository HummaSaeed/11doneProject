<?php

namespace App\Models\Services;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContent extends Model
{
  use HasFactory;

  protected $fillable = [
    'service_id',
    'language_id',
    'category_id',
    'name',
    'description',
    'slug',
    'meta_keyword',
    'meta_description',
    'features',
    'address',
    'postcode'
  ];

  public function service()
  {
    return $this->belongsTo(Services::class);
  }
  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id', 'id');
  }

  public function category()
  {
    return $this->belongsTo(ServiceCategory::class);
  }


    public function service_content_sub()
    {
        return $this->hasMany(ServiceContentSub::class, 'service_content_id', 'id');
    }

}
