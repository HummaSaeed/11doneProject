<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Admin\Transaction;
use App\Models\Vendor;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  public function index(Request $request)
  {
    $transaction = $request->transaction_id;
    $data['transactions'] = Transaction::where('vendor_id', Auth::guard('vendor')->user()->id)
      ->orderBy('id', 'desc')
      ->when(
        $transaction,
        function ($query, $transaction) {
          return $query->where('transaction_id', 'like', '%' . $transaction . '%');
        }
      )
      ->whereNotIn('transaction_type', ['membership_buy', 'featured_service'])
      ->paginate(10);

    return view('vendors.transaction.index', $data);
  }

  public function storeTransaction($data)
  {
    // Check if there is any existing data for the user_id
    $existingTransaction = Transaction::where('vendor_id', $data['vendor_id'])->latest()->first();

    //update vendor balance
    $vendor_balance = Vendor::pluck('amount')->first();
    $vendor_new_balance = $vendor_balance + $data['customer_paid'];

    DB::table('vendors')->updateOrInsert(
      ['id' => $data['vendor_id']],
      [
        'amount' => $vendor_new_balance
      ]
    );

    // Calculate pre_balance based on existing data or set to 0 if no data found
    $pre_balance = $existingTransaction ? $existingTransaction->after_balance : 0;

    $afterBalance = $pre_balance + $data['customer_paid'];

    $transaction = Transaction::create([
      'transaction_id' => uniqid(),
      'vendor_id' => $data['vendor_id'],
      'transaction_type' => 'service_booking',
      'pre_balance' => $pre_balance,
      'actual_total' => $data['customer_paid'],
      'after_balance' => $afterBalance,
      'payment_method' => $data['paymentMethod'],
      'currency_symbol' => $data['currencySymbol'],
      'currency_symbol_position' => $data['currencySymbolPosition'],
      'payment_status' => $data['paymentStatus'],
    ]);
    return $transaction;
  }
}
