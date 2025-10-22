<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminGlobalDay extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function day()
  {
    return $this->belongsTo(AdminGlobalDay::class, 'global_day_id', 'id');
  }
}
