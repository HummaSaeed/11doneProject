<?php

namespace App\Models\Services;

use App\Models\Services\ServiceContent;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InqueryMessage extends Model
{
  use HasFactory;
  protected $table = 'inqury_messages';
  protected $fillable = [
    'vendor_id',
    'service_id',
    'first_name',
    'last_name',
    'email',
    'message',
  ];

  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
  }
  public function serviceContent()
  {
    return $this->hasMany(ServiceContent::class, 'service_id', 'service_id');
  }
}
