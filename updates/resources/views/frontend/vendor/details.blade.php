@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@section('pageHeading')
  {{ $vendor->username }}
@endsection
@section('metaKeywords')
  {{ $vendor->username }}, {{ !request()->filled('admin') ? @$vendorInfo->name : '' }}
@endsection

@section('metaDescription')
  {{ !request()->filled('admin') ? @$vendorInfo->details : '' }}
@endsection

@section('content')
  <!-- Page title start-->
  <div class="page-title-area bg-img bg-cover header-next"
    @if (!empty($bgImg)) data-bg-image="{{ asset('assets/img/' . $bgImg->breadcrumb) }}" @endif>
    <div class="container">
      <div class="content">
        <div class="author">
          <figure class="author-img">
            <a href="javaScript:void(0)" class="lazy-container radius-md ratio ratio-1-1">
              @if ($vendor->photo)
                <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                  data-src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}" alt="Vendor">
              @else
                <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                  data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
              @endif
            </a>
          </figure>
          <div class="author-info">
            <h4 class="color-white mb-1">
              @if ($vendor->username != 'admin')
                @if ($vendorInfo->name)
                  {{ $vendorInfo->name }}
                @else
                  {{ $vendor->username }}
                @endif
              @else
                {{ $vendor->username }}
              @endif
            </h4>
            <span>{{ __('Member since') }}
              {{ Carbon\Carbon::parse($vendor->created_at)->isoFormat('Do MMMM YYYY') }}</span>

            <!--div class="ratings mt-10">
              <div class="rate bg-img" data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                @if (empty($averageRating))
                  @php
                    $display = '0%';
                  @endphp
                  <div class="rating-icon bg-img" style="width: {{ $display }}"
                    data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                  </div>
                @else
                  <div class="rating-icon bg-img" style="width: {{ $averageRating * 20 . '%;' }}"
                    data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                  </div>
                @endif
              </div>
              <span class="ratings-total">
                @if (!empty($averageRating))
                  ({{ $averageRating }} {{ __('Ratings') }})
                @else
                  (0 {{ __('Rating') }})
                @endif
              </span>
            </div-->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page title end-->

  <!-- Listing-single-area start -->
  <div class="listing-single-area ptb-60">
    <div class="container">
      <div class="row gx-xl-4">
        <div class="col-lg-8 col-xl-9">
          <div class="tabs-navigation tabs-navigation-2 border mb-30" data-aos="fade-up">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#default_tab"
                  aria-selected="true">{{ __('All Services') }}</button>
              </li>
              @php
                if (request()->filled('admin')) {
                    $vendor_id = 0;
                } else {
                    $vendor_id = $vendor->id;
                }
              @endphp
              @foreach ($categories as $category)
                @php
                  $category_id = $category->id;
                  $service_content = App\Models\Services\Services::join(
                      'service_contents',
                      'service_contents.service_id',
                      'services.id',
                  )
                      ->where([['vendor_id', $vendor_id], ['services.status', 1]])
                      ->where('service_contents.language_id', $language->id)
                      ->where('service_contents.category_id', $category_id)
                      ->get()
                      ->count();
                @endphp
                @if ($service_content > 0)
                  <li class="nav-item">
                    <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#tab{{ $category->id }}"
                      aria-selected="true">{{ $category->name }}</button>
                  </li>
                @endif
              @endforeach
            </ul>
          </div>
          <div class="tab-content mb-50">
            @if (count($services) == 0)
              <div class="text-center p-30 bg-light radius-md">
                <h5 class="mb-0">{{ __('NO SERVICE FOUND') . ' !' }}</h5>
              </div>
            @else
              <div class="tab-pane show fade active" id="default_tab">
                <div class="row">
                  @foreach ($services as $service)
                    @php
                      $serviceContent = $service->content->first();
                      $today_date = now()->format('Y-m-d');
                      $feature = App\Models\FeaturedService\ServicePromotion::where('order_status', '=', 'approved')
                          ->where('service_id', $service->id)
                          ->whereDate('end_date', '>=', $today_date)
                          ->first();
                    @endphp
                    <div class="col-xl-4 col-sm-6" data-aos="fade-up">
                      <div
                        class="product-default border radius-md p-15 mb-25  @if ($feature) featured @endif">
                        <figure class="product-img mb-15">
                          <a href="{{ route('frontend.service.details', ['slug' => $service->slug, 'id' => $service->id]) }}"
                            title="Image" target="_self" class="lazy-container radius-sm ratio ratio-2-3">
                            <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                              data-src="{{ asset('assets/img/services/' . $service->service_image) }}" alt="Service">
                          </a>
                        </figure>

                        <div class="product-details">
                          <div class="d-flex align-items-center justify-content-between gap-2">
                            <a href="{{ route('frontend.services', ['category_id' => $service->categoryid]) }}">
                              <span class="tag font-sm">{{ $service->categoryName }}</span>
                            </a>
                            @if (Auth::guard('web')->check())
                              @php
                                $user_id = Auth::guard('web')->user()->id;
                                $checkWishList = checkWishList($service->id, $user_id);
                              @endphp
                            @else
                              @php
                                $checkWishList = false;
                              @endphp
                            @endif
                            <a href="{{ $checkWishList == false ? route('addto.wishlist', $service->id) : route('remove.wishlist', $service->id) }}"
                              class="btn btn-icon border radius-sm {{ $checkWishList == false ? '' : 'wishlist-active' }}"
                              title="{{ $checkWishList == false ? __('Save to Wishlist') : __('Saved') }}">
                              <i class="fal fa-heart"></i>
                            </a>
                          </div>
                          <h6 class="product-title mb-0">
                            <a href="{{ route('frontend.service.details', ['slug' => $serviceContent->slug, 'id' => $service->id]) }}"
                              target="_self">
                              {{ truncateString($serviceContent->name, 60) }}
                            </a>
                          </h6>
                          @if (!empty($service->address))
                            <span class="font-sm icon-start"><i
                                class="fal fa-map-marker-alt"></i>{{ truncateString($service->address, 30) }}</span>
                          @endif
                          @if ($service->zoom_meeting == 1)
                            <span class="font-sm icon-start"><i class="fal fa-video"></i>{{ __('Online') }}</span>
                          @endif
                          <div class="d-flex align-items-center justify-content-between gap-2 mt-10">
                            <div class="product-price">
                              <span class="h6 new-price">{{ symbolPrice($service->price) }}</span>
                              <span
                                class="prev-price font-sm">{{ $service->prev_price ? symbolPrice($service->prev_price) : '' }}</span>
                            </div>
                            <a href="javaScript:void(0)" class="bookNowBtn btn btn-sm btn-outline-2"
                              data-bs-toggle="modal" data-bs-target="#makeBooking" data-id="{{ $service->id }}"
                              target="_self">
                              {{ __('Book Now') }}</a>
                          </div>
                        </div>
                      </div><!-- product-default -->
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            @foreach ($categories as $category)
              @php
                $services = App\Models\Services\Services::join(
                    'service_contents',
                    'service_contents.service_id',
                    '=',
                    'services.id',
                )
                    ->join('vendors', 'vendors.id', '=', 'services.vendor_id')
                    ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
                    ->join('vendor_infos', 'vendors.id', '=', 'vendor_infos.vendor_id')
                    ->where('service_contents.language_id', $language->id)
                    ->where('services.status', 1)
                    ->where('vendor_infos.language_id', $language->id)
                    ->where('service_contents.category_id', $category->id)
                    ->where('services.vendor_id', $vendor_id)
                    ->select('services.*', 'service_contents.name', 'service_contents.slug')
                    ->orderBy('id', 'desc')
                    ->paginate(8);
              @endphp
              @if (count($services) > 0)
                <div class="tab-pane fade" id="tab{{ $category->id }}">
                  <div class="row">
                    @foreach ($services as $service)
                      @php
                        $today_date = now()->format('Y-m-d');
                        $feature = App\Models\FeaturedService\ServicePromotion::where('order_status', '=', 'approved')
                            ->where('service_id', $service->id)
                            ->whereDate('end_date', '>=', $today_date)
                            ->first();
                      @endphp
                      <div class="col-xl-4 col-sm-6" data-aos="fade-up">
                        <div
                          class="product-default border radius-md p-15 mb-25 @if ($feature) featured @endif">
                          <figure class="product-img mb-15">
                            <a href="{{ route('frontend.service.details', ['slug' => $service->slug, 'id' => $service->id]) }}"
                              title="Image" target="_self" class="lazy-container radius-sm ratio ratio-2-3">
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/img/services/' . $service->service_image) }}"
                                alt="Service">
                            </a>

                          </figure>
                          <div class="product-details">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                              <a href="{{ route('frontend.services', ['category_id' => $category->id]) }}">
                                <span class="tag font-sm">{{ @$category->name }}</span>
                              </a>
                              @if (Auth::guard('web')->check())
                                @php
                                  $user_id = Auth::guard('web')->user()->id;
                                  $checkWishList = checkWishList($service->id, $user_id);
                                @endphp
                              @else
                                @php
                                  $checkWishList = false;
                                @endphp
                              @endif
                              <a href="{{ $checkWishList == false ? route('addto.wishlist', $service->id) : route('remove.wishlist', $service->id) }}"
                                class="btn btn-icon {{ $checkWishList == false ? '' : 'wishlist-active' }}"
                                data-tooltip="tooltip" data-bs-placement="right"
                                title="{{ $checkWishList == false ? __('Save to Wishlist') : __('Saved') }}">
                                <i class="fal fa-heart"></i>
                              </a>
                            </div>
                            <h6 class="product-title mb-0">
                              <a href="{{ route('frontend.service.details', ['slug' => $service->slug, 'id' => $service->id]) }}"
                                target="_self">
                                {{ truncateString($service->name, 60) }}
                              </a>
                            </h6>
                            @if (!empty($service->address))
                              <span class="font-sm icon-start"><i
                                  class="fal fa-map-marker-alt"></i>{{ truncateString($service->address, 30) }}</span>
                            @endif
                            @if ($service->zoom_meeting == 1)
                              <span class="font-sm icon-start"><i class="fal fa-video"></i>{{ __('Online') }}</span>
                            @endif
                            <div class="d-flex align-items-center justify-content-between gap-2 mt-10">
                              <div class="product-price">
                                <span class="h6 new-price">{{ symbolPrice($service->price) }}</span>
                                <span
                                  class="prev-price font-sm">{{ $service->prev_price ? symbolPrice($service->prev_price) : '' }}</span>
                              </div>
                              <a href="javaScript:void(0)" class="bookNowBtn btn btn-sm btn-outline-2"
                                data-bs-toggle="modal" data-bs-target="#makeBooking" data-id="{{ $service->id }}"
                                target="_self">
                                {{ __('Book Now') }}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <nav class="pagination-nav mt-10" data-aos="fade-up">
                    {{ $services->links() }}
                  </nav>
                </div>
              @endif
            @endforeach
          </div>
          <nav class="pagination-nav pb-25" data-aos="fade-up">
            <ul class="pagination justify-content-center">
              {{ $services->links() }}
            </ul>
          </nav>
        </div>
        <!-- vendor info -->
        <div class="col-lg-4 col-xl-3">
          <aside class="widget-area" data-aos="fade-up">
            <div class="widget widget-author-details border p-25 radius-md mb-30">
              <div class="author mb-20 text-center">
                <figure class="author-img mx-auto mb-15">
                  <div class="lazy-container radius-md ratio ratio-1-1">
                    @if ($vendor->photo != null)
                      <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                        data-src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}" alt="vendor">
                    @else
                      <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                        data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                    @endif
                  </div>
                </figure>
                <div class="author-info">
                  <div class="d-flex flex-column">
                    <h5 class="mb-0">
                      @if ($vendor->username != 'admin')
                        @if ($vendorInfo->name)
                          {{ $vendorInfo->name }}
                        @else
                          {{ $vendor->username }}
                        @endif
                      @else
                        {{ $vendor->username }}
                      @endif
                    </h5>
                    <span>{{ $vendor->username }}</span>
                  </div>
                  @if ($vendor->username != 'admin')
                    @if ($vendor->email_verified_at != null)
                      <span class="font-sm icon-start">
                        <span class="color-green"><i class="fas fa-badge-check"></i></span>
                        {{ __('Verified User') }}
                      </span>
                    @else
                      <span class="font-sm icon-start">
                        <span class="color-red"><i class="fas fa-badge-check"></i></span>
                        {{ __('Unverified User') }}
                      </span>
                    @endif
                  @endif
                </div>
              </div>
              @if ($vendor_details)
                <div class="click-show font-sm">
                  <div class="show-content">
                    {{ $vendor_details }}
                  </div>
                  <div class="read-more-btn">
                    <span>{{ __('Read More') }}</span>
                    <span>{{ __('Read Less') }}</span>
                  </div>
                </div>
              @endif
              <ul class="toggle-list list-unstyled mt-20">
                <li>
                  <span class="first h6 font-sm">{{ __('Total Service') }}</span>
                  <span class="last font-xsm">{{ $total_service ? $total_service : '0' }}</span>
                </li>
                @php
                  $totalAppointment = App\Models\Services\ServiceBooking::where('order_status', 'completed')
                      ->where('vendor_id', $vendor->id)
                      ->count();
                @endphp
                <li>
                  <span class="first h6 font-sm">{{ __('Orders completed') }}</span>
                  <span class="last font-xsm">{{ $totalAppointment ? $totalAppointment : '0' }}</span>
                </li>
                @if ($vendor->show_email_addresss == 1)
                  <li>
                    <span class="first h6 font-sm">{{ __('Email') }}</span>
                    <span class="last font-xsm">{{ $vendor->email }}</span>
                  </li>
                @endif
                @if ($vendor->show_phone_number == 1)
                  @if ($vendor->phone)
                    <li>
                      <span class="first h6 font-sm">{{ __('Phone') }}</span>
                      <span class="last font-xsm">{{ $vendor->phone }}</span>
                    </li>
                  @endif
                @endif
                @if ($vendor->username != 'admin')
                  @if ($vendorInfo->city)
                    <li>
                      <span class="first h6 font-sm">{{ __('City') }}</span>
                      <span class="last font-xsm">{{ $vendorInfo->city }}</span>
                    </li>
                  @endif
                @endif
                @if ($vendor->username != 'admin')
                  @if ($vendorInfo->country)
                    <li>
                      <span class="first h6 font-sm">{{ __('Country') }}</span>
                      <span class="last font-xsm">{{ $vendorInfo->country }}</span>
                    </li>
                  @endif
                @endif
                @if ($vendor->username != 'admin')
                  @if ($vendorInfo->zip_code)
                    <li>
                      <span class="first h6 font-sm">{{ __('Zip Code') }}</span>
                      <span class="last font-xsm">{{ $vendorInfo->zip_code }}</span>
                    </li>
                  @endif
                @endif

                @if ($vendor_address)
                  <li>
                    <span class="first h6 font-sm">{{ __('Address') }}</span>
                    <span class="last font-xsm">{{ $vendor_address }}</span>
                  </li>
                @endif
                <li>
                  <span class="first h6 font-sm">{{ __('Member since') }}</span>
                  <span
                    class="last font-xsm">{{ Carbon\Carbon::parse($vendor->created_at)->isoFormat('Do MMMM YYYY') }}</span>
                </li>
              </ul>
              @if ($vendor->username != 'admin')
                @if ($vendor->show_contact_form == 1)
                  <div class="mt-20">
                    <a href="javaScript:void(0)" data-bs-toggle="modal" data-bs-target="#vendorContact"
                      class="btn btn-md btn-primary btn-gradient w-100" title="Title"
                      target="_self">{{ __('Contact Now') }}</a>
                  </div>
                @endif
              @else
                <div class="mt-20">
                  <a href="javaScript:void(0)" data-bs-toggle="modal" data-bs-target="#vendorContact"
                    class="btn btn-md btn-primary btn-gradient w-100" title="Title"
                    target="_self">{{ __('Contact Now') }}</a>
                </div>
              @endif
            </div>
            <div class="pb-40"></div>
          </aside>
        </div>
      </div>
    </div>
  </div>
  <!-- Listing-single-area end -->

  <!-- Contact Modal Start -->
  <div class="modal fade" id="vendorContact" tabindex="-1" aria-labelledby="vendorContact" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-fullscreen-md-down">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title mb-0" id="contactModalLabel">{{ __('Contact Now') }}</h1>
            <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          <div class="card">
            <form id="vendorContactForm" action="{{ route('vendor.contact.message') }}" method="POST">
              @csrf
              <input type="hidden" value="{{ $vendor->email }}" name="vendor_email">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group mb-20">
                      <input type="text" name="name" class="form-control" id="name"
                        placeholder="{{ __('Enter Your Full Name') }}">
                      <span id="err_name" class="mt-2 mb-0 text-danger em"></span>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group mb-20">
                      <input type="email" name="email" class="form-control" id="email"
                        data-error="Enter your email" placeholder="{{ __('Enter Your Email') }}">
                      <span id="err_email" class="mt-2 mb-0 text-danger em"></span>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group mb-20">
                      <input type="text" name="subject" class="form-control" id=""
                        placeholder="{{ __('Enter Email Subject') }}">
                      <span id="err_subject" class="mt-2 mb-0 text-danger em"></span>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group mb-20">
                      <textarea name="message" id="message" class="form-control" cols="30" rows="8"
                        placeholder="{{ __('Write Your Message') }}"></textarea>
                      <span id="err_message" class="mt-2 mb-0 text-danger em"></span>
                    </div>
                  </div>
                  @if ($info->google_recaptcha_status == 1)
                    <div class="col-md-12">
                      <div class="form-group mb-20">
                        {!! NoCaptcha::renderJs() !!}
                        {!! NoCaptcha::display() !!}
                        <p class="text-danger em" id="err_g-recaptcha-response"></p>
                      </div>
                    </div>
                  @endif
                  <div class="col-md-12">
                    <button type="submit" id="vendorSubmitBtn" class="btn btn-lg btn-primary"
                      title="Send message">{{ __('Send') }}</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Contact Modal End -->
@endsection
@section('script')
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ $authorizeUrl }}"></script>
  <script>
    let stripe_key = "{{ $stripe_key }}";
    let authorize_login_key = "{{ $authorize_login_id }}";
    let authorize_public_key = "{{ $authorize_public_key }}";
    var complete = "{{ Session::get('complete') }}";
    var bookingInfo = {!! json_encode(Session::get('paymentInfo')) !!};
  </script>
  <script src="{{ asset('assets/frontend/js/appointment.js') }}"></script>
  <script src="{{ asset('assets/frontend/js/vendor-contact.js') }}"></script>

  <script>
    @if (old('gateway') == 'stripe')
      $('#stripe-element').removeClass('d-none');
    @endif
  </script>
@endsection
