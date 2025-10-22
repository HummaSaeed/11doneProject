<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPlugin extends Model
{
  use HasFactory;
  protected $fillable = ['staff_id', 'google_calendar', 'calender_id'];
}
