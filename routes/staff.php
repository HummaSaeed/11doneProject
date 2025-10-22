<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| staff Interface Routes
|--------------------------------------------------------------------------
*/
//========== staff login =========
Route::prefix('staff')->group(function () {
  Route::get('login', 'Staff\StaffController@login')->name('staff.login');
  Route::post('login_submit', 'Staff\StaffController@loginSubmit')->name('staff.login_submit');
});
Route::prefix('staff')->middleware('auth:staff', 'staffCheck')->group(function () {
  Route::get('dashboard', 'Staff\StaffController@index')->name('staff.dashboard');
  Route::post('/change-theme', 'Staff\StaffController@changeTheme')->name('staff.change_theme');
  Route::get('logout', 'Staff\StaffController@logout')->name('staff.logout');
  Route::get('/change-password', 'Staff\StaffController@change_password')->name('staff.change_password');
  Route::post('/update-password', 'Staff\StaffController@updated_password')->name('staff.update_password');
  Route::get('/edit-profile', 'Staff\StaffController@edit_profile')->name('staff.edit.profile');
  Route::post('/profile/update/{id}', 'Staff\StaffController@update_profile')->name('staff.update_profile');


  //staff schedule route
  Route::prefix('schedule')->group(function () {
    Route::get('/days', 'Staff\StaffDayHourController@day')->name('staff.time-slot');
    Route::post('customize/status/change/{id}', 'Staff\StaffDayHourController@changeStaffSetting')->name('staff.customize.status.change')->middleware('limitCheck:service,update,staff_downgrade');
    Route::post('weekend-change/{id}', 'Staff\StaffDayHourController@weekendChange')->name('staff.weekend.change')->middleware('limitCheck:service,update,staff_downgrade');

    //time slot route
    Route::prefix('days/time-slots')->group(function () {
      Route::get('/', 'Staff\StaffDayHourController@hour')->name('staff.hour.manage');
      Route::post('/store', 'Staff\StaffDayHourController@store')->name('staff.hour.store')->middleware('limitCheck:service,update,staff_downgrade_js');
      Route::post('/update', 'Staff\StaffDayHourController@update')->name('staff.hour.update')->middleware('limitCheck:service,update,staff_downgrade_js');
      Route::post('/destroy/{id}', 'Staff\StaffDayHourController@destroy')->name('staff.hour.destroy');
      Route::post('/bulk-delete-hour', 'Staff\StaffDayHourController@bulkDestroy')->name('staff.hour.bulk_delete');
    });
  });









  //service managment route
  Route::prefix('service-management')->group(function () {
    Route::get('/', 'Staff\ServiceController@index')->name('staff.service_managment');

    Route::get('create', 'Staff\ServiceController@create')->name('staff.service_managment.create');
    Route::post('store', 'Staff\ServiceController@store')->name('staff.service_managment.store')->middleware('limitCheck:service,update,staff_downgrade_js');


    // //service slider image
    Route::post('/img-store', 'Staff\ServiceController@imagesstore')->name('staff.service.imagesstore');
    Route::post('/img-remove', 'Staff\ServiceController@removeImage')->name('staff.service.imagermv');
    Route::post('/img-db-remove', 'Staff\ServiceController@imagedbrmv')->name('staff.service.imgdbrmv');
    Route::get('delete/slider/image', 'Staff\ServiceController@deleteSliderImage')->name('staff.service.slider.delete');

    Route::get('edit/{id}', 'Staff\ServiceController@edit')->name('staff.service_managment.edit');

    Route::post('update/{id}', 'Staff\ServiceController@update')->name('staff.service_managment.update')->middleware('limitCheck:service,update,staff_downgrade_js');

    Route::post('service-status', 'Staff\ServiceController@servicestatus')->name('staff.service.status.change')->middleware('limitCheck:service,update,staff_downgrade');

    Route::post('delete/{id}', 'Staff\ServiceController@destroy')->name('staff.service_managment.delete_product');

    Route::post('/bulk-delete-services', 'Staff\ServiceController@bulkDestroy')->name('staff.service_managment.bulk_delete');
  });


  //appointment managment
  Route::prefix('appointment/')->group(function () {
    Route::get('/', 'Staff\AppointmentController@index')->name('staff.appointment');
    Route::get('pending-appointments', 'Staff\AppointmentController@pendingAppointment')->name('staff.pending_appointment');

    Route::get('accepted-appointments', 'Staff\AppointmentController@acceptedAppointment')->name('staff.accepted_appointment');

    Route::get('rejected-appointments', 'Staff\AppointmentController@rejectedAppointment')->name('staff.rejected_appointment');

    Route::get('/details/{id}', 'Staff\AppointmentController@show')->name('staff.appointment.details');
  });

  //plugins
  Route::prefix('plugins')->middleware('limitCheck:service,update,staff_downgrade')->group(function () {
    Route::get('', 'Staff\PluginController@index')->name('staff.plugins.index')->withoutMiddleware('limitCheck:service,update,staff_downgrade');
    Route::post('/update-google-calendar', 'Staff\PluginController@updateCalendar')->name('staff.update_google_calendar');
  });

  //message from customer
  Route::get('service-inquiry', 'Staff\ServiceInqueryController@message')->name('staff.service_inquery.message');

  Route::post(
    'service-inquiry/delete/{id}',
    'Staff\ServiceInqueryController.php@messageDestroy'
  )->name('staff.service_inquery.message.destory');

  Route::post('bulk_delete', 'Staff\ServiceInqueryController@bulkDelete')->name('staff.service_inquery.message.bulk_delete');
});
