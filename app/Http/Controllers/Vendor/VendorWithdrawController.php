<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Admin\Transaction;
use App\Models\Vendor;
use App\Models\Withdraw\Withdraw;
use App\Models\Withdraw\WithdrawMethodInput;
use App\Models\Withdraw\WithdrawPaymentMethod;
use Auth;
use DB;
use Illuminate\Http\Request;
use Response;
use Session;
use Validator;

class VendorWithdrawController extends Controller
{
  public function index()
  {
    $collection = Withdraw::with('method')
      ->where('vendor_id', Auth::guard('vendor')->user()->id)
      ->orderby('id', 'desc')
      ->get();

    return view('vendors.withdraw.index', compact('collection'));
  }
  //create
  public function create()
  {
    $information = [];
    $methods = WithdrawPaymentMethod::where('status', '=', 1)->get();
    $information['methods'] = $methods;
    return view('vendors.withdraw.create', $information);
  }

  //get_inputs
  public function get_inputs($id)
  {
    $data = WithdrawMethodInput::with('options')->where('withdraw_payment_method_id', $id)->orderBy('order_number', 'asc')->get();

    return $data;
  }

  //balance_calculation
  public function balance_calculation($method, $amount)
  {
    $method = WithdrawPaymentMethod::where('id', $method)->first();
    $fixed_charge = $method->fixed_charge;
    $percentage = $method->percentage_charge;

    $percentage_balance = ($amount * $percentage) / 100;
    $total_charge = $percentage_balance + $fixed_charge;
    $receive_balance = $amount - $total_charge;

    $user_balance = Auth::guard('vendor')->user()->amount - $amount;

    return ['total_charge' => round($total_charge, 2), 'receive_balance' => round($receive_balance, 2), 'user_balance' => round($user_balance, 2)];
  }

  //send_request
  public function send_request(Request $request)
  {
    $method = WithdrawPaymentMethod::where('id', $request->withdraw_method)->first();
    $vendor = Vendor::where('id', Auth::guard('vendor')->user()->id)->first();
    $bs = DB::table('basic_settings')->select('base_currency_symbol', 'base_currency_symbol_position')->first();
    $leftPosition = $bs->base_currency_symbol_position == 'left' ? $bs->base_currency_symbol : '';
    $rightPosition = $bs->base_currency_symbol_position == 'right' ? $bs->base_currency_symbol : '';

    if (!$request->withdraw_method) {
      return response()->json(['errors' => ['withdraw_method' => ['Withdraw Method field is required']]], 400);
    } elseif (intval($request->withdraw_amount) < $method->min_limit) {
      return response()->json(['errors' => ['withdraw_amount' => ['Minimum withdraw limit is ' . $leftPosition . $method->min_limit . $rightPosition]]], 400);
    } elseif (intval($request->withdraw_amount) > $method->max_limit) {
      return response()->json(['errors' => ['withdraw_amount' => ['Maximum withdraw limit is ' . $leftPosition . $method->max_limit . $rightPosition]]], 400);
    }

    $rules = [
      'withdraw_method' => 'required',
      'withdraw_amount' => "required",
    ];
    $inputs = WithdrawMethodInput::where('withdraw_payment_method_id', $request->withdraw_method)->orderBy('order_number', 'asc')->get();

    foreach ($inputs as $input) {
      if ($input->required == 1) {
        $rules["$input->name"] = 'required';
      }

      $fields = [];
      foreach ($inputs as $key => $input) {
        $in_name = $input->name;
        if ($request["$in_name"]) {
          $fields["$in_name"] = $request["$in_name"];
        }
      }
      $jsonfields = json_encode($fields);
      $jsonfields = str_replace("\/", "/", $jsonfields);;
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    //show error if current amount is less then withdraw amount
    if ($vendor->amount < $request->withdraw_amount) {
      Session::flash('error', "You don't have enough amount to withdraw..!");
      $request->session()->flash("warning", "You don't have enough amount to withdraw..!");
      return Response::json(['status' => 'success'], 200);
    }

    //calculation
    $fixed_charge = $method->fixed_charge;
    $percentage = $method->percentage_charge;

    $percentage_balance = (($request->withdraw_amount - $fixed_charge) * $percentage) / 100;
    $total_charge = $percentage_balance + $fixed_charge;
    $receive_balance = $request->withdraw_amount - $total_charge;
    //calculation end
    DB::transaction(function () use ($request, $vendor, $total_charge, $receive_balance, $fields) {
      // Store data to withdraw table
      $save = new Withdraw;
      $save->withdraw_id = uniqid();
      $save->vendor_id = Auth::guard('vendor')->user()->id;
      $save->method_id = $request->withdraw_method;

      //update vendor balance after withdraw
      $vendor = Vendor::where('id', Auth::guard('vendor')->user()->id)->first();
      $pre_balance = $vendor->amount;
      $vendor->amount = ($vendor->amount - ($request->withdraw_amount));
      $vendor->save();
      $after_balance = $vendor->amount;

      //admin profit update on basic_settings end
      $save->amount = $request->withdraw_amount;
      $save->payable_amount = $receive_balance;
      $save->total_charge = $total_charge;
      $save->additional_reference = $request->additional_reference;
      $save->fields = json_encode($fields);
      $save->save();

      //store data to transaction table
      $currencyInfo = $this->getCurrencyInfo();
      $transcation = Transaction::create([
        'transaction_id' => uniqid(),
        'withdraw_id' => $save->id,
        'transaction_type' => 'withdraw',
        'vendor_id' => Auth::guard('vendor')->user()->id,
        'payment_status' => 'pending',
        'payment_method' => $save->method_id,
        'pre_balance' => $pre_balance,
        'after_balance' => $after_balance,
        'actual_total' => $request->withdraw_amount,
        'admin_profit' => $request->total_charge_input,
        'currency_symbol' => $currencyInfo->base_currency_symbol,
        'currency_symbol_position' => $currencyInfo->base_currency_symbol_position,
      ]);
    });
    $request->session()->flash("success", "Withdraw Request Send Successfully!");
    return Response::json(['status' => 'success'], 200);
  }
  //bulkDelete
  public function bulkDelete(Request $request)
  {
    $ids = $request->ids;
    foreach ($ids as $id) {
      $withdraw = Withdraw::where('id', $id)->first();
      $withdraw->delete();
    }
    $request->session()->flash("success", "Withdraw Request Deleted Successfully!");
    return Response::json(['status' => 'success'], 200);
  }
  //Delete
  public function Delete(Request $request)
  {
    $withdraw = Withdraw::where('id', $request->id)->first();
    $vendor = Vendor::find(Auth::guard('vendor')->user()->id);
    $totalAmount = $vendor->amount + $withdraw->amount;
    if ($withdraw->status == 0) {
      $withdraw->delete();
      $vendor->update(['amount' => $totalAmount]);
      return redirect()->back()->with('success', 'Withdraw Request Deleted Successfully!');
    } else {
      return redirect()->back()->with("warning", "Sorry you can't delete this !");
    }
  }
}
