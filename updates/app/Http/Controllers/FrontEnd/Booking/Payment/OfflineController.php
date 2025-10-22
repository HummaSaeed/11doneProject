<?php

namespace App\Http\Controllers\FrontEnd\Booking\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\CheckLimitHelper;
use App\Http\Helpers\UploadFile;
use App\Models\PaymentGateway\OfflineGateway;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffServiceHour;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Response;

class OfflineController extends Controller
{
  public function index(Request $request)
  {
    if (Session::has('serviceData')) {
      $serviceData = Session::get('serviceData');
    } else {
      return redirect()->back()->with('error', 'Something went wrong');
    }
    //check membership expire date
    if ($serviceData['vendor_id'] != 0) {
      $expireDate = checkMembersipExpireDate($serviceData['vendor_id']);
      if ($request['bookingDate'] > $expireDate) {
        return redirect()->back()->with('error', 'Something went wrong');
      }
    }
    $countAppointment = CheckLimitHelper::countAppointment($serviceData['vendor_id']);
    if ($countAppointment > 0) {
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

      $paymentProcess = new ServicePaymentController();

      $directory = public_path('assets/file/attachments/service/');

      // store attachment in local storage
      if ($request->hasFile('attachment')) {
        $attachmentName = UploadFile::store($directory, $request->file('attachment'));
      } else {
        $attachmentName = null;
      }

      $currencyInfo = $this->getCurrencyInfo();

      $staff = Staff::find($request['staffId']);

      if ($staff->is_day == 1) {
        $staffHour = StaffServiceHour::find($request['serviceHourId']);
      } else {
        $staffHour = StaffGlobalHour::find($request['serviceHourId']);
      }

      $arrData = array(
        'zoom_status' => $serviceData['zoom_status'],
        'calender_status' => $serviceData['calendar_status'],
        'customer_name' => $request['name'],
        'customer_phone' => $request['phone'],
        'customer_email' => $request['email'],
        'customer_address' => $request['address'],
        'customer_zip_code' => $request['zip_code'],
        'customer_country' => $request['country'],
        'start_date' => $staffHour->start_time,
        'end_date' => $staffHour->end_time,
        'booking_date' => $request['bookingDate'],
        'service_hour_id' => $request['serviceHourId'],
        'staff_id' => $request['staffId'],
        'max_person' => $request['max_person'],
        'service_id' => $serviceData['service_id'],
        'user_id' => $request['user_id'],
        'vendor_id' => $serviceData['vendor_id'],
        'customer_paid' => $serviceData['service_ammount'],
        'currencyText' => $currencyInfo->base_currency_text,
        'currencyTextPosition' => $currencyInfo->base_currency_text_position,
        'currencySymbol' => $currencyInfo->base_currency_symbol,
        'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
        'paymentMethod' => $offlineGateway->name,
        'gatewayType' => 'offline',
        'paymentStatus' => 'pending',
        'orderStatus' => 'pending',
        'refund' => 'pending',
        'attachment' => $attachmentName
      );

      zoomCreate($arrData);
      calendarEventCreate($arrData);

      // store service booking information in database
      $bookingInfo = $paymentProcess->storeData($arrData);

      Session::put('complete', 'payment_complete');
      Session::put('paymentInfo', $bookingInfo);
      $request->session()->forget('serviceData');

      return response()->json(['redirectURL' => route('frontend.services')]);

      return response()->json('success fully done!');
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }
}
