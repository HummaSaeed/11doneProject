<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| vendor Interface Routes
|--------------------------------------------------------------------------
*/

Route::prefix('vendor')->middleware('change.lang')->group(function () {
  Route::get('/dashboard', 'Vendor\VendorController@index')->name('vendor.index');
  Route::get('/signup', 'Vendor\VendorController@signup')->name('vendor.signup');
  Route::post('/signup/submit', 'Vendor\VendorController@create')->name('vendor.signup_submit');
  Route::get('/login', 'Vendor\VendorController@login')->name('vendor.login')->middleware('guest:vendor');
  Route::post('/login/submit', 'Vendor\VendorController@authentication')->name('vendor.login_submit');

  Route::get('/email/verify', 'Vendor\VendorController@confirm_email');

  Route::get('/forget-password', 'Vendor\VendorController@forget_passord')->name('vendor.forget.password');
  Route::post('/send-forget-mail', 'Vendor\VendorController@forget_mail')->name('vendor.forget.mail');
  Route::get('/reset-password', 'Vendor\VendorController@reset_password')->name('vendor.reset.password');
  Route::post('/update-forget-password', 'Vendor\VendorController@update_password')->name('vendor.update-forget-password');
});


Route::prefix('vendor')->middleware('auth:vendor', 'Deactive')->group(function () {
  Route::get('dashboard', 'Vendor\VendorController@dashboard')->name('vendor.dashboard');
  Route::get('/change-password', 'Vendor\VendorController@change_password')->name('vendor.change_password');
  Route::post('/update-password', 'Vendor\VendorController@updated_password')->name('vendor.update_password');
  Route::get('/edit-profile', 'Vendor\VendorController@edit_profile')->name('vendor.edit.profile');
  Route::post('/profile/update', 'Vendor\VendorController@update_profile')->name('vendor.update_profile');
  Route::get('/logout', 'Vendor\VendorController@logout')->name('vendor.logout');

  // change vendor-panel theme (dark/light) route
  Route::post('/change-theme', 'Vendor\VendorController@changeTheme')->name('vendor.change_theme');
  Route::get('/subscription-log', 'Vendor\VendorController@subscription_log')->name('vendor.subscription_log');

  //vendor package extend route
  Route::get('/package-list', 'Vendor\BuyPlanController@index')->name('vendor.plan.extend.index');
  Route::get('/package/checkout/{package_id}', 'Vendor\BuyPlanController@checkout')->name('vendor.plan.extend.checkout');
  Route::post('/package/checkout', 'Vendor\VendorCheckoutController@checkout')->name('vendor.plan.checkout');

  Route::post('/payment/instructions', 'Vendor\VendorCheckoutController@paymentInstruction')->name('vendor.payment.instructions');


  //checkout payment gateway routes
  Route::prefix('membership')->group(function () {
    Route::get('paypal/success', "Payment\PaypalController@successPayment")->name('membership.paypal.success');
    Route::get('paypal/cancel', "Payment\PaypalController@cancelPayment")->name('membership.paypal.cancel');
    Route::get('stripe/cancel', "Payment\StripeController@cancelPayment")->name('membership.stripe.cancel');
    Route::post('paytm/payment-status', "Payment\PaytmController@paymentStatus")->name('membership.paytm.status');
    Route::get('paystack/success', 'Payment\PaystackController@successPayment')->name('membership.paystack.success');
    Route::post('mercadopago/cancel', 'Payment\paymenMercadopagoController@cancelPayment')->name('membership.mercadopago.cancel');
    Route::get('mercadopago/success', 'Payment\MercadopagoController@successPayment')->name('membership.mercadopago.success');
    Route::post('razorpay/success', 'Payment\RazorpayController@successPayment')->name('membership.razorpay.success');
    Route::post('razorpay/cancel', 'Payment\RazorpayController@cancelPayment')->name('membership.razorpay.cancel');
    Route::get('instamojo/success', 'Payment\InstamojoController@successPayment')->name('membership.instamojo.success');
    Route::post('instamojo/cancel', 'Payment\InstamojoController@cancelPayment')->name('membership.instamojo.cancel');
    Route::post('flutterwave/success', 'Payment\FlutterWaveController@successPayment')->name('membership.flutterwave.success');
    Route::post('flutterwave/cancel', 'Payment\FlutterWaveController@cancelPayment')->name('membership.flutterwave.cancel');
    Route::get('/mollie/success', 'Payment\MollieController@successPayment')->name('membership.mollie.success');
    Route::post('mollie/cancel', 'Payment\MollieController@cancelPayment')->name('membership.mollie.cancel');
    Route::get('anet/cancel', 'Payment\AuthorizeController@cancelPayment')->name('membership.anet.cancel');
    Route::get('/offline/success', 'Front\CheckoutController@offlineSuccess')->name('membership.offline.success');
    Route::get('/trial/success', 'Front\CheckoutController@trialSuccess')->name('membership.trial.success');

    Route::get('/online/success', 'Vendor\VendorCheckoutController@onlineSuccess')->name('success.page');
  });

  // shipping-method route
  Route::get('/shipping-methods', 'Vendor\VendorController@methodSettings')->name('vendor.equipment_booking.settings.shipping_methods');

  Route::post('/update-method-settings', 'Vendor\VendorController@updateMethodSettings')->name('vendor.equipment_booking.settings.update_method_settings');

  Route::prefix('withdraw')->group(function () {
    Route::get('/', 'Vendor\VendorWithdrawController@index')->name('vendor.withdraw');
    Route::get('/create', 'Vendor\VendorWithdrawController@create')->name('vendor.withdraw.create');
    Route::get('/get-method/input/{id}', 'Vendor\VendorWithdrawController@get_inputs');

    Route::get('/balance-calculation/{method}/{amount}', 'Vendor\VendorWithdrawController@balance_calculation');

    Route::post('/send-request', 'Vendor\VendorWithdrawController@send_request')->name('vendor.withdraw.send-request');
    Route::post('/witdraw/bulk-delete', 'Vendor\VendorWithdrawController@bulkDelete')->name('vendor.witdraw.bulk_delete_withdraw');
    Route::post('/witdraw/delete', 'Vendor\VendorWithdrawController@Delete')->name('vendor.witdraw.delete_withdraw');
  });

  Route::get('/transcation', 'Vendor\VendorController@transcation')->name('vendor.transcation');
  Route::post('/transcation/delete', 'Vendor\VendorController@destroy')->name('vendor.transcation.delete');
  Route::post('/transcation/bulk-delete', 'Vendor\VendorController@bulk_destroy')->name('vendor.transcation.bulk_delete');

  #====support tickets ============
  Route::get('support/ticket/create', 'Vendor\SupportTicketController@create')->name('vendor.support_ticket.create');
  Route::post('support/ticket/store', 'Vendor\SupportTicketController@store')->name('vendor.support_ticket.store')->middleware('limitCheck:service,update,downgrade');
  Route::get('support/tickets', 'Vendor\SupportTicketController@index')->name('vendor.support_tickets');
  Route::get('support/message/{id}', 'Vendor\SupportTicketController@message')->name('vendor.support_tickets.message');
  Route::post('support-ticket/zip-upload', 'Vendor\SupportTicketController@zip_file_upload')->name('vendor.support_ticket.zip_file.upload');
  Route::post('support-ticket/reply/{id}', 'Vendor\SupportTicketController@ticketreply')->name('vendor.support_ticket.reply');

  Route::post('support-ticket/delete/{id}', 'Vendor\SupportTicketController@delete')->name('vendor.support_tickets.delete');




  //service managment route
  Route::prefix('service-management')->group(function () {
    Route::get('/', 'Vendor\Services\ServiceController@index')->name('vendor.service_managment');

    Route::get('create', 'Vendor\Services\ServiceController@create')->name('vendor.service_managment.create');
    Route::post('store', 'Vendor\Services\ServiceController@store')->name('vendor.service_managment.store')->middleware('limitCheck:service,store');


    //service slider image
    Route::post('/img-store', 'Vendor\Services\ServiceController@imagesstore')->name('vendor.service.imagesstore');
    Route::post('/img-remove', 'Vendor\Services\ServiceController@removeImage')->name('vendor.service.imagermv');
    Route::post('/img-db-remove', 'Vendor\Services\ServiceController@imagedbrmv')->name('vendor.service.imgdbrmv');
    Route::get('delete/slider/image', 'Vendor\Services\ServiceController@deleteSliderImage')->name('vendor.service.slider.delete');

    Route::get('edit/{id}', 'Vendor\Services\ServiceController@edit')->name('vendor.service_managment.edit');

    Route::post('update/{id}', 'Vendor\Services\ServiceController@update')->name('vendor.service_managment.update')->middleware('limitCheck:service,update');

    Route::post('delete/{id}', 'Vendor\Services\ServiceController@destroy')->name('vendor.service_managment.delete_product');

    Route::post('/bulk-delete-services', 'Vendor\Services\ServiceController@bulkDestroy')->name('vendor.service_managment.bulk_delete');

    Route::post('service-status', 'Vendor\Services\ServiceController@servicestatus')->name('vendor.service.status.change')->middleware('limitCheck:service,update,downgrade');

    //featured service payment success message
    Route::get('/online/success', 'Vendor\Services\ServiceController@onlineSuccess')->name('featured.service.online.success.page');

    Route::get('/offline/success', 'Vendor\Services\ServiceController@offlineSuccess')->name('featured.service.offline.success.page');

    Route::get('featured/payment/cancel', 'Vendor\ServicePromotion\ServicePromotionController@cancel')->name('vendor.featured.cancel');
  });

  //service promotion
  Route::prefix('payment/process')->group(function () {
    Route::post('/', 'Vendor\ServicePromotion\ServicePromotionController@index')->name('vendor.service.payment');

    Route::get('/paypal/payment/notify', 'Vendor\ServicePromotion\Payment\PayPalController@notify')->name('vendor.featured.paypal.notify');

    Route::get('/flutterwave/payment/notify', 'Vendor\ServicePromotion\Payment\FlutterwaveController@notify')->name('vendor.featured.flutterwave.notify');

    Route::post('/razorpay/payment/notify', 'Vendor\ServicePromotion\Payment\RazorpayController@notify')->name('vendor.featured.razorpay.notify');

    Route::get('/mollie/payment/notify', 'Vendor\ServicePromotion\Payment\MollieController@notify')->name('vendor.featured.mollie.notify');

    Route::get('/instamojo/payment/notify', 'Vendor\ServicePromotion\Payment\InstamojoController@notify')->name('vendor.featured.instamojo.notify');

    Route::get('/mercadopago/payment/notify', 'Vendor\ServicePromotion\Payment\MercadoPagoController@notify')->name('vendor.featured.mercadopago.notify');

    Route::get('/paystack/payment/notify', 'Vendor\ServicePromotion\Payment\PaystackController@notify')->name('vendor.featured.paystack.notify');

    Route::post('/paytm/payment/notify', 'Vendor\ServicePromotion\Payment\PaytmController@notify')->name('vendor.featured.paytm.notify');
  });

  //Staff Managment Route
  Route::prefix('staff-managment')->group(function () {
    Route::get('/', 'Vendor\Staff\StaffController@index')->name('vendor.staff_managment');
    Route::get('create', 'Vendor\Staff\StaffController@create')->name('vendor.staff_managment.create');
    Route::post('store', 'Vendor\Staff\StaffController@store')->name('vendor.staff_managment.store')->middleware('limitCheck:staff,store');
    Route::get('edit/{id}', 'Vendor\Staff\StaffController@edit')->name('vendor.staff_managment.edit');
    Route::post('update/{id}', 'Vendor\Staff\StaffController@update')->name('vendor.staff_managment.update')->middleware('limitCheck:staff,update');
    Route::delete('delete/{id}', 'Vendor\Staff\StaffController@destroy')->name('vendor.staff_managment.delete');
    Route::post('staff/bulkDestroy', 'Vendor\Staff\StaffController@bulkDestroy')->name('vendor.staff_managment.bulkDestroy');
    Route::post('staff-status', 'Vendor\Staff\StaffController@staffstatus')->name('vendor.status.change')->middleware('limitCheck:service,update,downgrade');
    Route::get('/secret-login/{id}', 'Vendor\Staff\StaffController@secret_login')->name('vendor.staff.secret-login');
    Route::get('/permission/{id}', 'Vendor\Staff\StaffController@permission')->name('vendor.staff.permission');
    Route::post('/permission-update/{id}', 'Vendor\Staff\StaffController@permissionUpdate')->name('vendor.staff.permission_update');
    Route::get('/change-password/{id}', 'Vendor\Staff\StaffController@changePassword')->name('vendor.staff.change_password');
    Route::post('/update-password/{id}', 'Vendor\Staff\StaffController@updatePassword')->name('vendor.staff.update_password');

    //staff time slot route
    Route::prefix('staff')->group(function () {
      Route::get('/days/{staff_id}', 'Vendor\Staff\StaffServiceHourController@day')->name('vendor.service.day');

      Route::get('/time-slots', 'Vendor\Staff\StaffServiceHourController@index')->name('vendor.time-slot.manage');

      Route::post('/time-slots/store', 'Vendor\Staff\StaffServiceHourController@store')->name('vendor.service-hour.store')->middleware('limitCheck:service,update');

      Route::post('/time-slots/update', 'Vendor\Staff\StaffServiceHourController@update')->name('vendor.service-hour.update')->middleware('limitCheck:service,update');

      Route::post('/time-slots/destroy/{id}', 'Vendor\Staff\StaffServiceHourController@destroy')->name('vendor.service-houre.destroy');

      Route::post('/time-slots/bulk-delete', 'Vendor\Staff\StaffServiceHourController@bulkDestroy')->name('vendor.service-hour.bulk_delete');

      Route::post('change-weekend/{id}', 'Vendor\Staff\StaffServiceHourController@weekendChange')->name('vendor.staff.change.weekend')->middleware('limitCheck:service,update,downgrade');
    });

    //staff holiday route
    Route::prefix('staff-holiday')->group(function () {
      Route::get('index/{id}', 'Vendor\Staff\StaffHolidayController@index')->name('vendor.staff.holiday.index');

      Route::post('customize/status/change/{id}', 'Vendor\Staff\StaffHolidayController@changeStaffSetting')->name('vendor.customize.status.change')->middleware('limitCheck:service,update,downgrade');

      Route::post('store', 'Vendor\Staff\StaffHolidayController@store')->name('vendor.staff.holiday.store')->middleware('limitCheck:service,update');

      Route::post('delete/{id}', 'Vendor\Staff\StaffHolidayController@destroy')->name('vendor.staff.holiday.destroy');

      Route::post('bulk-delete', 'Vendor\Staff\StaffHolidayController@blukDestroy')->name('vendor.staff.holiday.bulkdestroy');
    });
  });




  //Staff  Service Assign Route
  Route::prefix('staff-services-managment')->group(function () {
    Route::get('/{id}', 'Vendor\Staff\StaffServiceController@index')->name('vendor.staff_service_assign');
    Route::post('store', 'Vendor\Staff\StaffServiceController@store')->name('vendor.staff_service_assign.store')->middleware('limitCheck:service,update');
    Route::get('get-service-category/{id}', 'Vendor\Staff\StaffServiceController@getServiceCategory')->name('vendor.staff.service_category');
    Route::post('delete/{id}', 'Vendor\Staff\StaffServiceController@destroy')->name('vendor.staff_service_assign.delete');
    Route::post('bulk-delete', 'Vendor\Staff\StaffServiceController@blukDestroy')->name('vendor.staff_service_assign.blukDestroy');
  });


  //vendor schedule route
  Route::prefix('schedule')->group(function () {
    Route::get('/days', 'Vendor\Staff\StaffGlobalDayController@index')->name('vendor.staff.global.day');
    Route::post('weekend-change/{id}', 'Vendor\Staff\StaffGlobalDayController@weekendChange')->name('vendor.weekend.change')->middleware('limitCheck:service,update,downgrade');

    //time slot route
    Route::prefix('days/time-slots')->group(function () {
      Route::get('/', 'Vendor\Staff\StaffGlobalHourController@serviceHour')->name('vendor.global.time-slot.manage');
      Route::post('/time-store', 'Vendor\Staff\StaffGlobalHourController@store')->name('vendor.global.time-slot.store')->middleware('limitCheck:service,update');
      Route::post('/time-update', 'Vendor\Staff\StaffGlobalHourController@update')->name('vendor.global.time-slot.update')->middleware('limitCheck:service,update');
      Route::post('/destroy/{id}', 'Vendor\Staff\StaffGlobalHourController@destroy')->name('vendor.global.time-slot.destroy');
      Route::post('/bulk-delete', 'Vendor\Staff\StaffGlobalHourController@bulkDestroy')->name('vendor.global.time-slot.bulk_delete');
    });

    //holiday route
    Route::prefix('/holiday')->group(function () {
      Route::get('/', 'Vendor\Staff\GlobalHolidayController@index')->name('vendor.global.holiday');
      Route::post('/store', 'Vendor\Staff\GlobalHolidayController@store')->name('vendor.global.holiday.store')->middleware('limitCheck:service,update');
      Route::post('/delete/{id}', 'Vendor\Staff\GlobalHolidayController@destroy')->name('vendor.global.holiday.delete');
      Route::post('/bulke-destory', 'Vendor\Staff\GlobalHolidayController@blukDestroy')->name('vendor.global.holiday.bluk-destroy');
    });
  });

  //transaction
  Route::get('transcation', 'Vendor\TransactionController@index')->name('vendor.transaction');



  //service booking managment route start
  Route::prefix('appointment/')->group(function () {

    Route::get('all-appointments', 'Vendor\AppointmentController@index')->name('vendor.all_appointment');

    Route::get('pending-appointments', 'Vendor\AppointmentController@pendingAppointment')->name('vendor.pending_appointment');

    Route::get('accepted-appointments', 'Vendor\AppointmentController@acceptedAppointment')->name('vendor.accepted_appointment');

    Route::get('rejected-appointments', 'Vendor\AppointmentController@rejectedAppointment')->name('vendor.rejected_appointment');

    Route::post('update/appointment-status/{id}', 'Vendor\AppointmentController@updateAppointmentStatus')->name('vendor.appointment.update_status');

    Route::post('staff/assign', 'Vendor\AppointmentController@staffAssign')->name('vendor.appointment.staff_assign');

    Route::get('details/{id}', 'Vendor\AppointmentController@show')->name('vendor.appointment.details');

    Route::post('delete/{id}', 'Vendor\AppointmentController@destroy')->name('vendor.appointment.delete');

    Route::post('bulk-destroy', 'Vendor\AppointmentController@bulkDestroy')->name('vendor.appointment.bulk-destroy');
  });

  Route::prefix('withdraw')->group(function () {
    Route::get('/', 'Vendor\VendorWithdrawController@index')->name('vendor.withdraw');
    Route::get('/create', 'Vendor\VendorWithdrawController@create')->name('vendor.withdraw.create');
    Route::get('/get-method/input/{id}', 'Vendor\VendorWithdrawController@get_inputs');

    Route::get('/balance-calculation/{method}/{amount}', 'Vendor\VendorWithdrawController@balance_calculation');

    Route::post('/send-request', 'Vendor\VendorWithdrawController@send_request')->name('vendor.withdraw.send-request')->middleware('limitCheck:service,update');
    Route::post('/witdraw/bulk-delete', 'Vendor\VendorWithdrawController@bulkDelete')->name('vendor.witdraw.bulk_delete_withdraw');
    Route::post('/witdraw/delete', 'Vendor\VendorWithdrawController@Delete')->name('vendor.witdraw.delete_withdraw');
  });
  //recived email update and show
  Route::prefix('recevied')->group(function () {

    Route::get('email', 'Vendor\RecivedEmailController@mailToAdmin')->name('vendor.email.index');
    Route::post('update/email', 'Vendor\RecivedEmailController@updateMailToAdmin')->name('vendor.email.update')->middleware('limitCheck:service,update,downgrade');
  });

  //plugins
  Route::prefix('plugins')->middleware('limitCheck:service,update,downgrade')->group(function () {
    Route::get('', 'Vendor\PluginController@index')->name('vendor.plugins.index')->withoutMiddleware('limitCheck:service,update,downgrade');
    Route::post('/zoom/store', 'Vendor\PluginController@zoomUpdate')->name('vendor.plugins.zoom.store');
    Route::post('/update-google-calendar', 'Vendor\PluginController@updateCalendar')->name('vendor.update_google_calendar');
  });

  //zoome meeting create
  Route::post('/frontend/zoom/meetings', 'Vendor\Staff\ZoomController@createMeeting')->name('zoom.meetings.create');
  Route::post('/staff/zoom/token', 'Vendor\Staff\ZoomController@getZoomAccessToken')->name('zoom.token.create');

  //service-inquiry route
  Route::get('service-inquiry', 'Vendor\RecivedEmailController@message')->name('vendor.booking.inquiry');

  Route::post(
    'reviced/message/delete/{id}',
    'Vendor\RecivedEmailController@messageDestroy'
  )->name('vendor.booking.inquiry.destory');

  Route::post('bulk_delete', 'Vendor\RecivedEmailController@bulkDelete')->name('vendor.booking.inquiry.bulk_delete');
});
