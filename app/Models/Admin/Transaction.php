<?php

namespace App\Models\Admin;

use App\Models\Membership;
use App\Models\Vendor;
use App\Models\Withdraw\WithdrawPaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
  }
  public function method()
  {
    return $this->belongsTo(WithdrawPaymentMethod::class, 'payment_method', 'id');
  }

  public function membership()
  {
    return $this->belongsTo(Membership::class, 'transaction_id', 'id');
  }

}
