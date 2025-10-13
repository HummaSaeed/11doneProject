<?php


namespace App\Http\Controllers\Frontend\Booking\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\Booking\ServicePaymentController;
use App\Http\Helpers\CheckLimitHelper;
use App\Models\Services\ServiceBooking;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffGlobalHour;
use App\Models\Staff\StaffServiceHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mollie\Laravel\Facades\Mollie;
use Response;

class MollieController extends Controller
{
  public function index(Request $request, $paymentFor)
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

      $allowedCurrencies = array('AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR');

      $currencyInfo = $this->getCurrencyInfo();

      // checking whether the base currency is allowed or not
      if (!in_array($currencyInfo->base_currency_text, $allowedCurrencies)) {
        return Response::json(['error' => 'Invalid currency for mollie payment'], 422);
      }

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
        'paymentMethod' => 'Mollie',
        'gatewayType' => 'online',
        'paymentStatus' => 'completed',
        'orderStatus' => 'pending',
        'refund' => 'pending'
      );
      $title = 'Service Booking';
      $notifyURL = route('frontend.service_booking.mollie.notify');

      /**
       * we must send the correct number of decimals.
       * thus, we have used sprintf() function for format.
       */
      $payment = Mollie::api()->payments->create([
        'amount' => [
          'currency' => $currencyInfo->base_currency_text,
          'value' => sprintf('%0.2f', $serviceData['service_ammount'])
        ],
        'description' => $title . ' via Mollie',
        'redirectUrl' => $notifyURL
      ]);
      // put some data in session before redirect to mollie url
      $request->session()->put('paymentFor', $paymentFor);
      $request->session()->put('arrData', $arrData);
      $request->session()->put('payment', $payment);

      $checkoutUrl = $payment->getCheckoutUrl();
      return response()->json(['redirectURL' => $checkoutUrl]);
    } else {
      return redirect()->back()->with('error', 'Please Contact Support');
    }
  }

  public function notify(Request $request)
  {
    // get the information from session
    $arrData = $request->session()->get('arrData');
    $payment = $request->session()->get('payment');

    $paymentInfo = Mollie::api()->payments->get($payment->id);

    if ($paymentInfo->isPaid() == true) {
      // remove this session datas
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('payment');
      $request->session()->forget('serviceData');

      $bookingProcess = new ServicePaymentController();

      zoomCreate($arrData);
      calendarEventCreate($arrData);

      // store product order information in database
      $bookingInfo = $bookingProcess->storeData($arrData);

      $bookinId = ServiceBooking::where('service_id', $arrData['service_id'])->pluck('id')->first();
      $type = 'service_payment_approved';
      payemntStatusMail($type, $bookinId);

      Session::put('complete', 'payment_complete');
      Session::put('paymentInfo', $bookingInfo);
      return redirect()->route('frontend.services');
    } else {
      $request->session()->forget('paymentFor');
      $request->session()->forget('arrData');
      $request->session()->forget('payment');
      $request->session()->forget('serviceData');
      return redirect()->route('frontend.service_booking.cancel');
    }
  }
}
