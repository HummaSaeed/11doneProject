
<div class="bs-stepper" id="booking-stepper">
  <div class="bs-stepper-header" role="tablist">
    <!-- your steps here -->
    
    <div class="step" data-target="#time">
      <button type="button" class="step-trigger" role="tab" aria-controls="time" id="time-trigger">
        <span class="h3 mb-1">01</span>
        <span class="bs-stepper-circle"><i class="fal fa-clock"></i></span>
        <span class="bs-stepper-label">{{ __('Date & Time') }}</span>
      </button>
    </div>
    <div class="step" data-target="#info">
      <button type="button" class="step-trigger" role="tab" aria-controls="info" id="info-trigger">
        <span class="h3 mb-1">02</span>
        <span class="bs-stepper-circle"><i class="fal fa-clipboard-list-check"></i></span>
        <span class="bs-stepper-label">{{ __('Information') }}</span>
      </button>
    </div>
    <div class="step" data-target="#payment">
      <button type="button" class="step-trigger" role="tab" aria-controls="payment" id="payment-trigger">
        <span class="h3 mb-1">03</span>
        <span class="bs-stepper-circle"><i class="fal fa-credit-card"></i></span>
        <span class="bs-stepper-label">{{ __('Payment') }}</span>
      </button>
    </div>
    <!-- <div class="step" data-target="#summary">
      <button type="button" class="step-trigger" role="tab" aria-controls="confirm" id="confirm-trigger">
        <span class="h3 mb-1">04</span>
        <span class="bs-stepper-circle"><i class="fal fa-check-circle"></i></span>
        <span class="bs-stepper-label">{{ __('Summary') }}</span>
      </button>
    </div> -->
    <div class="step" data-target="#confirm">
      <button type="button" class="step-trigger" role="tab" aria-controls="confirm" id="confirm-trigger">
        <span class="h3 mb-1">05</span>
        <span class="bs-stepper-circle"><i class="fal fa-check-circle"></i></span>
        <span class="bs-stepper-label">{{ __('Confirmation') }}</span>
      </button>
    </div>
  </div>
  <div class="bs-stepper-content">
    <div class="container">
      <div id="time" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="time-trigger">
        <div class="calender-area pt-4">
          <div class="section-title title-center ">
            <h3 class="title">{{ __('Select Available Date & Time') }}</h3>
            <p class="text-muted">{{ __('Choose from available time slots for this service') }}</p>
          </div>
          <div class="booking-calendar mb-10"></div>
          <div class="booking-time">
            <h6 class="text-center pb-20 houre-title-1">
              {{ __('Please Select a Date for Available Schedule') }}</h6>
            <div class="swiper booking-time-slider">
              <!-- Here Service Hour -->
            </div>
          </div>

          <div class="btn-groups justify-content-center w-100 ">
            <a id="time_next_step" href="javaScript:void(0)" class="d-none btn-text color-primary icon-start"
              onclick="bookingStepper.next()" target="_self">{{ __('Next Step') }}<i
                class="fal fa-long-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div id="info" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="info-trigger">
        <!-- Authentication-area start -->
        <div class="authentication-area pt-1">
          <div class="row auth-info {{ !Auth::guard('web')->user() ? 'd-block' : 'd-none' }}">
            <div class="col-lg-12">
              <div class="auth-form">
                <form id="login-form">
                  <div class="title text-center mb-20">
                    <span class="h3 mb-2">{{ __('Login') }}</span>
                    <button class="btn btn-sm btn-primary btn-gradient" id="guest_checkout"
                      type="button">{{ __('Proceed as guest checkout') }}
                    </button>
                  </div>
                  <div class="form-group mb-20">
                    <label for="userName" class="form-label color-dark">{{ __('Username') }}<span
                        class="color-red">*</span></label>
                    <input type="text" name="username" id="username" class="form-control"
                      placeholder="{{ __('Username') }}">
                    <span id="err_username" class="mt-2 mb-0 text-danger em"></span>
                  </div>
                  <div class="form-group mb-20">
                    <label for="password" class="form-label color-dark">{{ __('Password') }}<span
                        class="color-red">*</span></label>
                    <div class="position-relative">
                      <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ __('Enter Password') }}">
                    </div>
                    <span id="err_password" class="mt-2 mb-0 text-danger em"></span>
                  </div>
                  @if ($bs->google_recaptcha_status == 1)
                    <div class="form-group mb-30">
                      {!! NoCaptcha::renderJs() !!}
                      {!! NoCaptcha::display() !!}
                      <span id="err_g-recaptcha-response" class="mt-2 mb-0 text-danger em"></span>
                    </div>
                  @endif
                  <button onclick="customerLogin(event)" type="button" class="btn btn-lg btn-primary btn-gradient">
                    {{ __('Login') }}
                  </button>
                  <div class="link mt-20">
                    {{ __("Don't have an account") }}? <a
                      href="{{ route('user.signup') }}">{{ __('Click Here') }}</a> {{ __('to') }}
                    {{ __('Signup') }}
                  </div>
                </form>
              </div>
              <div class="btn-groups d-flex justify-content-center mt-30">
                <a href="javaScript:void(0)" class="btn-text color-primary icon-start"
                  onclick="bookingStepper.previous()" target="_self"><i
                    class="fal fa-long-arrow-left"></i>{{ __('Prev Step') }}</a>
              </div>
            </div>
          </div>
          <form id="billing-form" class="{{ !Auth::guard('web')->user() ? 'd-none' : 'd-block' }}"
            action="{{ route('frontend.services.billing') }}" method="get">
            <div class="section-title title-center mb-30 mt-4">
              <h3 class="title col-lg-8">{{ __('Billing Details') }}</h3>
            </div>
            <div class="row">

              <div class="col-lg-6">
                <div class="form-group mb-30">
                  <label for="name">{{ __('Name') . '*' }}</label>
                  <input id="name" type="text" class="form-control" name="name"
                    placeholder="{{ __('Enter Full Name') }}" value="{{ $authUser ? $authUser->name : '' }}">
                  <span id="err_name" class="mt-2 mb-0 text-danger em"></span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-30">
                  <label for="phone">{{ __('Phone Number') . '*' }}</label>
                  <input id="phone" type="text" class="form-control" name="phone"
                    placeholder="{{ __('Phone Number') }}" value="{{ $authUser ? $authUser->phone : '' }}">
                  <span id="err_phone" class="mt-2 mb-0 text-danger em"></span>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-30">
                  <label for="email">{{ __('Email Address') }}*</label>
                  <input id="email" type="email" class="form-control" name="email"
                    placeholder="{{ __('Email Address') }}" value="{{ $authUser ? $authUser->email : '' }}">
                  <span id="err_email" class="mt-2 mb-0 text-danger em"></span>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-30">
                  <label for="address">{{ __('Address') }}*</label>
                  <input id="address" type="text" name="address" class="form-control"
                    placeholder="{{ __('Address') }}" value="{{ $authUser ? $authUser->address : '' }}">
                  <span id="err_address" class="mt-2 mb-0 text-danger em"></span>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-30">
                  <label for="address">{{ __('Postcode/Zip') }}</label>
                  <input id="zip_code" type="text" name="zip_code" class="form-control"
                    placeholder="{{ __('Postcode/Zip') }}" value="{{ $authUser ? $authUser->zip_code : '' }}">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-30">
                  <label for="">{{ __('Country') }}</label>
                  <input id="country" type="text" class="form-control" name="country"
                    placeholder="{{ __('Country') }}" value="{{ $authUser ? $authUser->country : '' }}">
                </div>
              </div>
            </div>
            <input hidden name="booking_date" id="booking_date">
            <input hidden name="user_id" id="user_id" value="{{ $authUser ? $authUser->id : '' }}">
            <input hidden name="staff_id" id="staff_id">
            <input hidden name="service_hour_id" id="service_hour_id">
            <input hidden name="max_person" id="max_person">
            <div class="d-flex  justify-content-center">
              <div class="btn-groups mt-30">
                @if (Auth::guard('web')->user())
                  <a href="javaScript:void(0)" class="btn-text color-primary icon-start"
                    onclick="bookingStepper.previous()" target="_self">
                    <i class="fal fa-long-arrow-left"></i>{{ __('Prev Step') }}</a>
                @else
                  <a href="javaScript:void(0)" id="billing_prev" class="btn-text color-primary icon-start login_prev"
                    target="_self">
                    <i class="fal fa-long-arrow-left"></i>{{ __('Prev Step') }}</a>
                @endif
                <a href="javaScript:void(0)" onclick="submitForm(event)" class="btn-text color-primary icon-end"
                  target="_self">{{ __('Next Step') }}
                  <i class="fal fa-long-arrow-right"></i></a>
              </div>
            </div>
          </form>
        </div>
        <!-- Authentication-area end -->
      </div>

      <div id="payment" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="payment-trigger">
        <div class="payment-area pt-4">
          <div class="section-title title-center mb-40">
            <h3 class="title col-lg-8">{{ __('Payment Method') }}</h3>
          </div>
          <div class="payment-form w-50 w-sm-100 mx-auto">
            <form action="{{ route('frontend.service.payment') }}" method="POST" id="payment-form"
              enctype="multipart/form-data">
              @csrf
              <input hidden type="text" name="stripeToken" id="stripeToken">
              <input hidden type="text" name="name" id="billing_name">
              <input hidden type="text" name="phone" id="billing_phone">
              <input hidden type="text" name="email" id="billing_email">
              <input hidden type="text" name="address" id="billing_address">
              <input hidden type="text" name="zip_code" id="billing_zip_code">
              <input hidden type="text" name="country" id="billing_country">
              <input hidden type="text" name="serviceHourId" id="serviceHourId">
              <input hidden type="text" name="bookingDate" id="bookingDate">
              <input hidden type="text" name="staffId" id="staffId">
              <input hidden type="text" name="user_id" id="userId">
              <input hidden type="text" name="max_person" id="bmax_person">
              <div class="form-group">
                <select name="gateway" id="gateway" class="form-control form-select niceselect">
                  <!--option selected disabled>{{ __('Choose a Payment Method') }}</option-->
                  @foreach ($online_gateways as $getway)
                    <option @selected(old('gateway') == $getway->keyword) value="{{ $getway->keyword }}">
                      {{ 'Pay with a Credit or Debit Card' }}
                    </option>
                  @endforeach
                  @if (count($offline_gateways) > 0)
                    @foreach ($offline_gateways as $offlineGateway)
                      <option @selected(old('gateway') == $offlineGateway->id) value="{{ $offlineGateway->id }}">
                        {{ __($offlineGateway->name) }}</option>
                    @endforeach
                  @endif
                </select>
                <span id="err_gateway" class="mt-4 mb-0 text-danger em"></span>
              </div>

              <!-- Stripe Payment Will be Inserted here -->
              <div id="stripe-element" class="mb-2 mt-4">
                <!-- A Stripe Element will be inserted here. -->
              </div>
              <!-- Used to display form errors -->
              <div id="stripe-errors" class="pb-2" role="alert"></div>

              <!-- Authorize.net Payment Will be Inserted here -->
              <div class="row gateway-details pb-4 d-none" id="authorizenet-element">
                <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <input class="form-control" type="text" id="anetCardNumber" placeholder="Card Number"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetExpMonth" placeholder="Expire Month"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetExpYear" placeholder="Expire Year"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetCardCode" placeholder="Card Code" disabled />
                  </div>
                </div>
                <input type="hidden" name="opaqueDataValue" id="opaqueDataValue" disabled />
                <input type="hidden" name="opaqueDataDescriptor" id="opaqueDataDescriptor" disabled />
                @php
                  $display = 'none';
                @endphp
                <ul id="authorizeNetErrors" style="display: {{ $display }}"></ul>
              </div>
              @foreach ($offline_gateways as $offlineGateway)
                <div class="@if ($errors->has('attachment') && request()->session()->get('gatewayId') == $offlineGateway->id) d-block @else d-none @endif offline-gateway-info"
                  id="{{ 'offline-gateway-' . $offlineGateway->id }}">
                  @if (!is_null($offlineGateway->short_description))
                    <div class="form-group mb-4">
                      <label class="font-weight-bold text-dark">{{ __('Description') }}</label>


                      <p>{{ $offlineGateway->short_description }}</p>
                    </div>
                  @endif

                  @if (!is_null($offlineGateway->instructions))
                    <div class="form-group mb-4">
                      <label class="font-weight-bold text-dark">{{ __('Instructions') }}</label>
                      {!! replaceBaseUrl($offlineGateway->instructions, 'summernote') !!}
                    </div>
                  @endif

                  @if ($offlineGateway->has_attachment == 1)
                    <div class="form-group mb-4">
                      <label>{{ __('Attachment') . '*' }}</label>
                      <br>
                      <input type="file" class="form-control" name="attachment" id="offline-attachment">
                      <span id="err_attachment" class="mt-2 mb-0 text-danger em"></span>
                    </div>
                  @endif

                </div>
                <span id="err_currency" class="mt-2 mb-0 text-danger em"></span>
              @endforeach
              <div class="mt-2">
                <button id="featuredBtn"
                  class="btn btn-lg btn-primary btn-gradient w-100">{{ __('Make Payment') }}</button>
              </div>
            </form>
          </div>
          <div class="btn-groups justify-content-center w-100 mt-20">
            <a href="javaScript:void(0)" id="payment_prev" class="btn-text color-primary icon-start"
              onclick="bookingStepper.previous()" target="_self"><i
                class="fal fa-long-arrow-left"></i>{{ __('Prev Step') }}</a>
          </div>
        </div>
      </div>

      <div id="confirm" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="confirm-trigger">
        <div class="confirm-area pt-4">
          <div class="image text-center mb-30">
            <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
              data-src="{{ asset('assets/frontend/images/book-success.png') }}" alt="Image">
          </div>
          <div class="section-title title-center mb-30">
            <h4 class="title col-lg-8">
              {{ __('Congratulations') . '!' }}<br>
              @if (isset($bookingInfo))
                @if ($bookingInfo->gateway_type == 'offline')
                  {{ __('Wait for the payment confirmation mail') }}<br>
                @else
                  {{ __('You have booked this service successfully') }}
                @endif
              @endif
            </h4>
          </div>
          <div>
            @if (isset($bookingInfo))
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-center align-items-center">
                    <h5 class="p-0">
                      {{ __('Booking No.') . ' ' . '#' . $bookingInfo->order_number }}</h5>
                  </div>
                </div>
                <div class="card-body">
                  <div class="payment-information">
                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Service Title') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        @if ($bookingInfo->serviceContent->isNotEmpty())
                          @foreach ($bookingInfo->serviceContent as $content)
                            <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $bookingInfo->service->id]) }}"
                              class="btn-text color-primary" target="_blank">
                              {{ truncateString($content->name, 50) }}
                            </a>
                          @endforeach
                        @endif
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Booking Date') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        {{ date_format($bookingInfo->created_at, 'M d, Y') }}
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Appointment Date') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        {{ \Carbon\Carbon::parse($bookingInfo->booking_date)->format('M d, Y') }}
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Appointment Time') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        {{ $bookingInfo->start_date }} -
                        {{ $bookingInfo->end_date }}
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Vendor') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        @if ($bookingInfo->vendor_id != 0)
                          <a
                            href="{{ route('frontend.vendor.details', $bookingInfo->vendor->username) }}">{{ $bookingInfo->vendor->username }}</a>
                        @else
                          <a
                            href="{{ route('frontend.vendor.details', $admin->username) }}">{{ $admin->username }}</a>
                        @endif
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Paid Amount') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        {{ $bookingInfo->currency_text_position == 'left' ? $bookingInfo->currency_text . ' ' : '' }}{{ number_format($bookingInfo->customer_paid, 2, '.', ',') }}{{ $bookingInfo->currency_text_position == 'right' ? ' ' . $bookingInfo->currency_text : '' }}
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Paid Via') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        {{ $bookingInfo->payment_method }}
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-lg-6">
                        <strong>{{ __('Payment Status') . ' :' }}</strong>
                      </div>

                      <div class="col-lg-6">
                        @if ($bookingInfo->payment_status == 'completed')
                          <span class="badge bg-success">{{ __('completed') }}</span>
                        @elseif ($bookingInfo->payment_status == 'pending')
                          <span class="badge bg-warning">{{ __('pending') }}</span>
                        @else
                          <span class="badge bg-danger">{{ __('rejected') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <div class="btn-groups justify-content-center w-100 mt-20">
            <button href="javaScript:void(0)" class="btn btn-lg btn-primary btn-gradient" target="_self"
              data-bs-dismiss="modal" aria-label="Close">{{ __('Close') }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
