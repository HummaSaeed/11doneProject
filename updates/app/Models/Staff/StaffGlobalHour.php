<?php

namespace App\Models\Staff;

use App\Models\Admin\AdminGlobalDay;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffGlobalHour extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function day()
  {
    return $this->belongsTo(StaffGlobalDay::class, 'global_day_id', 'id');
  }

  public function adminDay()
  {
    return $this->belongsTo(AdminGlobalDay::class, 'global_day_id', 'id');
  }
}
