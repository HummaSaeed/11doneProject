<?php

namespace App\Http\Controllers\Admin\Withdraw;

use App\Http\Controllers\Controller;
use App\Http\Helpers\BasicMailer;
use App\Models\Admin\Transaction;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\Vendor;
use App\Models\Withdraw\Withdraw;
use DB;
use Illuminate\Http\Request;

class WithdrawRequestController extends Controller
{
  public function index()
  {
    $search = request()->input('search');

    $information['collection'] = Withdraw::with('method')
      ->when($search, function ($query, $keyword) {
        return $query->where('withdraws.withdraw_id', 'like', '%' . $keyword . '%');
      })
      ->orderBy('id', 'desc')->paginate(10);
    $information['currencyInfo'] = $this->getCurrencyInfo();
    return view('admin.withdraw.history.index', $information);
  }

  //payment approve
  public function approve($id)
  {
    $withdraw = Withdraw::where('id', $id)->first();
    //update transcation
    $transaction = Transaction::where('withdraw_id', $withdraw->id)
      ->where('transaction_type', 'Withdraw')
      ->first();
    $transaction->update([
      'payment_status' => 'completed'
    ]);

    $withdraw->status = 1;
    $withdraw->save();

    //admin profit update on basic_settings start
    $prev_admin_profit = DB::table('basic_settings')->pluck('admin_profit')->first();
    $admin_profit = $withdraw->total_charge + $prev_admin_profit;

    DB::table('basic_settings')->updateOrInsert(
      ['uniqid' => 12345],
      [
        'admin_profit' => $admin_profit,
      ]
    );

    //mail sending
    // get the mail template info from db
    $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'withdraw_approved')->first();
    $mailData['subject'] = $mailTemplate->mail_subject;
    $mailBody = $mailTemplate->mail_body;

    // get the website title info from db
    $info = Basic::select('website_title', 'base_currency_symbol')->first();

    $vendor = $withdraw->vendor()->first();

    // preparing dynamic data
    $vendorName = $vendor->username;
    $vendorEmail = $vendor->email;
    $vendor_amount = $vendor->amount;
    $method = $withdraw->method()->select('name')->first();
    $websiteTitle = $info->website_title;

    // replacing with actual data
    $mailBody = str_replace('{username}', $vendorName, $mailBody);
    $mailBody = str_replace('{withdraw_id}', $withdraw->withdraw_id, $mailBody);
    $mailBody = str_replace('{current_balance}', $info->base_currency_symbol . $vendor_amount, $mailBody);
    $mailBody = str_replace('{withdraw_amount}', $info->base_currency_symbol . $withdraw->amount, $mailBody);
    $mailBody = str_replace('{charge}', $info->base_currency_symbol . $withdraw->total_charge, $mailBody);
    $mailBody = str_replace('{payable_amount}', $info->base_currency_symbol . $withdraw->payable_amount, $mailBody);
    $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);

    $mailData['body'] = $mailBody;

    $mailData['recipient'] = $vendorEmail;
    BasicMailer::sendMail($mailData);
    return redirect()->back()->with('success', 'Withdraw Request Approve Successfully!');
  }

  //payment decline
  public function decline($id)
  {
    $withdraw = Withdraw::where('id', $id)->first();

    //update transcation
    $transaction = Transaction::where('withdraw_id', $withdraw->id)
      ->where('transaction_type', 'Withdraw')
      ->select('currency_symbol', 'currency_symbol_position')
      ->first();

    $withdraw->status = 2;
    $withdraw->save();

    //update vendor balance
    $vendor_balance = Vendor::where('id', $withdraw->vendor_id)->pluck('amount')->first();
    $vendor_new_balance = $vendor_balance + $withdraw->amount;

    DB::table('vendors')->updateOrInsert(
      ['id' => $withdraw->vendor_id],
      [
        'amount' => $vendor_new_balance
      ]
    );

    $transcation = Transaction::create([
      'transaction_id' => uniqid(),
      'withdraw_id' => $withdraw->id,
      'transaction_type' => 'withdraw_declined',
      'vendor_id' => $withdraw->vendor_id,
      'payment_status' => 'rejected',
      'payment_method' => $withdraw->method_id,
      'pre_balance' => $vendor_balance,
      'after_balance' => $vendor_new_balance,
      'actual_total' => $withdraw->amount,
      'currency_symbol' => $transaction->currency_symbol,
      'currency_symbol_position' => $transaction->currency_symbol_position,
    ]);


    //mail sending
    // get the mail template info from db
    $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'withdraw_declined')->first();
    $mailData['subject'] = $mailTemplate->mail_subject;
    $mailBody = $mailTemplate->mail_body;

    // get the website title info from db
    $info = Basic::select('website_title', 'base_currency_symbol')->first();

    $vendor = $withdraw->vendor()->first();

    // preparing dynamic data
    $vendorName = $vendor->username;
    $vendorEmail = $vendor->email;
    $vendor_amount = $vendor->amount;
    $method = $withdraw->method()->select('name')->first();
    $websiteTitle = $info->website_title;

    // replacing with actual data
    $mailBody = str_replace('{username}', $vendorName, $mailBody);
    $mailBody = str_replace('{withdraw_id}', $withdraw->withdraw_id, $mailBody);
    $mailBody = str_replace('{current_balance}', $info->base_currency_symbol . $vendor_amount, $mailBody);
    $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);

    $mailData['body'] = $mailBody;

    $mailData['recipient'] = $vendorEmail;

    BasicMailer::sendMail($mailData);
    return redirect()->back()->with('success', 'Withdraw Request Decline Successfully!');
  }
  //payment request delete
  public function delete(Request $request)
  {
    $withdraw = Withdraw::where('id', $request->id)->first();

    if ($withdraw->status == 0) {
      //update vendor balance
      $vendor_balance = Vendor::where('id', $withdraw->vendor_id)->pluck('amount')->first();
      $vendor_new_balance = $vendor_balance + $withdraw->amount;

      DB::table('vendors')->updateOrInsert(
        ['id' => $withdraw->vendor_id],
        [
          'amount' => $vendor_new_balance
        ]
      );

      $withdraw->delete();

      //mail sending
      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'withdraw_declined')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // get the website title info from db
      $info = Basic::select('website_title', 'base_currency_symbol')->first();

      $vendor = $withdraw->vendor()->first();

      // preparing dynamic data
      $vendorName = $vendor->username;
      $vendorEmail = $vendor->email;
      $vendor_amount = $vendor->amount;
      $method = $withdraw->method()->select('name')->first();
      $websiteTitle = $info->website_title;

      // replacing with actual data
      $mailBody = str_replace('{username}', $vendorName, $mailBody);
      $mailBody = str_replace('{withdraw_id}', $withdraw->withdraw_id, $mailBody);
      $mailBody = str_replace('{current_balance}', $info->base_currency_symbol . $vendor_amount, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);

      $mailData['body'] = $mailBody;

      $mailData['recipient'] = $vendorEmail;

      BasicMailer::sendMail($mailData);

      return redirect()->back()->with('success', 'Withdraw Request Deleted Successfully!');
    } else {
      $withdraw->delete();
      return redirect()->back()->with('success', 'Withdraw Request Deleted Successfully!');
    }
  }
}
