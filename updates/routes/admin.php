<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
*/



Route::prefix('/admin')->middleware('auth:admin')->group(function () {
  // admin redirect to dashboard route
  Route::get('/dashboard', 'Admin\AdminController@redirectToDashboard')->name('admin.dashboard');
  Route::get('/membership-request', 'Admin\AdminController@membershipRequest')->name('admin.membership-request');
  // change admin-panel theme (dark/light) route
  Route::get('/change-theme', 'Admin\AdminController@changeTheme')->name('admin.change_theme');

  // admin profile settings route start
  Route::get('/edit-profile', 'Admin\AdminController@editProfile')->name('admin.edit_profile');

  Route::post('/update-profile', 'Admin\AdminController@updateProfile')->name('admin.update_profile');

  Route::get('/change-password', 'Admin\AdminController@changePassword')->name('admin.change_password');

  Route::post('/update-password', 'Admin\AdminController@updatePassword')->name('admin.update_password');
  // admin profile settings route end

  // admin logout attempt route
  Route::get('/logout', 'Admin\AdminController@logout')->name('admin.logout');

  Route::get('/monthly-earning', 'Admin\AdminController@monthly_earning')->name('admin.monthly_earning');

  Route::get('/monthly-profit', 'Admin\AdminController@monthly_profit')->name('admin.monthly_profit');


  // menu-builder route
  Route::prefix('/menu-builder')->middleware('permission:Menu Builder')->group(function () {
    Route::get('', 'Admin\MenuBuilderController@index')->name('admin.menu_builder');

    Route::post('/update-menus', 'Admin\MenuBuilderController@update')->name('admin.menu_builder.update_menus');
  });

  // admin management route
  Route::prefix('/admin-management')->middleware('permission:Admin Management')->group(function () {
    // role-permission route
    Route::get('/role-permissions', 'Admin\Administrator\RolePermissionController@index')->name('admin.admin_management.role_permissions');

    Route::post('/store-role', 'Admin\Administrator\RolePermissionController@store')->name('admin.admin_management.store_role');

    Route::get(
      '/role/{id}/permissions',
      'Admin\Administrator\RolePermissionController@permissions'
    )->name('admin.admin_management.role.permissions');

    Route::post('/role/{id}/update-permissions', 'Admin\Administrator\RolePermissionController@updatePermissions')->name('admin.admin_management.role.update_permissions');

    Route::post('/update-role', 'Admin\Administrator\RolePermissionController@update')->name('admin.admin_management.update_role');

    Route::post('/delete-role/{id}', 'Admin\Administrator\RolePermissionController@destroy')->name('admin.admin_management.delete_role');

    // registered admin route
    Route::get('/registered-admins', 'Admin\Administrator\SiteAdminController@index')->name('admin.admin_management.registered_admins');

    Route::post('/store-admin', 'Admin\Administrator\SiteAdminController@store')->name('admin.admin_management.store_admin');

    Route::post('/update-status/{id}', 'Admin\Administrator\SiteAdminController@updateStatus')->name('admin.admin_management.update_status');

    Route::post('/update-admin', 'Admin\Administrator\SiteAdminController@update')->name('admin.admin_management.update_admin');

    Route::post('/delete-admin/{id}', 'Admin\Administrator\SiteAdminController@destroy')->name('admin.admin_management.delete_admin');
  });


  //staff management Route
  Route::prefix('staff-managment')->middleware('permission:Staff Managment')->group(function () {
    Route::get('/', 'Admin\Staff\StaffController@index')->name('admin.staff_managment');
    Route::get('create', 'Admin\Staff\StaffController@create')->name('admin.staff_managment.create');
    Route::get('check/package', 'Admin\Staff\StaffController@checkPackge')->name('admin.staff_managment.check_package');
    Route::post('store', 'Admin\Staff\StaffController@store')->name('admin.staff_managment.store');
    Route::get('edit/{id}', 'Admin\Staff\StaffController@edit')->name('admin.staff_managment.edit');
    Route::post('update/{id}', 'Admin\Staff\StaffController@update')->name('admin.staff_managment.update');
    Route::post('delete/{id}', 'Admin\Staff\StaffController@destroy')->name('admin.staff_managment.delete');
    Route::post('staff/bulkDestroy', 'Admin\Staff\StaffController@bulkDestroy')->name('admin.staff_managment.bulkDestroy');
    Route::post('staff-status', 'Admin\Staff\StaffController@staffstatus')->name('admin.status.change');
    Route::get('/secret-login/{id}', 'Admin\Staff\StaffController@secret_login')->name('admin.staff.secret-login');
    Route::get('/permission/{id}', 'Admin\Staff\StaffController@permission')->name('admin.staff.permission');
    Route::post('/permission-update/{id}', 'Admin\Staff\StaffController@permissionUpdate')->name('admin.staff.permission_update');
    Route::get('/change-password/{id}', 'Admin\Staff\StaffController@changePassword')->name('admin.staff.change_password');
    Route::post('/update-password/{id}', 'Admin\Staff\StaffController@updatePassword')->name('admin.staff.update_password');


    //Staff Time slots route
    Route::prefix('staff')->group(function () {
      Route::get('/days/{staff_id}', 'Admin\Staff\StaffServiceHourController@day')->name('admin.service.day');
      Route::get('/time-slots', 'Admin\Staff\StaffServiceHourController@index')->name('admin.time-slot.manage');
      Route::post('/time-slots/store', 'Admin\Staff\StaffServiceHourController@store')->name('admin.service-hour.store');
      Route::post('/time-slots/update', 'Admin\Staff\StaffServiceHourController@update')->name('admin.service-hour.update');
      Route::post('/time-slots/destroy/{id}', 'Admin\Staff\StaffServiceHourController@destroy')->name('admin.service-houre.destroy');
      Route::post('/time-slots/bulk-delete', 'Admin\Staff\StaffServiceHourController@bulkDestroy')->name('admin.service-hour.bulk_delete');
      Route::post('change-weekend/{id}', 'Admin\Staff\StaffServiceHourController@weekendChange')->name('admin.staff.change.weekend');
    });

    //Staff Holiday Route
    Route::prefix('staff-holiday')->group(function () {
      Route::get('index/{id}', 'Admin\Staff\StaffHolidayController@index')->name('admin.staff.holiday.index');
      Route::post('customize/status/change/{id}', 'Admin\Staff\StaffHolidayController@changeStaffSetting')->name('admin.customize.status.change');
      Route::post('store', 'Admin\Staff\StaffHolidayController@store')->name('admin.staff.holiday.store');
      Route::post('delete/{id}', 'Admin\Staff\StaffHolidayController@destroy')->name('admin.staff.holiday.destroy');
      Route::post('bulk-delete', 'Admin\Staff\StaffHolidayController@blukDestroy')->name('admin.staff.holiday.bulkdestroy');
    });

    //staff service assign route
    Route::prefix('staff-services-managment')->group(function () {
      Route::get('/{id}', 'Admin\Staff\StaffServiceController@index')->name('admin.staff_service_assign');
      Route::post('store', 'Admin\Staff\StaffServiceController@store')->name('admin.staff_service_assign.store');

      Route::post('delete/{id}', 'Admin\Staff\StaffServiceController@destroy')->name('admin.staff_service_assign.delete');

      Route::post('/bulk-delete-services', 'Admin\Staff\StaffServiceController@bulkDestroy')->name('admin.staff_service_assign.bulk_delete');
    });
  });

  //admin or vendor schedule route
  Route::prefix('schedule')->middleware('permission:Schedule')->group(function () {
    //settings route
    Route::get('/settings/time-format', 'Admin\BasicSettings\BasicController@timeFormate')->name('admin.time-formate');
    Route::post('/settings/time-format/update', 'Admin\BasicSettings\BasicController@timeFormateUpdate')->name('admin.time-formate.update');

    //days route
    Route::prefix('days')->group(function () {
      Route::get('/', 'Admin\Staff\StaffGlobalDayController@index')->name('admin.staff.global.day');
      Route::post('weekend-change/{id}', 'Admin\Staff\StaffGlobalDayController@weekendChange')->name('admin.weekend.change');
      Route::get('vendor/days', 'Admin\Staff\StaffGlobalDayController@vendorDays')->name('admin.vendor.days');

      //time slots route
      Route::prefix('time-slots')->group(function () {
        Route::get('/', 'Admin\Staff\StaffGlobalHourController@serviceHour')->name('admin.global.time-slot.manage');
        Route::post('/time-store', 'Admin\Staff\StaffGlobalHourController@store')->name('admin.global.time-slot.store');
        Route::post('/time-update', 'Admin\Staff\StaffGlobalHourController@update')->name('admin.global.time-slot.update');
        Route::post('/destroy/{id}', 'Admin\Staff\StaffGlobalHourController@destroy')->name('admin.global.time-slot.destroy');
        Route::post('/bulk-delete', 'Admin\Staff\StaffGlobalHourController@bulkDestroy')->name('admin.global.time-slot.bulk_delete');
      });
    });

    // holiday route
    Route::prefix('holiday')->group(function () {
      Route::get('/', 'Admin\Staff\GlobalHolidayController@index')->name('admin.global.holiday');
      Route::post('/store', 'Admin\Staff\GlobalHolidayController@store')->name('admin.global.holiday.store');
      Route::post('/delete/{id}', 'Admin\Staff\GlobalHolidayController@destroy')->name('admin.global.holiday.delete');
      Route::post('/bulke-destory', 'Admin\Staff\GlobalHolidayController@blukDestroy')->name('admin.global.holiday.bluk-destroy');
    });
  });

  //appointment managment route start
  Route::prefix('appointments/')->middleware('permission:Appointments')->group(function () {

    Route::get('/all-appointments', 'Admin\Appointment\AppointmentController@index')->name('admin.all_appointment');

    Route::get('pending-appointments', 'Admin\Appointment\AppointmentController@pendingAppointment')->name('admin.pending_appointment');

    Route::get('accepted-appointments', 'Admin\Appointment\AppointmentController@acceptedAppointment')->name('admin.accepted_appointment');

    Route::get('rejected-appointments', 'Admin\Appointment\AppointmentController@rejectedAppointment')->name('admin.rejected_appointment');

    Route::post('/update/payment-status/{id}', 'Admin\Appointment\AppointmentController@updatePaymentStatus')->name('admin.appointment.update_payment_status');

    Route::post('/update/refund-status/{id}', 'Admin\Appointment\AppointmentController@updateRefundStatus')->name('admin.appointment.update_refund_status');

    Route::post('/update/appointment-status/{id}', 'Admin\Appointment\AppointmentController@updateAppointmentStatus')->name('admin.appointment.update_appointment_status');

    Route::post('/staff/assign', 'Admin\Appointment\AppointmentController@staffAssign')->name('admin.appointment.staff_assign');

    Route::get('/details/{id}', 'Admin\Appointment\AppointmentController@show')->name('admin.appointment.details');

    Route::post('/booking-info/delete/{id}', 'Admin\Appointment\AppointmentController@destroy')->name('admin.appointment.delete');

    Route::post('/bulk-destory', 'Admin\Appointment\AppointmentController@bulkDestroy')->name('admin.appointment.bulk-destory');
  });
  //withdraw managment start
  Route::prefix('withdraws')->middleware('permission:Withdraws')->group(function () {
    Route::get('payment-method', 'Admin\Withdraw\WithdrawController@index')->name('admin.withdrawal.index');
    Route::post('payment-method/store', 'Admin\Withdraw\WithdrawController@storePayment')->name('admin.withdrawal.store.payment');
    Route::post('payment-method/update', 'Admin\Withdraw\WithdrawController@updatePayment')->name('admin.withdrawal.update.payment');
    Route::post('payment-method/delete/{id}', 'Admin\Withdraw\WithdrawController@deletePayment')->name('admin.withdrawal.delete.payment');

    //payment input route
    Route::get('payment-method/input', 'Admin\Withdraw\WithdrawPaymentMethodInputController@index')->name('admin.withdraw_payment_method.mange_input');
    Route::post('/payment-method/input-store', 'Admin\Withdraw\WithdrawPaymentMethodInputController@store')->name('admin.withdraw_payment_method.store_input');
    Route::get('/payment-method/input-edit/{id}', 'Admin\Withdraw\WithdrawPaymentMethodInputController@edit')->name('admin.withdraw_payment_method.edit_input');
    Route::post('/payment-method/input-update', 'Admin\Withdraw\WithdrawPaymentMethodInputController@update')->name('admin.withdraw_payment_method.update_input');
    Route::post('/payment-method/order-update', 'Admin\Withdraw\WithdrawPaymentMethodInputController@order_update')->name('admin.withdraw_payment_method.order_update');
    Route::get('/payment-method/input-option/{id}', 'Admin\Withdraw\WithdrawPaymentMethodInputController@get_options')->name('admin.withdraw_payment_method.options');
    Route::post('/payment-method/input-delete', 'Admin\Withdraw\WithdrawPaymentMethodInputController@delete')->name('admin.withdraw_payment_method.options_delete');



    Route::get('/withdraw-request', 'Admin\Withdraw\WithdrawRequestController@index')->name('admin.withdraw.withdraw_request');
    Route::post('/withdraw-request/delete', 'Admin\Withdraw\WithdrawRequestController@delete')->name('admin.witdraw.delete_withdraw');
    Route::get('/withdraw-request/approve/{id}', 'Admin\Withdraw\WithdrawRequestController@approve')->name('admin.witdraw.approve_withdraw');

    Route::get('/withdraw-request/decline/{id}', 'Admin\Withdraw\WithdrawRequestController@decline')->name('admin.witdraw.decline_withdraw');
  });

  //transactions
  Route::get('transactions', 'Admin\Transaction\TransactionController@index')->name('admin.transaction')->middleware('permission:Transactions');


  //service managment start
  Route::prefix('service-managment')->middleware('permission:Service Managment')->group(function () {
    //categories
    Route::prefix('categories')->group(function () {

      Route::get('/', 'Admin\ServiceCategoryController@index')->name('admin.service_managment.category');

      Route::post('store', 'Admin\ServiceCategoryController@store')->name('admin.service_managment.category.store');

      Route::post('update', 'Admin\ServiceCategoryController@update')->name('admin.service_managment.category.update');

      Route::post('delete/{id}', 'Admin\ServiceCategoryController@destroy')->name('admin.service_managment.category.destory');

      Route::post('/bulk-delete-services_categories', 'Admin\ServiceCategoryController@bulkDestroy')->name('admin.service_managment.category.bulk_delete');
    });

    //services
    Route::get('/', 'Admin\AdminServiceController@index')->name('admin.service_managment');

    Route::get('select/vendor', 'Admin\AdminServiceController@vendorSelect')->name('admin.service_managment.vendor_select');

    Route::get('create', 'Admin\AdminServiceController@create')->name('admin.service_managment.create');

    //service promotion
    Route::post('payment/process/', 'Admin\AdminServiceController@featured')->name('admin.featured.payment');

    //service slider image
    Route::post('/img-store', 'Admin\AdminServiceController@imagesstore')->name('admin.service.imagesstore');
    Route::post('/img-remove', 'Admin\AdminServiceController@removeImage')->name('admin.service.imagermv');
    Route::post('/img-db-remove', 'Admin\AdminServiceController@imagedbrmv')->name('admin.service.imgdbrmv');
    Route::get('delete/slider/image', 'Admin\AdminServiceController@deleteSliderImage')->name('admin.service.slider.delete');

    Route::post('store', 'Admin\AdminServiceController@store')->name('admin.service_managment.store');

    Route::get('edit/{id}', 'Admin\AdminServiceController@edit')->name('admin.service_managment.edit');
    
    
    Route::post('sub-service/{service_contnet_id}/add', 'Admin\AdminServiceController@sub_service_add')->name('admin.service_managment.sub.add');

    Route::post('update/{id}', 'Admin\AdminServiceController@update')->name('admin.service_managment.update');

    Route::post('delete/{id}', 'Admin\AdminServiceController@destroy')->name('admin.service_managment.delete');
    
    
    Route::get('sub-service/delete/{service_id}/{sub_id}', 'Admin\AdminServiceController@subServiceDelete')->name('admin.service_managment.sub.delete');

    Route::post(
      '/bulk-delete-services',
      'Admin\AdminServiceController@bulkDestroy'
    )->name('admin.service_managment.bulk_delete');

    Route::post('service-status', 'Admin\AdminServiceController@servicestatus')->name('admin.service.status.change');

    //service inquery email
    Route::prefix('service-inquiry')->middleware('permission:Service Inquiry')->group(function () {
      Route::get('/', 'Admin\ServiceInqController@message')->name('admin.booking.inquiry');
      Route::post('/delete/{id}', 'Admin\ServiceInqController@messageDestroy')->name('admin.booking.inquiry.destory');
      Route::post('bulk_delete', 'Admin\ServiceInqController@bulkDelete')->name('admin.booking.inquiry.bulk_delete');
    });

    //featured service managment
    Route::prefix('featured-service')->middleware('permission:Featured Services')->group(function () {
      Route::get('charge', 'Admin\FeaturedService\FeaturedServiceController@charge')->name('admin.charge.index');

      Route::post('charge/store', 'Admin\FeaturedService\FeaturedServiceController@chargeStore')->name('admin.charge.store');

      Route::post('charge/update', 'Admin\FeaturedService\FeaturedServiceController@chargeUpdate')->name('admin.charge.update');

      Route::post('charge/delete/{id}', 'Admin\FeaturedService\FeaturedServiceController@destroy')->name('admin.charge.delete');

      Route::post('/delete/{id}', 'Admin\FeaturedService\FeaturedServiceController@deleteFeaturedService')->name('admin.featued-service.delete');

      Route::post('/bulk-destory', 'Admin\FeaturedService\FeaturedServiceController@bulkDestroyFeaturedService')->name('admin.featued-service.bulk-destory');

      Route::post('bulk-delete-charge', 'Admin\FeaturedService\FeaturedServiceController@bulkDestroy')->name('admin.charge.bulkdestroy');

      Route::get(
        'all',
        'Admin\FeaturedService\FeaturedServiceController@featuredService'
      )->name('admin.all-featured.service');

      Route::get('pending', 'Admin\FeaturedService\FeaturedServiceController@pendingFeaturedService')->name('admin.pending-featured.service');

      Route::get('approved', 'Admin\FeaturedService\FeaturedServiceController@apporvedFeaturedService')->name('admin.approved-featured.service');

      Route::get('rejected', 'Admin\FeaturedService\FeaturedServiceController@rejectFeaturedService')->name('admin.rejected-featured.service');

      Route::post('/update-payment-status/{id}', 'Admin\FeaturedService\FeaturedServiceController@updatePaymentStatus')->name('admin.featured_service.order.update_payment_status');

      Route::post('/update-order-status/{id}', 'Admin\FeaturedService\FeaturedServiceController@updateOrderStatus')->name('admin.featured_service.order.update_order_status');
    });
  });

  // subscription Log
  Route::get('/subscription-log', 'Admin\PaymentLogController@index')->name('admin.subscription-log.index');
  Route::post('/payment-log/update', 'Admin\PaymentLogController@update')->name('admin.payment-log.update');

  //package route
  Route::prefix('package')->group(function () {
    // Package Settings routes
    Route::get('/settings', 'Admin\PackageController@settings')->name('admin.package.settings');
    Route::post('/settings/update', 'Admin\PackageController@updateSettings')->name('admin.package.settings.update');
    // Package routes
    Route::get('packages', 'Admin\PackageController@index')->name('admin.package.index');
    Route::post('package/upload', 'Admin\PackageController@upload')->name('admin.package.upload');
    Route::post('package/store', 'Admin\PackageController@store')->name('admin.package.store');
    Route::get('package/{id}/edit', 'Admin\PackageController@edit')->name('admin.package.edit');
    Route::post('package/update', 'Admin\PackageController@update')->name('admin.package.update');
    Route::post('package/{id}/uploadUpdate', 'Admin\PackageController@uploadUpdate')->name('admin.package.uploadUpdate');
    Route::post('package/delete', 'Admin\PackageController@delete')->name('admin.package.delete');
    Route::post('package/bulk-delete', 'Admin\PackageController@bulkDelete')->name('admin.package.bulk.delete');
  });


  // shop managment route
  Route::prefix('/shop-management')->middleware('permission:Shop Management')->group(function () {
    // tax route
    Route::get('/tax-amount', 'Admin\BasicSettings\BasicController@productTaxAmount')->name('admin.shop_management.tax_amount');

    Route::post('/update-tax-amount', 'Admin\BasicSettings\BasicController@updateProductTaxAmount')->name('admin.shop_management.update_tax_amount');

    Route::get('/settings', 'Admin\BasicSettings\BasicController@settings')->name('admin.shop_management.settings');

    Route::post('/update-settings', 'Admin\BasicSettings\BasicController@updateSettings')->name('admin.shop_management.update_settings');

    // shipping charge route
    Route::get('/shipping-charges', 'Admin\Shop\ShippingChargeController@index')->name('admin.shop_management.shipping_charges');

    Route::post('/store-charge', 'Admin\Shop\ShippingChargeController@store')->name('admin.shop_management.store_charge');

    Route::post('/update-charge', 'Admin\Shop\ShippingChargeController@update')->name('admin.shop_management.update_charge');

    Route::post('/delete-charge/{id}', 'Admin\Shop\ShippingChargeController@destroy')->name('admin.shop_management.delete_charge');

    // coupon route
    Route::get('/coupons', 'Admin\Shop\CouponController@index')->name('admin.shop_management.coupons');

    Route::post('/store-coupon', 'Admin\Shop\CouponController@store')->name('admin.shop_management.store_coupon');

    Route::post('/update-coupon', 'Admin\Shop\CouponController@update')->name('admin.shop_management.update_coupon');

    Route::post('/delete-coupon/{id}', 'Admin\Shop\CouponController@destroy')->name('admin.shop_management.delete_coupon');

    // product category route
    Route::prefix('/product')->group(function () {
      Route::get('/categories', 'Admin\Shop\CategoryController@index')->name('admin.shop_management.product.categories');

      Route::post('/store-category', 'Admin\Shop\CategoryController@store')->name('admin.shop_management.product.store_category');

      Route::post('/update-category', 'Admin\Shop\CategoryController@update')->name('admin.shop_management.product.update_category');

      Route::post(
        '/delete-category/{id}',
        'Admin\Shop\CategoryController@destroy'
      )->name('admin.shop_management.product.delete_category');

      Route::post(
        '/bulk-delete-category',
        'Admin\Shop\CategoryController@bulkDestroy'
      )->name('admin.shop_management.product.bulk_delete_category');
    });

    // product route
    Route::get('/products', 'Admin\Shop\ProductController@index')->name('admin.shop_management.products');

    Route::get('/select-product-type', 'Admin\Shop\ProductController@productType')->name('admin.shop_management.select_product_type');

    Route::get(
      '/create-product/{type}',
      'Admin\Shop\ProductController@create'
    )->name('admin.shop_management.create_product');

    Route::post('/upload-slider-image', 'Admin\Shop\ProductController@uploadImage')->name('admin.shop_management.upload_slider_image');

    Route::post('/remove-slider-image', 'Admin\Shop\ProductController@removeImage')->name('admin.shop_management.remove_slider_image');

    Route::post('/store-product', 'Admin\Shop\ProductController@store')->name('admin.shop_management.store_product');

    Route::post('/product/{id}/update-featured-status', 'Admin\Shop\ProductController@updateFeaturedStatus')->name('admin.shop_management.product.update_featured_status');

    Route::get(
      '/edit-product/{id}/{type}',
      'Admin\Shop\ProductController@edit'
    )->name('admin.shop_management.edit_product');

    Route::post('/detach-slider-image', 'Admin\Shop\ProductController@detachImage')->name('admin.shop_management.detach_slider_image');

    Route::post('/update-product/{id}', 'Admin\Shop\ProductController@update')->name('admin.shop_management.update_product');

    Route::post('/delete-product/{id}', 'Admin\Shop\ProductController@destroy')->name('admin.shop_management.delete_product');

    Route::post('/bulk-delete-product', 'Admin\Shop\ProductController@bulkDestroy')->name('admin.shop_management.bulk_delete_product');

    // order route
    Route::get('/orders', 'Admin\Shop\OrderController@orders')->name('admin.shop_management.orders');

    Route::prefix('/order/{id}')->group(function () {
      Route::post('/update-payment-status', 'Admin\Shop\OrderController@updatePaymentStatus')->name('admin.shop_management.order.update_payment_status');

      Route::post('/update-order-status', 'Admin\Shop\OrderController@updateOrderStatus')->name('admin.shop_management.order.update_order_status');

      Route::get('/details', 'Admin\Shop\OrderController@show')->name('admin.shop_management.order.details');

      Route::post('/delete', 'Admin\Shop\OrderController@destroy')->name('admin.shop_management.order.delete');
    });

    Route::post('/bulk-delete-order', 'Admin\Shop\OrderController@bulkDestroy')->name('admin.shop_management.bulk_delete_order');

    // report route
    Route::get('/report', 'Admin\Shop\OrderController@report')->name('admin.shop_management.report');

    Route::get('/export-report', 'Admin\Shop\OrderController@exportReport')->name('admin.shop_management.export_report');
  });

  // user management route
  Route::prefix('/user-management')->middleware('permission:User Management')->group(function () {
    // registered user route
    Route::get('/registered-users', 'Admin\User\UserController@index')->name('admin.user_management.registered_users');

    Route::get('/create', 'Admin\User\UserController@create')->name('admin.user_management.registered_user.create');
    Route::post('/store', 'Admin\User\UserController@store')->name('admin.user_management.registered_user.store');

    Route::prefix('/user/{id}')->group(function () {

      Route::get('/edit', 'Admin\User\UserController@edit')->name('admin.user_management.registered_user.edit');
      Route::post('/update', 'Admin\User\UserController@update')->name('admin.user_management.registered_user.update');

      Route::post('/update-account-status', 'Admin\User\UserController@updateAccountStatus')->name('admin.user_management.user.update_account_status');

      Route::post('/update-email-status', 'Admin\User\UserController@updateEmailStatus')->name('admin.user_management.user.update_email_status');

      Route::get('/change-password', 'Admin\User\UserController@changePassword')->name('admin.user_management.user.change_password');

      Route::post('/update-password', 'Admin\User\UserController@updatePassword')->name('admin.user_management.user.update_password');

      Route::post('/delete', 'Admin\User\UserController@destroy')->name('admin.user_management.user.delete');
      Route::get('/secret-login', 'Admin\User\UserController@secret_login')->name('admin.user_management.user.secret-login');
    });

    Route::post('/bulk-delete-user', 'Admin\User\UserController@bulkDestroy')->name('admin.user_management.bulk_delete_user');

    // subscriber route
    Route::get('/subscribers', 'Admin\User\SubscriberController@index')->name('admin.user_management.subscribers');

    Route::post('/subscriber/{id}/delete', 'Admin\User\SubscriberController@destroy')->name('admin.user_management.subscriber.delete');

    Route::post(
      '/bulk-delete-subscriber',
      'Admin\User\SubscriberController@bulkDestroy'
    )->name('admin.user_management.bulk_delete_subscriber');

    Route::get('/mail-for-subscribers', 'Admin\User\SubscriberController@writeEmail')->name('admin.user_management.mail_for_subscribers');

    Route::post(
      '/subscribers/send-email',
      'Admin\User\SubscriberController@prepareEmail'
    )->name('admin.user_management.subscribers.send_email');
  });


  // vendor management route
  Route::prefix('/vendor-management')->middleware('permission:User Management')->group(function () {
    Route::get('/settings', 'Admin\VendorManagementController@settings')->name('admin.vendor_management.settings');
    Route::post('/settings/update', 'Admin\VendorManagementController@update_setting')->name('admin.vendor_management.setting.update');

    Route::get('/add-vendor', 'Admin\VendorManagementController@add')->name('admin.vendor_management.add_vendor');
    Route::post('/save-vendor', 'Admin\VendorManagementController@create')->name('admin.vendor_management.save-vendor');

    Route::get('/registered-vendors', 'Admin\VendorManagementController@index')->name('admin.vendor_management.registered_vendor');

    Route::prefix('/vendor/{id}')->group(function () {

      Route::post(
        '/update-account-status',
        'Admin\VendorManagementController@updateAccountStatus'
      )->name('admin.vendor_management.vendor.update_account_status');

      Route::post('/update-featured-status', 'Admin\VendorManagementController@updateFeaturedStatus')->name('admin.vendor_management.vendor.update_featured_status');

      Route::post(
        '/update-email-status',
        'Admin\VendorManagementController@updateEmailStatus'
      )->name('admin.vendor_management.vendor.update_email_status');

      Route::get('/details', 'Admin\VendorManagementController@show')->name('admin.vendor_management.vendor_details');

      Route::get('/edit', 'Admin\VendorManagementController@edit')->name('admin.edit_management.vendor_edit');

      Route::post('/update', 'Admin\VendorManagementController@update')->name('admin.vendor_management.vendor.update_vendor');

      Route::post(
        '/update/vendor/balance',
        'Admin\VendorManagementController@update_vendor_balance'
      )->name('admin.vendor_management.update_vendor_balance');

      Route::get('/change-password', 'Admin\VendorManagementController@changePassword')->name('admin.vendor_management.vendor.change_password');

      Route::post('/update-password', 'Admin\VendorManagementController@updatePassword')->name('admin.vendor_management.vendor.update_password');

      Route::post('/delete', 'Admin\VendorManagementController@destroy')->name('admin.vendor_management.vendor.delete');

      //add or subtract balance
      Route::get('/balance', 'Admin\VendorManagementController@balance')->name('admin.edit_management.balance');
      Route::post('/update/vendor/balance', 'Admin\VendorManagementController@update_vendor_balance')->name('admin.vendor_management.vendor.update_vendor_balance');
    });

    Route::post('/vendor/current-package/remove', 'Admin\VendorManagementController@removeCurrPackage')->name('vendor.currPackage.remove');

    Route::post('/vendor/current-package/change', 'Admin\VendorManagementController@changeCurrPackage')->name('vendor.currPackage.change');

    Route::post('/vendor/current-package/add', 'Admin\VendorManagementController@addCurrPackage')->name('vendor.currPackage.add');

    Route::post('/vendor/next-package/remove', 'Admin\VendorManagementController@removeNextPackage')->name('vendor.nextPackage.remove');

    Route::post('/vendor/next-package/change', 'Admin\VendorManagementController@changeNextPackage')->name('vendor.nextPackage.change');

    Route::post(
      '/vendor/next-package/add',
      'Admin\VendorManagementController@addNextPackage'
    )->name('vendor.nextPackage.add');


    Route::post(
      '/bulk-delete-vendor',
      'Admin\VendorManagementController@bulkDestroy'
    )->name('admin.vendor_management.bulk_delete_vendor');

    Route::get('/secret-login/{id}', 'Admin\VendorManagementController@secret_login')->name('admin.vendor_management.vendor.secret_login');
  });

  //website pages all-route
  Route::prefix('pages')->group(function () {
    // home-page route
    Route::prefix('/home-page')->middleware('permission:Home Page')->group(function () {
      //about page custom section
      Route::prefix('additional-sections')->group(function () {
        Route::get('sections', 'Admin\HomePage\AdditionalSectionController@index')->name('admin.home.additional_sections');
        Route::get(
          'add-section',
          'Admin\HomePage\AdditionalSectionController@create'
        )->name('admin.home.additional_section.create');
        Route::post('store-section', 'Admin\HomePage\AdditionalSectionController@store')->name('admin.home.additional_section.store');
        Route::get('edit-section/{id}', 'Admin\HomePage\AdditionalSectionController@edit')->name('admin.home.additional_section.edit');
        Route::post('update/{id}', 'Admin\HomePage\AdditionalSectionController@update')->name('admin.home.additional_section.update');
        Route::post('delete/{id}', 'Admin\HomePage\AdditionalSectionController@delete')->name('admin.home.additional_section.delete');
        Route::post(
          'bulkdelete',
          'Admin\HomePage\AdditionalSectionController@bulkdelete'
        )->name('admin.home.additional_section.bulkdelete');
      });


      Route::post('/update-category-section', 'Admin\HomePage\CategorySectionController@update')->name('admin.home_page.update_category_section');

      Route::prefix('/work-process')->group(function () {
        Route::post('/store', 'Admin\HomePage\WorkProcessController@storeWorkProcess')->name('admin.basic_settings.store_work_process');

        Route::post('/update', 'Admin\HomePage\WorkProcessController@updateWorkProcess')->name('admin.basic_settings.update_work_process');

        Route::post('{id}/delete', 'Admin\HomePage\WorkProcessController@destroyWorkProcess')->name('admin.basic_settings.delete_work_process');

        Route::post('/bulk-delete', 'Admin\HomePage\WorkProcessController@bulkDestroyWorkProcess')->name('admin.basic_settings.bulk_delete_work_process');
      });

      Route::prefix('/feature')->group(function () {
        Route::post('/store', 'Admin\HomePage\FeatureController@storeFeature')->name('admin.home_page.store_feature');

        Route::post('/update', 'Admin\HomePage\FeatureController@updateFeature')->name('admin.home_page.update_feature');

        Route::post('{id}/delete', 'Admin\HomePage\FeatureController@destroyFeature')->name('admin.home_page.delete_feature');

        Route::post('/bulk-delete', 'Admin\HomePage\FeatureController@bulkDestroyFeature')->name('admin.home_page.bulk_delete_feature');
      });
      //section titles
      Route::get('/images-&-texts', 'Admin\HomePage\SectionController@sectionContent')->name('admin.home_page.section_content');
      Route::post('/update/images-&-texts', 'Admin\HomePage\SectionController@updateContent')->name('admin.home_page.section_content_update');
      // section customization
      Route::get('/section-customization', 'Admin\HomePage\SectionController@index')->name('admin.home_page.section_customization');

      Route::post(
        '/update-section-status',
        'Admin\HomePage\SectionController@update'
      )->name('admin.home_page.update_section_status');


      // banners route
      Route::get('/banners', 'Admin\HomePage\BannerController@index')->name('admin.home_page.banners');

      Route::post('/store-banners', 'Admin\HomePage\BannerController@store')->name('admin.home_page.store_banner');

      Route::post('/update-banners', 'Admin\HomePage\BannerController@update')->name('admin.home_page.update_banner');

      Route::post('/delete-banners/{id}', 'Admin\HomePage\BannerController@destroy')->name('admin.home_page.delete_banner');
      Route::post('/bulk-delete', 'Admin\HomePage\BannerController@bulkDestroy')->name('admin.home_page.bulk_delete_banner');
    });
    // work process section
    Route::get('/work-process', 'Admin\HomePage\WorkProcessController@sectionInfo')->name('admin.home_page.work_process_section');

    Route::prefix('/work-process')->group(function () {
      Route::post('/store', 'Admin\HomePage\WorkProcessController@storeWorkProcess')->name('admin.home_page.store_work_process');

      Route::post('/update', 'Admin\HomePage\WorkProcessController@updateWorkProcess')->name('admin.home_page.update_work_process');

      Route::post('{id}/delete', 'Admin\HomePage\WorkProcessController@destroyWorkProcess')->name('admin.home_page.delete_work_process');

      Route::post('/bulk-delete', 'Admin\HomePage\WorkProcessController@bulkDestroyWorkProcess')->name('admin.home_page.bulk_delete_work_process');
    });
    // faq route
    Route::prefix('/faqs')->middleware('permission:FAQs')->group(function () {
      Route::get('', 'Admin\FaqController@index')->name('admin.faq_management');

      Route::post('/store-faq', 'Admin\FaqController@store')->name('admin.faq_management.store_faq');

      Route::post('/update-faq', 'Admin\FaqController@update')->name('admin.faq_management.update_faq');

      Route::post('/delete-faq/{id}', 'Admin\FaqController@destroy')->name('admin.faq_management.delete_faq');

      Route::post('/bulk-delete-faq', 'Admin\FaqController@bulkDestroy')->name('admin.faq_management.bulk_delete_faq');
    });
    //about-us-page route
    Route::prefix('about-us')->middleware('permission:About Us')->group(function () {
      //about us section
      Route::get('/about', 'Admin\AboutUs\AboutSectionController@about_us')->name('admin.about_us.index');

      Route::post('/update-about-us', 'Admin\AboutUs\AboutSectionController@update_about_us')->name('admin.about_us.update');
      Route::get('/testimonial-section', 'Admin\HomePage\TestimonialController@index')->name('admin.about_us.testimonial_section');
      Route::post('/testimonial-section/update', 'Admin\HomePage\TestimonialController@updateSection')->name('admin.about_us.testimonial_section_update');
      Route::get('/customize-section', 'Admin\AboutUs\AboutSectionController@customizeSection')->name('admin.about_us.customize');
      Route::post('/customize-section/update', 'Admin\AboutUs\AboutSectionController@customizeUpdate')->name('admin.about_us.customize_update');

      // features
      Route::post('/store-features', 'Admin\AboutUs\FeaturesController@storeFeatures')->name('admin.about_us.store_features');

      Route::post('/update-features', 'Admin\AboutUs\FeaturesController@updateFeatures')->name('admin.about_us.update_features');

      Route::post('{id}/delete', 'Admin\AboutUs\FeaturesController@destroy')->name('admin.about_us.delete_features');

      Route::post('/bulk-delete', 'Admin\AboutUs\FeaturesController@bulkDestroy')->name('admin.about_us.bulk_delete_features');

      //about page custom section
      Route::prefix('additional-sections')->group(function () {
        Route::get('sections', 'Admin\AdditionalSectionController@index')->name('admin.additional_sections');
        Route::get(
          'add-section',
          'Admin\AdditionalSectionController@create'
        )->name('admin.additional_section.create');
        Route::post('store-section', 'Admin\AdditionalSectionController@store')->name('admin.additional_section.store');
        Route::get('edit-section/{id}', 'Admin\AdditionalSectionController@edit')->name('admin.additional_section.edit');
        Route::post('update/{id}', 'Admin\AdditionalSectionController@update')->name('admin.additional_section.update');
        Route::post('delete/{id}', 'Admin\AdditionalSectionController@delete')->name('admin.additional_section.delete');
        Route::post(
          'bulkdelete',
          'Admin\AdditionalSectionController@bulkdelete'
        )->name('admin.additional_section.bulkdelete');
      });
    });
    // testimonial section
    Route::get('/testimonials', 'Admin\HomePage\TestimonialController@index')->name('admin.home_page.testimonial_section');
    Route::prefix('/testimonial')->group(function () {
      Route::post('/store', 'Admin\HomePage\TestimonialController@storeTestimonial')->name('admin.home_page.store_testimonial');

      Route::post('/update', 'Admin\HomePage\TestimonialController@updateTestimonial')->name('admin.home_page.update_testimonial');

      Route::post('{id}/delete', 'Admin\HomePage\TestimonialController@destroyTestimonial')->name('admin.home_page.delete_testimonial');

      Route::post('/bulk-delete', 'Admin\HomePage\TestimonialController@bulkDestroyTestimonial')->name('admin.home_page.bulk_delete_testimonial');
    });
    // blog management route
    Route::prefix('/blog')->middleware('permission:Blog')->group(function () {
      // blog category route
      Route::get('/categories', 'Admin\Journal\CategoryController@index')->name('admin.blog_management.categories');

      Route::post('/store-category', 'Admin\Journal\CategoryController@store')->name('admin.blog_management.store_category');

      Route::post('/update-category', 'Admin\Journal\CategoryController@update')->name('admin.blog_management.update_category');

      Route::post(
        '/delete-category/{id}',
        'Admin\Journal\CategoryController@destroy'
      )->name('admin.blog_management.delete_category');

      Route::post(
        '/bulk-delete-category',
        'Admin\Journal\CategoryController@bulkDestroy'
      )->name('admin.blog_management.bulk_delete_category');

      // blog route
      Route::get(
        '/posts',
        'Admin\Journal\BlogController@index'
      )->name('admin.blog_management.blogs');

      Route::get('/create-blog', 'Admin\Journal\BlogController@create')->name('admin.blog_management.create_blog');

      Route::post('/store-blog', 'Admin\Journal\BlogController@store')->name('admin.blog_management.store_blog');

      Route::get('/edit-blog/{id}', 'Admin\Journal\BlogController@edit')->name('admin.blog_management.edit_blog');

      Route::post('/update-blog/{id}', 'Admin\Journal\BlogController@update')->name('admin.blog_management.update_blog');

      Route::post('/delete-blog/{id}', 'Admin\Journal\BlogController@destroy')->name('admin.blog_management.delete_blog');

      Route::post('/bulk-delete-blog', 'Admin\Journal\BlogController@bulkDestroy')->name('admin.blog_management.bulk_delete_blog');
    });
    // footer route
    Route::prefix('/footer')->middleware('permission:Footer')->group(function () {
      // logo & image route
      Route::get('/logo', 'Admin\Footer\ImageController@index')->name('admin.footer.logo_and_image');

      Route::post('/update-logo', 'Admin\Footer\ImageController@updateLogo')->name('admin.footer.update_logo');

      // content route
      Route::get('/content', 'Admin\Footer\ContentController@index')->name('admin.footer.content');

      Route::post('/update-content', 'Admin\Footer\ContentController@update')->name('admin.footer.update_content');

      // quick link route
      Route::get('/quick-links', 'Admin\Footer\QuickLinkController@index')->name('admin.footer.quick_links');

      Route::post('/store-quick-link', 'Admin\Footer\QuickLinkController@store')->name('admin.footer.store_quick_link');

      Route::post('/update-quick-link', 'Admin\Footer\QuickLinkController@update')->name('admin.footer.update_quick_link');

      Route::post(
        '/delete-quick-link/{id}',
        'Admin\Footer\QuickLinkController@destroy'
      )->name('admin.footer.delete_quick_link');
    });
    // seo route
    Route::get('/seo-informations', 'Admin\BasicSettings\SEOController@index')->name('admin.basic_settings.seo')->middleware('permission:SEO Informations');
    // breadcrumb route
    Route::prefix('breadcrumbs')->middleware('permission:Breadcrumbs')->group(function () {
      Route::get('/image', 'Admin\BasicSettings\BasicController@breadcrumb')->name('admin.basic_settings.breadcrumb');
      Route::get('/headings', 'Admin\BasicSettings\PageHeadingController@pageHeadings')->name('admin.basic_settings.page_headings');
    });
    //contact page route
    Route::get('/contact-page', 'Admin\BasicSettings\BasicController@contact_page')->name('admin.basic_settings.contact_page')->middleware('permission:Contact Page');

    // additional-pages route
    Route::prefix('/additional-pages')->middleware('permission:Additional Pages')->group(function () {
      Route::get('all-pages', 'Admin\CustomPageController@index')->name('admin.custom_pages');

      Route::get('/add-page', 'Admin\CustomPageController@create')->name('admin.custom_pages.create_page');

      Route::post('/store-page', 'Admin\CustomPageController@store')->name('admin.custom_pages.store_page');

      Route::get('/edit-page/{id}', 'Admin\CustomPageController@edit')->name('admin.custom_pages.edit_page');

      Route::post('/update-page/{id}', 'Admin\CustomPageController@update')->name('admin.custom_pages.update_page');

      Route::post('/delete-page/{id}', 'Admin\CustomPageController@destroy')->name('admin.custom_pages.delete_page');

      Route::post('/bulk-delete-page', 'Admin\CustomPageController@bulkDestroy')->name('admin.custom_pages.bulk_delete_page');
    });
  });

  #====support tickets ============

  Route::prefix('support-ticket')->group(function () {
    Route::get('/setting', 'Admin\SupportTicketController@setting')->name('admin.support_ticket.setting');
    Route::post('/setting/update', 'Admin\SupportTicketController@update_setting')->name('admin.support_ticket.update_setting');
    Route::get('/tickets', 'Admin\SupportTicketController@index')->name('admin.support_tickets');
    Route::get('/message/{id}', 'Admin\SupportTicketController@message')->name('admin.support_tickets.message');
    Route::post('/zip-upload', 'Admin\SupportTicketController@zip_file_upload')->name('admin.support_ticket.zip_file.upload');
    Route::post('/reply/{id}', 'Admin\SupportTicketController@ticketreply')->name('admin.support_ticket.reply');
    Route::post('/closed/{id}', 'Admin\SupportTicketController@ticket_closed')->name('admin.support_ticket.close');
    Route::post('/assign-stuff/{id}', 'Admin\SupportTicketController@assign_stuff')->name('assign_stuff.supoort.ticket');

    Route::get('/unassign-stuff/{id}', 'Admin\SupportTicketController@unassign_stuff')->name('admin.support_tickets.unassign');

    Route::post('/delete/{id}', 'Admin\SupportTicketController@delete')->name('admin.support_tickets.delete');
    Route::post('/bulk-delete', 'Admin\SupportTicketController@bulk_delete')->name('admin.support_tickets.bulk_delete');
  });

  // advertise route
  Route::prefix('/advertise')->middleware('permission:Advertise')->group(function () {
    Route::get('/settings', 'Admin\AdvertisementController@advertiseSettings')->name('admin.advertise.settings');

    Route::post('/update-settings', 'Admin\AdvertisementController@updateAdvertiseSettings')->name('admin.advertise.update_settings');

    Route::get('/all-advertisement', 'Admin\AdvertisementController@index')->name('admin.advertise.all_advertisement');

    Route::get('/preview-image', 'Admin\AdvertisementController@previewImage')->name('admin.advertise.preview_image');

    Route::post('/store-advertisement', 'Admin\AdvertisementController@store')->name('admin.advertise.store_advertisement');

    Route::post(
      '/update-advertisement',
      'Admin\AdvertisementController@update'
    )->name('admin.advertise.update_advertisement');

    Route::post('/delete-advertisement/{id}', 'Admin\AdvertisementController@destroy')->name('admin.advertise.delete_advertisement');

    Route::post('/bulk-delete-advertisement', 'Admin\AdvertisementController@bulkDestroy')->name('admin.advertise.bulk_delete_advertisement');
  });


  // announcement-popup route
  Route::prefix('/announcement-popups')->middleware('permission:Announcement Popups')->group(function () {
    Route::get('', 'Admin\PopupController@index')->name('admin.announcement_popups');

    Route::get('/select-popup-type', 'Admin\PopupController@popupType')->name('admin.announcement_popups.select_popup_type');

    Route::get('/create-popup/{type}', 'Admin\PopupController@create')->name('admin.announcement_popups.create_popup');

    Route::post('/store-popup', 'Admin\PopupController@store')->name('admin.announcement_popups.store_popup');

    Route::post('/popup/{id}/update-status', 'Admin\PopupController@updateStatus')->name('admin.announcement_popups.update_popup_status');

    Route::get('/edit-popup/{id}', 'Admin\PopupController@edit')->name('admin.announcement_popups.edit_popup');

    Route::post('/update-popup/{id}', 'Admin\PopupController@update')->name('admin.announcement_popups.update_popup');

    Route::post('/delete-popup/{id}', 'Admin\PopupController@destroy')->name('admin.announcement_popups.delete_popup');

    Route::post('/bulk-delete-popup', 'Admin\PopupController@bulkDestroy')->name('admin.announcement_popups.bulk_delete_popup');
  });




  //website settings
  Route::prefix('/settings')->middleware('permission:Settings')->group(function () {
    // basic settings favicon route
    Route::get('/favicon', 'Admin\BasicSettings\BasicController@favicon')->name('admin.basic_settings.favicon');

    Route::post('/update-favicon', 'Admin\BasicSettings\BasicController@updateFavicon')->name('admin.basic_settings.update_favicon');

    // basic settings logo route
    Route::get('/logo', 'Admin\BasicSettings\BasicController@logo')->name('admin.basic_settings.logo');

    Route::post('/update-logo', 'Admin\BasicSettings\BasicController@updateLogo')->name('admin.basic_settings.update_logo');

    // basic settings information route
    Route::get('/information', 'Admin\BasicSettings\BasicController@information')->name('admin.basic_settings.information');

    Route::post('/update-info', 'Admin\BasicSettings\BasicController@updateInfo')->name('admin.basic_settings.update_info');

    Route::get('/general-settings', 'Admin\BasicSettings\BasicController@general_settings')->name('admin.basic_settings.general_settings');

    Route::post('/update-general-settings', 'Admin\BasicSettings\BasicController@update_general_setting')->name('admin.basic_settings.general_settings.update');

    Route::post('/update-contact-page', 'Admin\BasicSettings\BasicController@update_contact_page')->name('admin.basic_settings.contact_page.update');

    // basic settings (theme & home) route
    Route::get('/theme-and-home', 'Admin\BasicSettings\BasicController@themeAndHome')->name('admin.basic_settings.theme_and_home');

    Route::post(
      '/update-theme-and-home',
      'Admin\BasicSettings\BasicController@updateThemeAndHome'
    )->name('admin.basic_settings.update_theme_and_home');


    // basic settings currency route
    Route::get('/currency', 'Admin\BasicSettings\BasicController@currency')->name('admin.basic_settings.currency');

    Route::post('/update-currency', 'Admin\BasicSettings\BasicController@updateCurrency')->name('admin.basic_settings.update_currency');

    // basic settings appearance route
    Route::get('/appearance', 'Admin\BasicSettings\BasicController@appearance')->name('admin.basic_settings.appearance');

    Route::post('/update-appearance', 'Admin\BasicSettings\BasicController@updateAppearance')->name('admin.basic_settings.update_appearance');

    // basic settings mail route start
    Route::get('/mail-from-admin', 'Admin\BasicSettings\BasicController@mailFromAdmin')->name('admin.basic_settings.mail_from_admin');

    Route::post(
      '/update-mail-from-admin',
      'Admin\BasicSettings\BasicController@updateMailFromAdmin'
    )->name('admin.basic_settings.update_mail_from_admin');

    Route::get('/mail-to-admin', 'Admin\BasicSettings\BasicController@mailToAdmin')->name('admin.basic_settings.mail_to_admin');

    Route::post(
      '/update-mail-to-admin',
      'Admin\BasicSettings\BasicController@updateMailToAdmin'
    )->name('admin.basic_settings.update_mail_to_admin');

    Route::get('/mail-templates', 'Admin\BasicSettings\MailTemplateController@index')->name('admin.basic_settings.mail_templates');

    Route::get('/edit-mail-template/{id}', 'Admin\BasicSettings\MailTemplateController@edit')->name('admin.basic_settings.edit_mail_template');

    Route::post('/update-mail-template/{id}', 'Admin\BasicSettings\MailTemplateController@update')->name('admin.basic_settings.update_mail_template');
    // basic settings mail route end

    Route::post('/update-breadcrumb', 'Admin\BasicSettings\BasicController@updateBreadcrumb')->name('admin.basic_settings.update_breadcrumb');

    Route::post(
      '/update-page-headings',
      'Admin\BasicSettings\PageHeadingController@updatePageHeadings'
    )->name('admin.basic_settings.update_page_headings');

    // basic settings plugins route start
    Route::get('/plugins', 'Admin\BasicSettings\BasicController@plugins')->name('admin.basic_settings.plugins');

    Route::get('/vendor-plugins/{id}', 'Admin\BasicSettings\BasicController@vendorZoom')->name('admin.basic_settings.vendorPlugin');


    Route::get('/calendar/{id}', 'Admin\BasicSettings\BasicController@vendorCalendar')->name('admin.basic_settings.calendar');

    Route::post('/update-disqus', 'Admin\BasicSettings\BasicController@updateDisqus')->name('admin.basic_settings.update_disqus');

    Route::post('/update-zoom', 'Admin\BasicSettings\BasicController@updateZoom')->name('admin.basic_settings.update_zoom');

    Route::post('/google-calender', 'Admin\BasicSettings\BasicController@updateCalender')->name('admin.basic_settings.update_calender');

    Route::post('/update-tawkto', 'Admin\BasicSettings\BasicController@updateTawkTo')->name('admin.basic_settings.update_tawkto');

    Route::post('/update-recaptcha', 'Admin\BasicSettings\BasicController@updateRecaptcha')->name('admin.basic_settings.update_recaptcha');

    Route::post('/update-facebook', 'Admin\BasicSettings\BasicController@updateFacebook')->name('admin.basic_settings.update_facebook');

    Route::post('/update-google', 'Admin\BasicSettings\BasicController@updateGoogle')->name('admin.basic_settings.update_google');

    Route::post('/update-whatsapp', 'Admin\BasicSettings\BasicController@updateWhatsApp')->name('admin.basic_settings.update_whatsapp');
    // basic settings plugins route end

    Route::post('/update-seo', 'Admin\BasicSettings\SEOController@update')->name('admin.basic_settings.update_seo');

    // basic settings maintenance-mode route
    Route::get('/maintenance-mode', 'Admin\BasicSettings\BasicController@maintenance')->name('admin.basic_settings.maintenance_mode');

    Route::post('/update-maintenance-mode', 'Admin\BasicSettings\BasicController@updateMaintenance')->name('admin.basic_settings.update_maintenance_mode');

    // basic settings cookie-alert route
    Route::get('/cookie-alert', 'Admin\BasicSettings\CookieAlertController@cookieAlert')->name('admin.basic_settings.cookie_alert');

    Route::post('/update-cookie-alert', 'Admin\BasicSettings\CookieAlertController@updateCookieAlert')->name('admin.basic_settings.update_cookie_alert');

    // basic-settings social-media route
    Route::get('/social-medias', 'Admin\BasicSettings\SocialMediaController@index')->name('admin.basic_settings.social_medias');

    Route::post('/store-social-media', 'Admin\BasicSettings\SocialMediaController@store')->name('admin.basic_settings.store_social_media');

    Route::post('/update-social-media', 'Admin\BasicSettings\SocialMediaController@update')->name('admin.basic_settings.update_social_media');

    Route::post('/delete-social-media/{id}', 'Admin\BasicSettings\SocialMediaController@destroy')->name('admin.basic_settings.delete_social_media');

    // language management route start
    Route::prefix('/languages')->middleware('permission:Languages')->group(function () {
      Route::get('', 'Admin\LanguageController@index')->name('admin.language_management');

      Route::post('/store', 'Admin\LanguageController@store')->name('admin.language_management.store');

      Route::post('/{id}/make-default-language', 'Admin\LanguageController@makeDefault')->name('admin.language_management.make_default_language');

      Route::post('/update', 'Admin\LanguageController@update')->name('admin.language_management.update');

      Route::get('/{id}/edit-keyword', 'Admin\LanguageController@editKeyword')->name('admin.language_management.edit_keyword');

      Route::post('add-keyword', 'Admin\LanguageController@addKeyword')->name('admin.language_management.add_keyword');

      Route::post(
        '/{id}/update-keyword',
        'Admin\LanguageController@updateKeyword'
      )->name('admin.language_management.update_keyword');

      Route::post('/{id}/delete', 'Admin\LanguageController@destroy')->name('admin.language_management.delete');

      Route::get('/{id}/check-rtl', 'Admin\LanguageController@checkRTL');
      Route::get('/{id}/check-rtl2', 'Admin\LanguageController@checkRTL2');
    });


    // payment-gateway route
    Route::prefix('/payment-gateways')->middleware('permission:Payment Gateways')->group(function () {
      Route::get('/online-gateways', 'Admin\PaymentGateway\OnlineGatewayController@index')->name('admin.payment_gateways.online_gateways');

      Route::post('/update-paypal-info', 'Admin\PaymentGateway\OnlineGatewayController@updatePayPalInfo')->name('admin.payment_gateways.update_paypal_info');

      Route::post('/update-instamojo-info', 'Admin\PaymentGateway\OnlineGatewayController@updateInstamojoInfo')->name('admin.payment_gateways.update_instamojo_info');

      Route::post(
        '/update-paystack-info',
        'Admin\PaymentGateway\OnlineGatewayController@updatePaystackInfo'
      )->name('admin.payment_gateways.update_paystack_info');

      Route::post('/update-flutterwave-info', 'Admin\PaymentGateway\OnlineGatewayController@updateFlutterwaveInfo')->name('admin.payment_gateways.update_flutterwave_info');

      Route::post(
        '/update-razorpay-info',
        'Admin\PaymentGateway\OnlineGatewayController@updateRazorpayInfo'
      )->name('admin.payment_gateways.update_razorpay_info');

      Route::post('/update-mercadopago-info', 'Admin\PaymentGateway\OnlineGatewayController@updateMercadoPagoInfo')->name('admin.payment_gateways.update_mercadopago_info');

      Route::post('/update-mollie-info', 'Admin\PaymentGateway\OnlineGatewayController@updateMollieInfo')->name('admin.payment_gateways.update_mollie_info');

      Route::post('/update-stripe-info', 'Admin\PaymentGateway\OnlineGatewayController@updateStripeInfo')->name('admin.payment_gateways.update_stripe_info');

      Route::post('/update-paytm-info', 'Admin\PaymentGateway\OnlineGatewayController@updatePaytmInfo')->name('admin.payment_gateways.update_paytm_info');
      Route::post('/update-anet-info', 'Admin\PaymentGateway\OnlineGatewayController@updateAnetInfo')->name('admin.payment_gateways.update_anet_info');

      Route::get('/offline-gateways', 'Admin\PaymentGateway\OfflineGatewayController@index')->name('admin.payment_gateways.offline_gateways');

      Route::post('/store-offline-gateway', 'Admin\PaymentGateway\OfflineGatewayController@store')->name('admin.payment_gateways.store_offline_gateway');

      Route::post('/update-status/{id}', 'Admin\PaymentGateway\OfflineGatewayController@updateStatus')->name('admin.payment_gateways.update_status');

      Route::post('/update-offline-gateway', 'Admin\PaymentGateway\OfflineGatewayController@update')->name('admin.payment_gateways.update_offline_gateway');

      Route::post('/delete-offline-gateway/{id}', 'Admin\PaymentGateway\OfflineGatewayController@destroy')->name('admin.payment_gateways.delete_offline_gateway');
    });
  });
});
