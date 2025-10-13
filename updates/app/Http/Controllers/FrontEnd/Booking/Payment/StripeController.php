<?php

namespace App\Http\Controllers\FrontEnd\Booking\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\CheckLimitHelper;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffServiceHour;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Response;

class StripeController extends Controller
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
      // card validation start
      $rules = [
        'stripeToken' => 'required',
      ];

      $validator = Validator::make($request->all(), $rules);

      if ($validator->fails()) {
        return Response::json(['errors' => $validator->errors()], 422);
      }
      // card validation end
      $customerpaid = intval($serviceData['service_ammount']);
      $currencyInfo = $this->getCurrencyInfo();

      // changing the currency before redirect to Stripe
      if ($currencyInfo->base_currency_text !== 'USD') {
        $rate = floatval($currencyInfo->base_currency_rate);
        $convertedTotal = round(($customerpaid / $rate), 2);
      }

      $stripeTotal = $currencyInfo->base_currency_text === 'USD' ? $customerpaid : $convertedTotal;

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
        'customer_paid' => $customerpaid,
        'currencyText' => $currencyInfo->base_currency_text,
        'currencyTextPosition' => $currencyInfo->base_currency_text_position,
        'currencySymbol' => $currencyInfo->base_currency_symbol,
        'currencySymbolPosition' => $currencyInfo->base_currency_symbol_position,
        'paymentMethod' => 'Stripe',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );

      try {
        // initialize stripe
        $stripe = new Stripe();
        $stripe = Stripe::make(Config::get('services.stripe.secret'));

        try {

          // generate charge
          $charge = $stripe->charges()->create([
            'source' => $request->stripeToken,
            'currency' => 'USD',
            'amount'   => $stripeTotal,
          ]);

          if ($charge['status'] == 'succeeded') {
            $bookingProcess = new ServicePaymentController();

            zoomCreate($arrData);
            calendarEventCreate($arrData);

            // store product order information in database
            $bookingInfo = $bookingProcess->storeData($arrData);

            //send mail
            $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
            $type = 'service_payment_approved';
            payemntStatusMail($type, $bookinId);

            Session::put('complete', 'payment_complete');
            Session::put('paymentInfo', $bookingInfo);
            $request->session()->forget('serviceData');

            return redirect()->route('frontend.services');
          } else {
            $request->session()->forget('serviceData');
            return redirect()->route('frontend.service_booking.cancel');
          }
        } catch (Exception $e) {
          Session::flash('error', $e->getMessage());
          Session::forget('serviceData');
          return redirect()->route('frontend.service_booking.cancel');
        }
      } catch (Exception $e) {
        Session::flash('error', $e->getMessage());
        Session::forget('serviceData');
        return redirect()->route('frontend.service_booking.cancel');
      }
    } else {
      Session::forget('serviceData');
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }
}
