<?php

namespace App\Http\Controllers\Vendor\ServicePromotion\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Vendor\ServicePromotion\ServicePromotionController;
use App\Http\Helpers\UploadFile;
use App\Models\FeaturedService\FeaturedServiceCharge;
use App\Models\PaymentGateway\OfflineGateway;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class OfflineController extends Controller
{
  public function index(Request $request)
  {
    $gatewayId = $request->gateway;
    $offlineGateway = OfflineGateway::query()->findOrFail($gatewayId);

    // validation start
    if ($offlineGateway->has_attachment == 1) {
      $rules = [
        'attachment' => [
          'required',
          new ImageMimeTypeRule()
        ]
      ];

      $message = [
        'attachment.required' => 'Please attach your payment receipt.'
      ];

      $validator = Validator::make($request->only('attachment'), $rules, $message);

      if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()], 422);
      }
    }
    // validation end

    $paymentProcess = new ServicePromotionController();

    $directory = public_path('assets/file/attachments/service-promotion/');

    // store attachment in local storage
    if ($request->hasFile('attachment')) {
      $attachmentName = UploadFile::store($directory, $request->file('attachment'));
    } else {
      $attachmentName = null;
    }

    $currencyInfo = $this->getCurrencyInfo();

    $chargeId = FeaturedServiceCharge::find($request->promotion_id);

    $amount = intval($chargeId->amount);
    $day = intval($chargeId->day);

    $arrData = array(
      'amount' => $amount,
      'day' => $day,
      'service_id' => $request['service_id'],
      'vendor_id' => $request['vendor_id'],
      'invoice' => $request['invoice'],
      'currencyText' => $currencyInfo->base_currency_text,
      'currencyTextPosition' => $currencyInfo->base_currency_text_position,
      'currencySymbol' => $currencyInfo->base_currency_symbol,
      'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
      'paymentMethod' => $offlineGateway->name,
      'gatewayType' => 'offline',
      'paymentStatus' => 'pending',
      'orderStatus' => 'pending',
      'attachment' => $attachmentName
    );

    // store service booking information in database
    $paymentProcess->storeData($arrData);
    return response()->json(['redirectURL' => route('featured.service.offline.success.page')]);

    return response()->json('success fully done!');
  }
}
