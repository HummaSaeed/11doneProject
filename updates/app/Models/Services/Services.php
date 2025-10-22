<?php

namespace App\Models\Services;

use App\Models\Language;
use App\Models\Vendor;
use App\Models\VendorInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
  use HasFactory;

  protected $fillable = [
    'vendor_id',
    'status',
    'price',
    'prev_price',
    'service_image',
    'zoom_meeting',
    'max_person',
    'calendar_status',
    'average_rating',
    'staff_id',
  ];

  public function language()
  {
    return $this->belongsTo(Language::class);
  }
  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
  }
  public function vendorInfo()
  {
    return $this->belongsTo(VendorInfo::class, 'vendor_id', 'vendor_id');
  }
  public function content()
  {
    return $this->hasMany(ServiceContent::class, 'service_id','id');
  }
  public function sliderImage()
  {
    return $this->hasMany(ServiceImage::class, 'service_id', 'id');
  }
  public function appointment()
  {
    return $this->hasMany(ServiceBooking::class, 'service_id', 'id');
  }
}
