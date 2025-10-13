<?php

namespace App\Models\Staff;

use App\Models\Services\ServiceContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffService extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function staff()
  {
    return $this->hasMany(Staff::class, 'id', 'staff_id');
  }
  public function staffContent()
  {
    return $this->hasMany(StaffContent::class, 'staff_id', 'staff_id');
  }

  public function service()
  {
    return $this->hasMany(ServiceContent::class, 'service_id', 'service_id');
  }
}
