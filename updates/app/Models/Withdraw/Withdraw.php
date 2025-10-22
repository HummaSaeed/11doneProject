<?php

namespace App\Models\Withdraw;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
  use HasFactory;
  protected $fillable = [
    'vendor_id',
    'withdraw_id',
    'method_id',
    'amount',
    'payable_amount',
    'total_charge',
    'additional_reference',
    'fields',
    'status',
  ];

  public function method()
  {
    return $this->belongsTo(WithdrawPaymentMethod::class, 'method_id', 'id');
  }

  public function vendor()
  {
    return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
  }
}
