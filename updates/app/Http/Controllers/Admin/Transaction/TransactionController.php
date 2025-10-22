<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Admin\Transaction;
use App\Models\BasicSettings\Basic;
use App\Models\Vendor;
use DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  public function index(Request $request)
  {
    $transaction = $request->transaction_id;
    $data['transactions'] = Transaction::query()->when(
      $transaction,
      function ($query, $transaction) {
        return $query->where('transaction_id', 'like', '%' . $transaction . '%');
      }
    )
      ->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.transaction.index', $data);
  }


  public function storeTransaction($data)
  {
    // Check if there is any existing data for the user_id
    $existingTransaction = Transaction::where('vendor_id', $data['vendor_id'])->latest()->first();

    //update admin balance
    $admin_profit = Basic::pluck('admin_profit')->first();

    if ($data['vendor_id'] == 0) {
      if (isset($data['type'])) {
        $adminProfit = $admin_profit - $data['customer_paid'];
      } else {
        $adminProfit = $admin_profit + $data['customer_paid'];
      }
    }

    DB::table('basic_settings')->updateOrInsert(
      ['uniqid' => 12345],
      [
        'admin_profit' => $data['vendor_id'] == 0 ? $adminProfit : $admin_profit
      ]
    );

    //update vendor balance
    if ($data['vendor_id'] != 0) {

      $vendor_balance = Vendor::where('id',$data['vendor_id'])->pluck('amount')->first();
      if (isset($data['type'])) {
        if ($data['type'] == 'refund') {
          $vendor_new_balance = $vendor_balance - $data['customer_paid'];
        }
      } else {
        $vendor_new_balance = $vendor_balance + $data['customer_paid'];
      }

      DB::table('vendors')->updateOrInsert(
        ['id' => $data['vendor_id']],
        [
          'amount' => $vendor_new_balance
        ]
      );
    }

    // Calculate pre_balance based on existing data or set to 0 if no data found
    $pre_balance = $existingTransaction ? $existingTransaction->after_balance : 0;

    if (isset($data['type'])) {
      if ($data['type'] == 'refund') {
        $transactionType = 'booking_refund';
        $afterBalance = $pre_balance - $data['customer_paid'];
        $refund_amount = $data['customer_paid'];
        $actaulTotal = NULL;
      }
    } else {
      $transactionType = 'service_booking';
      $afterBalance = $pre_balance + $data['customer_paid'];
    }

    $transaction = Transaction::create([
      'transaction_id' => uniqid(),
      'vendor_id' => $data['vendor_id'],
      'admin_profit' => $data['vendor_id'] == 0 ? $data['customer_paid'] : NULL,
      'transaction_type' => $transactionType,
      'pre_balance' => $data['vendor_id'] == 0 ? NULL : $pre_balance,
      'actual_total' => $transactionType == 'booking_refund' ? $actaulTotal : $data['customer_paid'],
      'after_balance' => $data['vendor_id'] == 0 ? NULL : $afterBalance,
      'payment_method' => $data['paymentMethod'],
      'currency_symbol' => $data['currencySymbol'],
      'currency_symbol_position' => $data['currencySymbolPosition'],
      'payment_status' => $data['paymentStatus'],
      'refund_amount' => $transactionType == 'booking_refund' ? $refund_amount : NULL,
    ]);
    return $transaction;
  }
}
