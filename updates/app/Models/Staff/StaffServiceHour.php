<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffServiceHour extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function staffday()
  {
    return $this->belongsTo(StaffDay::class, 'staff_day_id', 'id');
  }
}
