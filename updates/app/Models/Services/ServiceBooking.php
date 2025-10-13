<?php

namespace App\Models\Services;

use App\Models\Staff\Staff;
use App\Models\Staff\StaffServiceHour;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function service()
  {
    return $this->belongsTo(Services::class, 'service_id', 'id');
  }
  public function staff()
  {
    return $this->belongsTo(Staff::class, 'staff_id', 'id');
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function serviceHoureTime()
  {
    return $this->belongsTo(StaffServiceHour::class, 'service_hour_id', 'id');
  }

  public function serviceContent()
  {
    return $this->hasMany(ServiceContent::class, 'service_id', 'service_id');
  }
  public function vendorInfo()
  {
    return $this->hasMany(VendorInfo::class, 'vendor_id', 'vendor_id');
  }
  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
  }
}
