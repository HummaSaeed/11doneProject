<?php

namespace App\Http\Controllers\Admin\FeaturedService;

use App\Http\Controllers\Controller;
use App\Http\Helpers\BasicMailer;
use App\Models\BasicSettings\Basic;
use App\Models\BasicSettings\MailTemplate;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\FeaturedService\ServicePromotion;
use App\Models\Language;
use App\Models\VendorInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Response;
use Validator;

class FeaturedServiceController extends Controller
{
  public function featuredService(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $information['language'] = $language;
    $language_id = $language->id;
    $information['language_id'] = $language_id;
    $information['langs'] = Language::all();

    $orderNumber = $paymentStatus = $orderStatus = $datas = null;
    if ($request->filled('order_no')) {
      $orderNumber = $request['order_no'];
    }
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }
    if ($request->filled('order_status')) {
      $orderStatus = $request['order_status'];
    }
    $featuredIds = [];
    if ($request->filled('active_status')) {
      if ($request['active_status'] == 'no') {
        $datas = ServicePromotion::where('end_date', '<=', Carbon::now()->format('Y-m-d'))
          ->orWhere('end_date', null)
          ->get()
          ->pluck('id');
      } else {
        $datas = ServicePromotion::where('end_date', '>=', Carbon::now()->format('Y-m-d'))
          ->get()
          ->pluck('id');
      }
      foreach ($datas as $data) {
        if (!in_array($data, $featuredIds)) {
          array_push($featuredIds, $data);
        }
      }
    }

    $information['featureds'] = ServicePromotion::with([
      'serviceContent' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      },
    ])
      ->when($orderNumber, function ($query, $orderNumber) {
        return $query->where('order_number', 'like', '%' . $orderNumber . '%');
      })
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($orderStatus, function ($query, $orderStatus) {
        return $query->where('order_status', '=', $orderStatus);
      })
      ->when($featuredIds, function ($query) use ($featuredIds) {
        return $query->whereIn('id', $featuredIds);
      })
      ->orderByDesc('id')
      ->paginate(10);

    return view('admin.featured-service.all', $information);
  }

  public function pendingFeaturedService(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $information['language'] = $language;
    $information['language_id'] = $language->id;
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $paymentStatus = $datas = null;
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }

    $featuredIds = [];
    if ($request->filled('active_status')) {
      if ($request['active_status'] == 'no') {
        $datas = ServicePromotion::where('end_date', '<=', Carbon::now()->format('Y-m-d'))
          ->orWhere('end_date', null)
          ->get()
          ->pluck('id');
      } else {
        $datas = ServicePromotion::where('end_date', '>=', Carbon::now()->format('Y-m-d'))
          ->get()
          ->pluck('id');
      }
      foreach ($datas as $data) {
        if (!in_array($data, $featuredIds)) {
          array_push($featuredIds, $data);
        }
      }
    }

    $information['featureds'] = ServicePromotion::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($featuredIds, function ($query) use ($featuredIds) {
        return $query->whereIn('id', $featuredIds);
      })
      ->where('order_status', 'pending')
      ->orderByDesc('id')
      ->paginate(10);
    return view('admin.featured-service.pending', $information);
  }

  public function apporvedFeaturedService(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $information['language'] = $language;
    $information['language_id'] = $language->id;
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $paymentStatus = $datas = null;
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }

    $featuredIds = [];
    if ($request->filled('active_status')) {
      if ($request['active_status'] == 'no') {
        $datas = ServicePromotion::where('end_date', '<=', Carbon::now()->format('Y-m-d'))
          ->orWhere('end_date', null)
          ->get()
          ->pluck('id');
      } else {
        $datas = ServicePromotion::where('end_date', '>=', Carbon::now()->format('Y-m-d'))
          ->get()
          ->pluck('id');
      }
      foreach ($datas as $data) {
        if (!in_array($data, $featuredIds)) {
          array_push($featuredIds, $data);
        }
      }
    }

    $information['featureds'] = ServicePromotion::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($featuredIds, function ($query) use ($featuredIds) {
        return $query->whereIn('id', $featuredIds);
      })
      ->where('order_status', 'approved')->orderByDesc('id')
      ->paginate(10);;
    return view('admin.featured-service.approved', $information);
  }

  public function rejectFeaturedService(Request $request)
  {
    $language = Language::where('code', request()->language)->firstOrFail();
    $information['language'] = $language;
    $information['language_id'] = $language->id;
    $language_id = $language->id;
    $information['langs'] = Language::all();

    $paymentStatus = $datas = null;
    if ($request->filled('payment_status')) {
      $paymentStatus = $request['payment_status'];
    }

    $featuredIds = [];
    if ($request->filled('active_status')) {
      if ($request['active_status'] == 'no') {
        $datas = ServicePromotion::where('end_date', '<=', Carbon::now()->format('Y-m-d'))
          ->orWhere('end_date', null)
          ->get()
          ->pluck('id');
      } else {
        $datas = ServicePromotion::where('end_date', '>=', Carbon::now()->format('Y-m-d'))
          ->get()
          ->pluck('id');
      }
      foreach ($datas as $data) {
        if (!in_array($data, $featuredIds)) {
          array_push($featuredIds, $data);
        }
      }
    }


    $information['featureds'] = ServicePromotion::with(['vendorInfo', 'serviceContent' => function ($q) use ($language_id) {
      $q->where('language_id', $language_id);
    }])
      ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', '=', $paymentStatus);
      })
      ->when($featuredIds, function ($query) use ($featuredIds) {
        return $query->whereIn('id', $featuredIds);
      })
      ->where('order_status', 'rejected')->orderByDesc('id')
      ->paginate(10);;
    return view('admin.featured-service.rejected', $information);
  }

  /**
   * payment status update
   */
  public function updatePaymentStatus(Request $request, $id)
  {
    $featuredRequest = ServicePromotion::find($id);
    //service info
    $language = Language::where('is_default', 1)->first();
    $service = $featuredRequest->serviceContent()
      ->where('language_id', $language->id)
      ->select('name', 'slug')
      ->first();
    if (!empty($service)) {
      $url = route('frontend.service.details', ['slug' => $service->slug, 'id' => $featuredRequest->service_id]);
      $serviceName = truncateString($service->name, 50);
    } else {
      $url = null;
      $serviceName = null;
    }

    // get the website title info from db
    $info = Basic::select('website_title')->first();
    $websiteTitle = $info->website_title;
    $vendorName = VendorInfo::where('vendor_id', $featuredRequest->vendor_id)
      ->first()->name;

    //update start here
    if ($request['payment_status'] == 'pending') {

      $featuredRequest->update([
        'payment_status' => 'pending',
      ]);
    } else if ($request['payment_status'] == 'completed') {

      $featuredRequest->update([
        'payment_status' => 'completed'
      ]);

      // generate an invoice in pdf format
      $invoice = $this->generateInvoice($featuredRequest);

      // then, update the invoice field info in database
      $featuredRequest->update([
        'invoice' => $invoice
      ]);

      //transaction create
      $after_balance = NULL;
      $pre_balance = NULL;
      $transactionData = [
        'vendor_id' => $featuredRequest->vendor_id,
        'transaction_type' => 'featured_service',
        'pre_balance' => $pre_balance,
        'actual_total' => $featuredRequest->amount,
        'after_balance' => $after_balance,
        'admin_profit' => $featuredRequest->amount,
        'payment_method' => $featuredRequest->payment_method,
        'currency_symbol' => $featuredRequest->currency_symbol,
        'currency_symbol_position' => $featuredRequest->currency_symbol_position,
        'payment_status' => $featuredRequest->payment_status,
      ];
      store_transaction($transactionData);

      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'featured_request_payment_approved')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // replacing with actual data
      $mailBody = str_replace('{service_title}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
      $mailBody = str_replace('{amount}', symbolPrice($featuredRequest->amount), $mailBody);
      $mailBody = str_replace('{username}', $vendorName, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);

      $mailData['body'] = $mailBody;
      $mailData['recipient'] = $featuredRequest->vendor->email;
      $mailData['invoice'] = public_path('assets/file/invoices/featured/service/') . $featuredRequest->invoice;
      BasicMailer::sendMail($mailData);
    } else {
      $featuredRequest->update([
        'payment_status' => 'rejected'
      ]);
      $invoice = $this->generateInvoice($featuredRequest);

      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'featured_request_payment_rejected')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // replacing with actual data
      $mailBody = str_replace('{service_title}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
      $mailBody = str_replace('{amount}', symbolPrice($featuredRequest->amount), $mailBody);
      $mailBody = str_replace('{username}', $vendorName, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);

      $mailData['body'] = $mailBody;
      $mailData['recipient'] = $featuredRequest->vendor->email;
      $mailData['invoice'] = public_path('assets/file/invoices/featured/service/' . $invoice);
      BasicMailer::sendMail($mailData);
    }
    return redirect()->back();
  }


  /**
   * order status update
   */
  public function updateOrderStatus(Request $request, $id)
  {
    $featuredRequest = ServicePromotion::find($id);
    // get the website title info from db
    $info = Basic::select('website_title')->first();
    $websiteTitle = $info->website_title;
    $vendorName = VendorInfo::where('vendor_id', $featuredRequest->vendor_id)->first()->name;

    //service info
    $language = Language::where('is_default', 1)->first();
    $service = $featuredRequest->serviceContent()
      ->where('language_id', $language->id)
      ->select('name', 'slug')
      ->first();
    if (!empty($service)) {
      $url = route('frontend.service.details', ['slug' => $service->slug, 'id' => $featuredRequest->service_id]);
      $serviceName = truncateString($service->name, 50);
    } else {
      $url = null;
      $serviceName = null;
    }

    if ($request['order_status'] == 'pending') {

      $featuredRequest->update([
        'order_status' => 'pending',
        'start_date' => null,
        'end_date' => null,
      ]);
    } else if ($request['order_status'] == 'approved') {
      $currentDate = Carbon::now();
      $formattedCurrentDate = $currentDate->format('Y-m-d');

      $endDate = $currentDate->copy()->addDays($featuredRequest->day);
      $formattedEndDate = $endDate->format('Y-m-d');

      $featuredRequest->update([
        'order_status' => 'approved',
        'start_date' => $formattedCurrentDate,
        'end_date' => $formattedEndDate
      ]);

      $invoice = $this->generateInvoice($featuredRequest);
      // then, update the invoice field info in database
      $featuredRequest->update([
        'invoice' => $invoice
      ]);
      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'featured_request_approved')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // replacing with actual data
      $startDate = Carbon::parse($featuredRequest->start_date)->formatLocalized('%e %B %Y');
      $endDate = Carbon::parse($featuredRequest->end_date)->formatLocalized('%e %B %Y');

      $mailBody = str_replace('{service_title}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
      $mailBody = str_replace('{username}', $vendorName, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);
      $mailBody = str_replace('{start_date}', $startDate, $mailBody);
      $mailBody = str_replace('{end_date}', $endDate, $mailBody);
      $mailBody = str_replace('{day}', $featuredRequest->day . " Days", $mailBody);

      $mailData['body'] = $mailBody;
      $mailData['recipient'] = $featuredRequest->vendor->email;
      $mailData['invoice'] = public_path('assets/file/invoices/featured/service/') . $featuredRequest->invoice;
      BasicMailer::sendMail($mailData);
    } else {
      //transaction create
      $after_balance = NULL;
      $pre_balance = NULL;
      $transactionData = [
        'vendor_id' => $featuredRequest->vendor_id,
        'transaction_type' => 'featured_service_reject',
        'pre_balance' => $pre_balance,
        'actual_total' => $featuredRequest->amount,
        'after_balance' => $after_balance,
        'admin_profit' => $featuredRequest->amount,
        'payment_method' => $featuredRequest->payment_method,
        'currency_symbol' => $featuredRequest->currency_symbol,
        'currency_symbol_position' => $featuredRequest->currency_symbol_position,
        'payment_status' => $featuredRequest->payment_status,
      ];
      store_transaction($transactionData);
      $featuredRequest->update([
        'order_status' => 'rejected',
      ]);
      $invoice =  $this->generateInvoice($featuredRequest);



      // get the mail template info from db
      $mailTemplate = MailTemplate::query()->where('mail_type', '=', 'featured_request_rejected')->first();
      $mailData['subject'] = $mailTemplate->mail_subject;
      $mailBody = $mailTemplate->mail_body;

      // replacing with actual data
      $mailBody = str_replace('{service_name}', "<a href=" . $url . ">$serviceName</a>", $mailBody);
      $mailBody = str_replace('{username}', $vendorName, $mailBody);
      $mailBody = str_replace('{website_title}', $websiteTitle, $mailBody);
      $mailBody = str_replace('{price}', symbolPrice($featuredRequest->amount), $mailBody);

      $mailData['body'] = $mailBody;
      $mailData['recipient'] = $featuredRequest->vendor->email;
      $mailData['invoice'] = public_path('assets/file/invoices/featured/service/') . $invoice;
      BasicMailer::sendMail($mailData);
    }
    return redirect()->back();
  }

  /**
   * generate invoice for payment & order status change
   */

  public function generateInvoice($requestInfo)
  {
    $fileName = $requestInfo->order_number . '.pdf';

    $data['orderInfo'] = $requestInfo;

    $directory = public_path('assets/file/invoices/featured/service/');
    @mkdir($directory, 0775, true);

    $fileLocated = $directory . $fileName;

    PDF::loadView('frontend.services.featured-service.invoice', $data)->save($fileLocated);

    return $fileName;
  }

  public function charge()
  {
    $charges = FeaturedServiceCharge::orderBy('created_at', 'desc')->get();
    return view('admin.featured-service.charge.index', compact('charges'));
  }

  public function chargeStore(Request $request)
  {
    $rules = [
      'amount' => 'required|numeric',
      'day' => 'required|numeric',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }

    FeaturedServiceCharge::create([
      'amount' => $request->amount,
      'day' => $request->day,
    ]);

    $request->session()->flash('success', 'New charge added successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function chargeUpdate(Request $request)
  {
    $rules = [
      'amount' => 'required|numeric',
      'day' => 'required|numeric',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return Response::json([
        'errors' => $validator->getMessageBag()
      ], 400);
    }
    $featuredServiceCharge = FeaturedServiceCharge::find($request->id);
    $featuredServiceCharge->update([
      'amount' => $request->amount,
      'day' => $request->day,
    ]);

    $request->session()->flash('success', 'New charge update successfully!');
    return Response::json(['status' => 'success'], 200);
  }

  public function destroy($id)
  {
    $charge = FeaturedServiceCharge::find($id);
    $charge->delete();
    return redirect()->back()->with('success', 'Charge deleted successfully');
  }

  public function bulkDestroy(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {

      $charge = FeaturedServiceCharge::find($id);
      $charge->delete();
      $request->session()->flash('success', 'Charge deleted successfully!');
    }
    return Response::json(['status' => 'success'], 200);
  }


  public function deleteFeaturedService($id)
  {
    $featuredService = ServicePromotion::find($id);
    // delete the attachment
    @unlink(public_path('assets/file/attachments/service-promotion/') . $featuredService->attachment);

    // delete the invoice
    @unlink(public_path('assets/file/invoices/featured/service/') . $featuredService->invoice);
    $featuredService->delete();
    return redirect()->back()->with('success', 'Featured serivce delete successfully!');
  }

  public function bulkDestroyFeaturedService(Request $request)
  {
    $ids = $request->ids;

    foreach ($ids as $id) {
      $featuredService = ServicePromotion::find($id);

      // delete the attachment
      @unlink(public_path('assets/file/attachments/service-promotion/') . $featuredService->attachment);

      // delete the invoice
      @unlink(public_path('assets/file/invoices/featured/service/') . $featuredService->invoice);

      $featuredService->delete();
    }

    $request->session()->flash('success', 'Featuerd Services Request deleted successfully!');

    return response()->json(['status' => 'success'], 200);
  }
}
