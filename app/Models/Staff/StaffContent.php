<?php

namespace App\Models\Staff;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffContent extends Model
{
  use HasFactory;

  protected $fillable = [
    'staff_id',
    'language_id',
    'name',
    'information',
    'location',
  ];

  public function staff()
  {
    return $this->belongsTo(Staff::class, 'id', 'staff_id');
  }
  public function language()
  {
    return $this->belongsTo(Language::class, 'language_id', 'id');
  }
}
