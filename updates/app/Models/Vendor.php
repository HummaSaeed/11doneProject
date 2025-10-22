<?php

namespace App\Models;

use App\Models\Services\ServiceBooking;
use App\Models\Services\ServiceReview;
use App\Models\Services\Services;
use App\Models\Staff\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Vendor extends Model implements AuthenticatableContract
{
  use HasFactory, Authenticatable;

  protected $fillable = [
    'photo',
    'email',
    'recived_email',
    'phone',
    'username',
    'password',
    'status',
    'amount',
    'total_appointment',
    'facebook',
    'twitter',
    'linkedin',
    'avg_rating',
    'email_verified_at',
    'show_email_addresss',
    'show_phone_number',
    'show_contact_form',
  ];

  public function vendor_info()
  {
    return $this->hasOne(VendorInfo::class,'vendor_id','id');
  }
  public function vendor_infos()
  {
    return $this->hasMany(VendorInfo::class);
  }

  //support ticket
  public function support_ticket()
  {
    return $this->hasMany(SupportTicket::class, 'vendor_id', 'id');
  }

  public function memberships()
  {
    return $this->hasMany(Membership::class);
  }
  public function service()
  {
    return $this->hasMany(Services::class);
  }
  public function staff()
  {
    return $this->hasMany(Staff::class);
  }
  public function appointment()
  {
    return $this->hasMany(ServiceBooking::class);
  }
  public function serviceReview()
  {
    return $this->hasMany(ServiceReview::class, 'vendor_id', 'id');
  }
}
