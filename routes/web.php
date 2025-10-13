<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Interface Routes
|--------------------------------------------------------------------------
*/

// cron job for sending expiry mail
Route::get('/subcheck', 'CronJobController@expired')->name('cron.expired');

Route::get('/change-language', 'FrontEnd\MiscellaneousController@changeLanguage')->name('change_language');

Route::post('/store-subscriber', 'FrontEnd\MiscellaneousController@storeSubscriber')->name('store_subscriber');

Route::get('/offline', 'FrontEnd\HomeController@offline')->middleware('change.lang');

Route::middleware('change.lang')->group(function () {
  Route::get('/', 'FrontEnd\HomeController@index')->name('index');

  //services route
  Route::prefix('services')->group(function () {
    Route::get('/', 'FrontEnd\Services\ServiceController@index')->name('frontend.services');

    Route::get('addto/wishlist/{id}', 'FrontEnd\UserController@add_to_wishlist')->name('addto.wishlist');
    Route::get('remove/wishlist/{id}', 'FrontEnd\UserController@remove_wishlist')->name('remove.wishlist');
    //service search
    Route::get('service/search', 'FrontEnd\Services\ServiceController@searchService')->name('frontend.services.category.search');

    //service rating
    Route::post('service/store-review/{id}', 'FrontEnd\Services\ServiceController@storeReview')->name('frontend.service.rating.store');

    Route::post('contact/message', 'FrontEnd\Services\ServiceController@message')->name('frontend.services.contact.message');

    Route::get('/details/{slug}/{id}', 'FrontEnd\Services\ServiceController@details')->name('frontend.service.details');

    Route::get('services-staff-content/{id}', 'FrontEnd\Services\ServiceController@staffcontent')->name('frontend.service.content');

    Route::get('billing-form', 'FrontEnd\Services\ServiceController@billing')->name('frontend.services.billing');

    Route::get('payment-success/{id}', 'FrontEnd\Services\ServiceController@paymentSuccess')->name('frontend.service.payment.success');

    //show time slot on modal
    Route::get('show-staff-hour/{id}', 'FrontEnd\Services\ServiceController@staffHour')->name('frontend.staff.hour');

    Route::get('staff-date-time/{id}', 'FrontEnd\Services\ServiceController@staffHoliday')->name('frontend.staff.holiday');

    // General availability routes (without staff selection)
    Route::get('general-date-time/{serviceId}', 'FrontEnd\Services\ServiceController@generalHoliday')->name('frontend.general.holiday');
    Route::get('show-general-hour/{serviceId}', 'FrontEnd\Services\ServiceController@showGeneralHour')->name('frontend.general.hour');

    Route::post('login', 'FrontEnd\Services\ServiceController@login')->name('frontend.user.login');

    Route::get('staff/search/{id}', 'FrontEnd\Services\ServiceController@staffSearch')->name('frontend.staff.search');

    Route::post('session/forget', 'FrontEnd\Services\ServiceController@sessionForget')->name('service.session.forget');

    Route::post('payment/process/', 'FrontEnd\Booking\ServicePaymentController@index')->name('frontend.service.payment');

    //service booking payment notify route
    Route::get('/paypal/payment/notify', 'FrontEnd\Booking\Payment\PayPalController@notify')->name('frontend.service_booking.paypal.notify');

    Route::post('/razorpay/payment/notify', 'FrontEnd\Booking\Payment\RazorpayController@notify')->name('frontend.service_booking.razorpay.notify');

    Route::get('/flutterwave/payment/notify', 'FrontEnd\Booking\Payment\FlutterwaveController@notify')
      ->name('frontend.service_booking.flutterwave.notify');

    Route::get('/instamojo/payment/notify', 'FrontEnd\Booking\Payment\InstamojoController@notify')->name('frontend.service_booking.instamojo.notify');

    Route::get(
      '/mollie/payment/notify',
      'FrontEnd\Booking\Payment\MollieController@notify'
    )->name('frontend.service_booking.mollie.notify');

    Route::get('/paystack/payment/notify', 'FrontEnd\Booking\Payment\PaystackController@notify')->name('frontend.service_booking.paystack.notify');

    Route::get('/mercadopago/payment/notify', 'FrontEnd\Booking\Payment\MercadoPagoController@notify')->name('frontend.service_booking.mercadopago.notify');

    Route::post('/paytm/payment/notify', 'FrontEnd\Booking\Payment\PaytmController@notify')->name('frontend.service_booking.paytm.notify');

    Route::get('/booking/complete/popup', 'FrontEnd\Booking\ServicePaymentController@complete')->name('frontend.service.booking.complete');

    Route::get('/cancel', 'FrontEnd\Booking\ServicePaymentController@cancel')->name('frontend.service_booking.cancel');
  });

  //products routes are goes here
  Route::get('/products', 'FrontEnd\Shop\ProductController@index')->name('shop.products')->middleware('shop.status');

  Route::prefix('/product')->middleware(['shop.status'])->group(function () {
    Route::get('/{slug}', 'FrontEnd\Shop\ProductController@show')->name('shop.product_details');

    Route::get('/{id}/add-to-cart/{quantity}', 'FrontEnd\Shop\ProductController@addToCart')->name('shop.product.add_to_cart');
  });

  Route::prefix('/shop')->middleware(['shop.status'])->group(function () {
    Route::get('/cart', 'FrontEnd\Shop\ProductController@cart')->name('shop.cart');

    Route::post('/update-cart', 'FrontEnd\Shop\ProductController@updateCart')->name('shop.update_cart');

    Route::get('/cart/remove-product/{id}', 'FrontEnd\Shop\ProductController@removeProduct')->name('shop.cart.remove_product');

    Route::get('put-shipping-method-id/{id}', 'FrontEnd\Shop\ProductController@put_shipping_method')->name('put-shipping-method-id');

    Route::prefix('/checkout')->group(function () {
      Route::get('', 'FrontEnd\Shop\ProductController@checkout')->name('shop.checkout');

      Route::post('/apply-coupon', 'FrontEnd\Shop\ProductController@applyCoupon');

      Route::get('/offline-gateway/{id}/check-attachment', 'FrontEnd\Shop\ProductController@checkAttachment');
    });

    Route::prefix('/purchase-product')->group(function () {
      Route::post('', 'FrontEnd\Shop\PurchaseProcessController@index')->name('shop.purchase_product');

      Route::get('/paypal/notify', 'FrontEnd\PaymentGateway\PayPalController@notify')->name('shop.purchase_product.paypal.notify');

      Route::get('/instamojo/notify', 'FrontEnd\PaymentGateway\InstamojoController@notify')->name('shop.purchase_product.instamojo.notify');

      Route::get('/paystack/notify', 'FrontEnd\PaymentGateway\PaystackController@notify')->name('shop.purchase_product.paystack.notify');

      Route::get('/flutterwave/notify', 'FrontEnd\PaymentGateway\FlutterwaveController@notify')->name('shop.purchase_product.flutterwave.notify');

      Route::post('/razorpay/notify', 'FrontEnd\PaymentGateway\RazorpayController@notify')->name('shop.purchase_product.razorpay.notify');

      Route::get('/mercadopago/notify', 'FrontEnd\PaymentGateway\MercadoPagoController@notify')->name('shop.purchase_product.mercadopago.notify');

      Route::get('/mollie/notify', 'FrontEnd\PaymentGateway\MollieController@notify')->name('shop.purchase_product.mollie.notify');

      Route::post('/paytm/notify', 'FrontEnd\PaymentGateway\PaytmController@notify')->name('shop.purchase_product.paytm.notify');

      Route::get('/complete/{type?}', 'FrontEnd\Shop\PurchaseProcessController@complete')->name('shop.purchase_product.complete')->middleware('change.lang');

      Route::get('/cancel', 'FrontEnd\Shop\PurchaseProcessController@cancel')->name('shop.purchase_product.cancel');
    });

    Route::post('/product/{id}/store-review', 'FrontEnd\Shop\ProductController@storeReview')->name('shop.product_details.store_review');
  });

  Route::prefix('pricing')->group(function () {
    Route::get('/', 'FrontEnd\PricingController@index')->name('frontend.pricing');
  });

  Route::prefix('vendors')->group(function () {
    Route::get('/', 'FrontEnd\VendorController@index')->name('frontend.vendors');
    Route::post('contact/message', 'FrontEnd\VendorController@contact')->name('vendor.contact.message');
  });
  Route::get('vendor/{username}', 'FrontEnd\VendorController@details')->name('frontend.vendor.details');

  Route::prefix('/blog')->group(function () {
    Route::get('', 'FrontEnd\BlogController@index')->name('blog');

    Route::get('/{slug}', 'FrontEnd\BlogController@show')->name('blog_details');
  });

  Route::get('/faq', 'FrontEnd\FaqController@faq')->name('faq');
  Route::get('/about-us', 'FrontEnd\HomeController@about')->name('about_us');

  Route::prefix('/contact')->group(function () {
    Route::get('', 'FrontEnd\ContactController@contact')->name('contact');

    Route::post('/send-mail', 'FrontEnd\ContactController@sendMail')->name('contact.send_mail')->withoutMiddleware('change.lang');
  });
});

Route::post('/advertisement/{id}/count-view', 'FrontEnd\MiscellaneousController@countAdView');

Route::prefix('login')->middleware(['guest:web', 'change.lang'])->group(function () {
  // user login via facebook route
  Route::prefix('/user/facebook')->group(function () {
    Route::get('', 'FrontEnd\UserController@redirectToFacebook')->name('user.login.facebook');

    Route::get('/callback', 'FrontEnd\UserController@handleFacebookCallback');
  });

  // user login via google route
  Route::prefix('/google')->group(function () {
    Route::get('', 'FrontEnd\UserController@redirectToGoogle')->name('user.login.google');

    Route::get('/callback', 'FrontEnd\UserController@handleGoogleCallback');
  });
});

Route::prefix('/user')->middleware(['guest:web', 'change.lang'])->group(function () {
  Route::prefix('/login')->group(function () {
    // user redirect to login page route
    Route::get('', 'FrontEnd\UserController@login')->name('user.login');
  });
  // user login submit route
  Route::post('/login-submit', 'FrontEnd\UserController@loginSubmit')->name('user.login_submit')->withoutMiddleware('change.lang');

  // user forget password route
  Route::get('/forget-password', 'FrontEnd\UserController@forgetPassword')->name('user.forget_password');

  // send mail to user for forget password route
  Route::post('/send-forget-password-mail', 'FrontEnd\UserController@forgetPasswordMail')->name('user.send_forget_password_mail')->withoutMiddleware('change.lang');

  // reset password route
  Route::get('/reset-password', 'FrontEnd\UserController@resetPassword');

  // user reset password submit route
  Route::post('/reset-password-submit', 'FrontEnd\UserController@resetPasswordSubmit')->name('user.reset_password_submit')->withoutMiddleware('change.lang');

  // user redirect to signup page route
  Route::get('/signup', 'FrontEnd\UserController@signup')->name('user.signup');

  // user signup submit route
  Route::post('/signup-submit', 'FrontEnd\UserController@signupSubmit')->name('user.signup_submit')->withoutMiddleware('change.lang');

  // signup verify route
  Route::get('/signup-verify/{token}', 'FrontEnd\UserController@signupVerify')->withoutMiddleware('change.lang');
});

Route::prefix('/user')->middleware(['auth:web', 'account.status', 'change.lang'])->group(function () {
  // user redirect to dashboard route
  Route::get('/dashboard', 'FrontEnd\UserController@redirectToDashboard')->name('user.dashboard');
  Route::get('/wishlist', 'FrontEnd\UserController@wishlist')->name('user.wishlist');

  Route::get('appointment', 'FrontEnd\AppointmentController@appointment')->name('user.appointment.index');
  Route::get('appointment/details/{id}', 'FrontEnd\AppointmentController@details')->name('user.appointment.details');

  Route::get('order', 'FrontEnd\OrderController@index')->name('user.order.index')->middleware('shop.status');
  Route::get('/order/details/{id}', 'FrontEnd\OrderController@details')->name('user.order.details')->middleware('shop.status');

  Route::post('download/{product_id}', 'FrontEnd\OrderController@download')->name('user.product_order.product.download')->middleware('shop.status');

  // edit profile route
  Route::get('/edit-profile', 'FrontEnd\UserController@editProfile')->name('user.edit_profile');

  // update profile route
  Route::post('/update-profile', 'FrontEnd\UserController@updateProfile')->name('user.update_profile')->withoutMiddleware('change.lang');

  // change password route
  Route::get('/change-password', 'FrontEnd\UserController@changePassword')->name('user.change_password');

  // update password route
  Route::post('/update-password', 'FrontEnd\UserController@updatePassword')->name('user.update_password')->withoutMiddleware('change.lang');

  // user logout attempt route
  Route::get('/logout', 'FrontEnd\UserController@logoutSubmit')->name('user.logout')->withoutMiddleware('change.lang');
});

// service unavailable route
Route::get('/service-unavailable', 'FrontEnd\MiscellaneousController@serviceUnavailable')->name('service_unavailable')->middleware('exists.down');

/*
|--------------------------------------------------------------------------
| admin frontend route
|--------------------------------------------------------------------------
*/

Route::prefix('/admin')->middleware('guest:admin')->group(function () {
  // admin redirect to login page route
  Route::get('/', 'Admin\AdminController@login')->name('admin.login');

  // admin login attempt route
  Route::post('/auth', 'Admin\AdminController@authentication')->name('admin.auth');

  // admin forget password route
  Route::get('/forget-password', 'Admin\AdminController@forgetPassword')->name('admin.forget_password');

  // send mail to admin for forget password route
  Route::post('/mail-for-forget-password', 'Admin\AdminController@forgetPasswordMail')->name('admin.mail_for_forget_password');
});


/*
|--------------------------------------------------------------------------
| Custom Page Route For UI
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', 'FrontEnd\PageController@page')->name('dynamic_page')->middleware('change.lang');

// fallback route
Route::fallback(function () {
  return view('errors.404');
})->middleware('change.lang');
