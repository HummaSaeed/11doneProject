<?php

namespace App\Http\Controllers\Admin\Withdraw;

use App\Http\Controllers\Controller;
use App\Models\Withdraw\WithdrawPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Response;
use Validator;

class WithdrawController extends Controller
{
  public function index()
  {
    $data['paymentMethods'] = WithdrawPaymentMethod::all();
    return view('admin.withdraw.index', $data);
  }

  /**
   * Store Withdraw Payment Method
   */
  public function storePayment(Request $request)
  {
    $rules = [
      'name' => 'required|string|max:255',
      'min_limit' => 'required|numeric',
      'max_limit' => 'required|numeric',
      'fixed_charge' => 'nullable|numeric',
      'percentage_charge' => 'nullable|numeric',
      'status' => 'required|in:0,1',
    ];
    $fixed_charge = $request->fixed_charge;
    $percentage = $request->percentage_charge;
    $min_limit = $request->min_limit;

    $percentage_balance = (($request->min_limit - $fixed_charge) * $percentage) / 100;
    $total_charge = $percentage_balance + $fixed_charge;
    $currency_text = DB::table('basic_settings')->pluck('base_currency_text')->first();

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()->toArray()
      ], 400);
    }
    if ($total_charge >= $min_limit) {
      return response()->json(['error' => "Minimum limit amount must be more then Fixed charge"], 400);
    } else {
      // Create a new withdrawal payment method
      WithdrawPaymentMethod::create([
        'name' => $request->name,
        'min_limit' => $request->min_limit,
        'max_limit' => $request->max_limit,
        'fixed_charge' => $request->fixed_charge,
        'percentage_charge' => $request->percentage_charge,
        'status' => $request->status,
      ]);

      // Redirect back or wherever you want
      $request->session()->flash('success', 'New payment method added successfully!');
      return Response::json(['status' => 'success'], 200);
    }
  }

  /**
   * Update Withdraw Payment Method
   */
  public function updatePayment(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => [
        'required',
        'max:255',
        Rule::unique('withdraw_payment_methods', 'name')->ignore($request->id, 'id')
      ],
      'min_limit' => 'required|numeric',
      'max_limit' => 'required|numeric',
      'fixed_charge' => 'nullable|numeric',
      'percentage_charge' => 'nullable|numeric',
      'status' => 'required|in:0,1',
    ]);

    $fixed_charge = $request->fixed_charge;
    $percentage = $request->percentage_charge;
    $min_limit = $request->min_limit;

    $percentage_balance = (($request->min_limit - $fixed_charge) * $percentage) / 100;
    $total_charge = $percentage_balance + $fixed_charge;
    $currency_text = DB::table('basic_settings')->pluck('base_currency_text')->first();


    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    if ($total_charge >= $min_limit) {
      return response()->json(['error' => "Minimum limit amount must be more then Fixed charge"], 400);
    } else {

      $withdrawPaymentMethod = WithdrawPaymentMethod::find($request->id);
      $withdrawPaymentMethod->update($request->all());

      $request->session()->flash('success', 'Update payment method successfully!');
      return response()->json(['status' => 'success'], 200);
    }
  }

  /**
   * Delete Payment Method
   */
  public function deletePayment($id)
  {
    $paymentMethod = WithdrawPaymentMethod::find($id);
    if ($paymentMethod) {
      $paymentMethod->delete();
      return redirect()->back()->with('success', 'Payment method delete successfully!');
    }
  }

  /**
   * bulkDestroy Payment Method
   */
  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $paymentMethod = WithdrawPaymentMethod::find($id);
      $paymentMethod->delete();
    }

    $request->session()->flash('success', 'Payment method delete successfully!');
    return response()->json(['status' => 'success'], 200);
  }

  /**
   * calculation
   */

  public function calculation()
  {
  }
}
