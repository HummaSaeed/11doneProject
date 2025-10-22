@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@php
  $service = $details->content->first();
  $title = !empty($service) ? truncateString($service->name, 40) : 'Service Details';
@endphp
@section('pageHeading')
  @if (!empty($title))
    {{ $title ? $title : __('Service Details') }}
  @endif
@endsection

@section('metaKeywords')
  @if ($service)
    {{ $service->meta_keyword }}
  @endif
@endsection

@section('metaDescription')
  @if ($service)
    {{ $service->meta_description }}
  @endif
@endsection
@section('content')
  <!-- Page title start-->
  <div class="page-title-area bg-img bg-cover header-next"
    @if (!empty($bgImg->breadcrumb)) data-bg-image="{{ asset('assets/img/' . $bgImg->breadcrumb) }}" @endif>
    <div class="container">
      <div class="content">
        <h2>{{ !empty($title) ? $title : '' }}</h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              {{ !empty($pageHeading) ? $pageHeading->service_page_title : __('Service Details') }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- Page title end-->

  <!-- Listing-single-area start -->
  <div class="listing-single-area ptb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-8 col-xl-9">
          <div class="product-single-gallery mb-40" data-aos="fade-up">
            <div class="swiper product-single-slider radius-md">
              <div class="swiper-wrapper">
                @foreach ($details->sliderImage as $item)
                  <div class="swiper-slide">
                    <figure class="lazy-container ratio ratio-2-3">
                      <a href="{{ asset('assets/img/services/service-gallery/' . $item->image) }}"
                        class="lightbox-single">
                        <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                          data-src="{{ asset('assets/img/services/service-gallery/' . $item->image) }}"
                          alt="Service image" />
                      </a>
                    </figure>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="product-thumb">
              <div class="swiper slider-thumbnails">
                <div class="swiper-wrapper">
                  @foreach ($details->sliderImage as $item)
                    <div class="swiper-slide">
                      <div class="thumbnail-img radius-sm lazy-container ratio ratio-2-3">
                        <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                          data-src="{{ asset('assets/img/services/service-gallery/' . $item->image) }}"
                          alt="Service image" />
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!-- Slider navigation buttons -->
            <div class="slider-navigation position-middle">
              <button type="button" title="Slide prev" class="slider-btn slider-btn-prev" id="product-single-btn-prev">
                <i class="fal fa-angle-left"></i>
              </button>
              <button type="button" title="Slide next" class="slider-btn slider-btn-next" id="product-single-btn-next">
                <i class="fal fa-angle-right"></i>
              </button>
            </div>
          </div>
          <div class="product-single-details">
            <div class="row" data-aos="fade-up">
              <div class="col-md-8">
                <a href="{{ route('frontend.services', ['category_id' => $service->category->id]) }}">
                  <span class="product-category">{{ @$service->category->name }}</span>
                </a>
                <h3 class="product-title my-1">{{ $service->name }}</h3>
                @if (!empty($service->address))
                  <!--span class="font-sm icon-start"><i class="fal fa-map-marker-alt"></i>{{ $service->address }}</span-->
                @endif
                @if ($details->zoom_meeting == 1)
                  <span class="font-sm icon-start"><i class="fal fa-video"></i>{{ __('Online') }}</span>
                @endif
              </div>
              <div class="col-md-4">
                <div class="product-price mb-10">
                  <h4 class="new-price"> {{ symbolPrice($details->price) }}</h4>
                  <span
                    class="old-price h6 color-medium text-decoration-linethrough">{{ $details->prev_price ? symbolPrice($details->prev_price) : '' }}</span>
                </div>
                
                
                
                
                
                <!--div class="author mb-20">
                  <div class="image">
                    @if ($details->vendor_id != 0)
                      @if ($details->vendor->photo != null)
                        <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                          <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                            data-src="{{ asset('assets/admin/img/vendor-photo/' . $details->vendor->photo) }}"
                            alt="{{ $details->vendor->username }}">
                        </a>
                      @else
                        <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                          <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                            data-src="{{ asset('assets/img/user.png') }}" alt="{{ $details->vendor->username }}">
                        </a>
                      @endif
                    @else
                      <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}">
                        <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                          data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="Image">
                      </a>
                    @endif
                  </div>
                  <div class="author-info">

                    <h6 class="mb-2 lh-1">
                      {{ __('By') }}
                      @if ($details->vendor_id != 0)
                        <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                          {{ $details->vendor->username }}
                        </a>
                      @else
                        <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}">
                          {{ $admin->username }}
                        </a>
                      @endif
                    </h6>
                    <div class="ratings">
                      <div class="rate bg-img" data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                        @php
                          $ratingStaticWidth = '0%';
                        @endphp
                        @if (!empty($details->average_rating))
                          <div class="rating-icon bg-img" style="width: {{ $details->average_rating * 20 . '%;' }}"
                            data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                          </div>
                        @else
                          <div class="rating-icon bg-img" style="width:{{ $ratingStaticWidth }}"
                            data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                          </div>
                        @endif
                      </div>
                      <span class="ratings-total">
                        @if ($details->average_rating > 0)
                          {{ $details->average_rating }} {{ __('Ratings') }}
                        @else
                          (0 {{ __('Rating') }})
                        @endif
                      </span>
                    </div>
                  </div>
                </div-->
              </div>
            </div>
            <!-- Booking description -->
            <div class="product-desc pt-40" data-aos="fade-up">
              <h4 class="mb-15">{{ __('Service Description') }}</h4>
              <p>
                {!! $service->description !!}
              </p>

            </div>
            <!-- Featured list -->
            @if ($service->features != null)
              <div class="featured-list pt-40 mb-20" data-aos="fade-up">
                <h4 class="mb-15">{{ __('Service Features') }}</h4>
                <ul class="list-unstyled">
                  @php
                    $parts = explode("\n", $service->features);
                  @endphp
                  @foreach ($parts as $part)
                    <li class="icon-start">
                      <i class="fal fa-check-square"></i>
                      <span>{{ trim($part) }}</span>
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Book now button -->
            <div class="booking-form mt-40" data-aos="fade-up">
              <div class="form-wrapper border bg-white px-3 pt-3 radius-md">
                <div class="row align-items-center">
                  <!--div class="col-lg-8 col-sm-12">
                    <h6 class="mb-3">
                      {{ __('Do you want to book this service') }}?
                    </h6>
                  </div-->
                  <center><div class="col-lg-4 col-sm-6">
                    <button type="button" class="bookNowBtn btn btn-lg btn-primary icon-start w-100 mb-3"
                      data-bs-toggle="modal" data-bs-target="#makeBooking" data-id="{{ $details->id }}"
                      title="Book Now" target="_self">
                      {{ __('Book Now') }}
                    </button>
                  </div> 
                  </center>
                  
                  
                </div>
              </div>
            </div>
            @if (count($related_services) > 0)
              <!-- Booking slider -->
              <div class="service-area pt-60">
                <h4 class="mb-15">
                  @if (count($related_services) > 1)
                    {{ __('Related Services') }}
                  @else
                    {{ __('Related Service') }}
                  @endif
                </h4>

                <!-- Slider main container -->
                <div class="swiper product-inline-slider" id="product-inline-slider-1" data-slides-per-view="3"
                  data-swiper-loop="false" data-aos="fade-up">
                  <!-- Additional required wrapper -->
                  <div class="swiper-wrapper">
                    <!-- Slides -->
                    @foreach ($related_services as $related_service)
                      <div class="swiper-slide">
                        <div class="product-default border radius-md p-15 mb-25">
                          <figure class="product-img mb-15">
                            <a href="{{ route('frontend.service.details', ['slug' => $related_service->slug, 'id' => $related_service->id]) }}"
                              title="Image" target="_self" class="lazy-container radius-sm ratio ratio-2-3">
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/img/services/' . $related_service->service_image) }}"
                                alt="Service">
                            </a>
                          </figure>
                          <div class="product-details">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                              <a
                                href="{{ route('frontend.services', ['category_id' => $related_service->category_id]) }}">
                                <span class="tag font-sm">
                                  {{ $related_service->category_name }}
                                </span>
                              </a>
                              @if (Auth::guard('web')->check())
                                @php
                                  $user_id = Auth::guard('web')->user()->id;
                                  $checkWishList = checkWishList($related_service->id, $user_id);
                                @endphp
                              @else
                                @php
                                  $checkWishList = false;
                                @endphp
                              @endif
                              <a href="{{ $checkWishList == false ? route('addto.wishlist', $related_service->id) : route('remove.wishlist', $related_service->id) }}"
                                class="btn btn-icon border radius-sm {{ $checkWishList == false ? '' : 'wishlist-active' }}"
                                data-tooltip="tooltip" data-bs-placement="right"
                                title="{{ $checkWishList == false ? __('Save to Wishlist') : __('Saved') }}">
                                <i class="fal fa-heart"></i>
                              </a>

                            </div>
                            <h6 class="product-title mb-0">
                              <a href="{{ route('frontend.service.details', ['slug' => $related_service->slug, 'id' => $related_service->id]) }}"
                                target="_self" title="{{ $related_service->name }}">
                                {{ truncateString($related_service->name, 50) }}
                              </a>
                            </h6>
                            <input type="hidden" value="{{ $related_service->language_id }}">
                            <div class="author mb-10 mt-10">
                              @if ($related_service->vendor_id != 0)
                                @if ($related_service->vendor->photo != null)
                                  <a href="{{ route('frontend.vendor.details', ['username' => $related_service->vendor->username]) }}"
                                    target="_self" title="{{ $related_service->vendor->username }}">
                                    <img class="lazyload blur-up"
                                      src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                      data-src="{{ asset('assets/admin/img/vendor-photo/' . $related_service->vendor->photo) }}"
                                      alt="Image">
                                  </a>
                                @else
                                  <a href="{{ route('frontend.vendor.details', ['username' => $related_service->vendor->username]) }}"
                                    target="_self" title="{{ $related_service->vendor->username }}">
                                    <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                      data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                                  </a>
                                @endif
                                <span class="font-sm">
                                  {{ __('By') }} <a
                                    href="{{ route('frontend.vendor.details', ['username' => $related_service->vendor->username]) }}"
                                    target="_self"
                                    title="{{ $related_service->vendor->username }}">{{ $related_service->vendor->username }}</a>
                                </span>
                              @else
                                <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}"
                                  target="_self" title="{{ $admin->username }}">
                                  <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                    data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="Vendor">
                                </a>
                                <span class="font-sm">
                                  {{ __('By') }} <a
                                    href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}"
                                    target="_self" title="{{ $admin->username }}">{{ $admin->username }}</a>
                                </span>
                              @endif
                            </div>
                            @if (!empty($related_service->address))
                              <span class="font-sm icon-start"><i class="fal fa-map-marker-alt"></i>
                                {{ truncateString($related_service->address, 30) }}
                              </span>
                            @endif
                            @if ($related_service->zoom_meeting == 1)
                              <span class="font-sm icon-start"><i class="fal fa-video"></i>{{ __('Online') }}</span>
                            @endif
                            <div class="d-flex align-items-center justify-content-between gap-2 mt-10">
                              <div class="product-price">
                                <span class="h6 new-price"> {{ symbolPrice($related_service->price) }}</span>
                                <span
                                  class="prev-price font-sm">{{ $related_service->prev_price ? symbolPrice($related_service->prev_price) : '' }}</span>
                              </div>
                              <a href="javaScript:void(0)" class="bookNowBtn btn btn-sm btn-outline-2"
                                data-bs-toggle="modal" data-id="{{ $related_service->id }}" title="Book Now"
                                data-bs-target="#makeBooking" target="_self">
                                {{ __('Book Now') }}</a>
                            </div>
                          </div>
                        </div><!-- product-default -->
                      </div>
                    @endforeach
                  </div>
                  <!-- If we need pagination -->
                  <div class="swiper-pagination position-static" id="product-inline-slider-1-pagination"></div>
                </div>
              </div>
            @endif

            <!-- Review area -->
            <!--div class="row pt-40">
              <div class="col-xl-10">
                <div class="review-progresses p-30 radius-md border mb-40" data-aos="fade-up">
                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-30">
                    @php
                      $total_review = App\Models\Services\ServiceReview::where('service_id', $details->id)->count();
                    @endphp
                    <h4 class="mb-0">{{ __('Total Reviews') }}: {{ $total_review }}</h4>
                    <div class="ratings size-md d-flex">
                      <div class="rate bg-img" data-bg-image="{{ asset('assets/frontend/images/rate-star-md.png') }}">
                        @if (!empty($details->average_rating))
                          <div class="rating-icon bg-img" style="width: {{ $details->average_rating * 20 . '%;' }}"
                            data-bg-image="{{ asset('assets/frontend/images/rate-star-md.png') }}">
                          </div>
                        @endif
                      </div>
                      <!--span class="ratings-total font-lg">
                        ({{ $details->average_rating ? $details->average_rating : 0 }})
                      </span>
                    </div>
                  </div>

                  @php
                    $ratings = [
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Stars',
                    ];
                  @endphp

                  @foreach ($ratings as $rating => $label)
                    @php
                      $totalReviewForRating = App\Models\Services\ServiceReview::where('service_id', $details->id)
                          ->where('rating', $rating)
                          ->count();
                      $percentage = $total_review > 0 ? round(($totalReviewForRating / $total_review) * 100) : 0;
                    @endphp

                    <div class="review-progress color-dark mb-10 row align-items-center justify-content-between">
                      <span class="col-2">{{ __($label) }}</span>
                      <div class="progress-line col-9">
                        <div class="progress">
                          <div class="progress-bar bg-primary" style="width: {{ $percentage . '%' }}"
                            role="progressbar" aria-label="{{ $label }}" aria-valuenow="{{ $percentage }}"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>

                @if (count($reviews) == 0)
                  <h5>{{ __('This service has no review yet') . '!' }}</h5>
                @else
                  <h5 class="title mb-15">
                    {{ __('All Reviews') }}
                  </h5>
                  @foreach ($reviews as $review)
                    <div class="review-box mb-10" data-aos="fade-up">
                      <div class="review-list mb-30 border radius-md">
                        <div class="review-item p-30">
                          <div class="review-header mb-20">
                            <div class="author d-flex align-items-center justify-content-between gap-3">
                              <div class="author-img">
                                @if (empty($review->user->image))
                                  <img class="lazyload blur-up"
                                    src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                    data-src="{{ asset('assets/img/user.png') }}" alt="Person Image">
                                @else
                                  <img class="lazyload blur-up"
                                    src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                    data-src="{{ asset('assets/img/users/' . $review->user->image) }}"
                                    alt="Person Image">
                                @endif
                              </div>
                              <div class="author-info">
                                <h6 class="mb-1">
                                  <a href="#" target="_self" title="Link">{{ $review->user->name }}</a>
                                </h6>
                                <div class="ratings mb-1">
                                  <div class="rate bg-img"
                                    data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                    <div class="rating-icon bg-img" style="width: {{ $review->rating * 20 . '%;' }}"
                                      data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                    </div>
                                  </div>
                                  <span class="ratings-total">({{ $review->rating }})</span>
                                </div>
                                <span class="font-xsm icon-start">
                                  <span class="color-green"><i class="fas fa-badge-check"></i></span>
                                  {{ __('Verified User') }}
                                </span>
                              </div>
                            </div>
                            <div class="more-info font-sm">
                              <div class="icon-start">
                                <i
                                  class="fal fa-map-marker-alt"></i>{{ $review->user->address }},{{ $review->user->country }}
                              </div>
                              <div class="icon-start"><i
                                  class="fal fa-clock"></i>{{ $review->created_at->diffForHumans() }}
                              </div>
                            </div>
                          </div>
                          {{ $review->comment }}
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
                @guest('web')
                  <div class="cta-btn mt-20">
                    <a href="{{ route('user.login', ['redirect_path' => 'product-details']) }}"
                      class="btn btn-md btn-primary">
                      {{ __('Login') }}
                    </a>
                  </div>
                @endguest

                @auth('web')
                  <div class="shop-review-form mt-30">
                    <h5 class="title mb-10">
                      {{ __('Add Review') }}
                    </h5>
                    <form action="{{ route('frontend.service.rating.store', ['id' => $details->id]) }}" method="POST"
                      id="reviewSubmitForm">
                      @csrf
                      <div class="form-group mb-20">
                        <textarea class="form-control" placeholder="{{ __('Comment') }}" name="comment">{{ old('comment') }}</textarea>
                      </div>
                      <div class="form-group">
                        <label class="mb-1">{{ __('Rating') . '*' }}</label>
                        <ul class="rating list-unstyled mb-20">
                          <li class="review-value review-1">
                            <span class="fas fa-star" data-ratingVal="1"></span>
                          </li>
                          <li class="review-value review-2">
                            <span class="fas fa-star" data-ratingVal="2"></span>
                            <span class="fas fa-star" data-ratingVal="2"></span>
                          </li>
                          <li class="review-value review-3">
                            <span class="fas fa-star" data-ratingVal="3"></span>
                            <span class="fas fa-star" data-ratingVal="3"></span>
                            <span class="fas fa-star" data-ratingVal="3"></span>
                          </li>
                          <li class="review-value review-4">
                            <span class="fas fa-star" data-ratingVal="4"></span>
                            <span class="fas fa-star" data-ratingVal="4"></span>
                            <span class="fas fa-star" data-ratingVal="4"></span>
                            <span class="fas fa-star" data-ratingVal="4"></span>
                          </li>
                          <li class="review-value review-5">
                            <span class="fas fa-star" data-ratingVal="5"></span>
                            <span class="fas fa-star" data-ratingVal="5"></span>
                            <span class="fas fa-star" data-ratingVal="5"></span>
                            <span class="fas fa-star" data-ratingVal="5"></span>
                            <span class="fas fa-star" data-ratingVal="5"></span>
                          </li>
                        </ul>
                      </div>
                      <input type="hidden" id="rating-id" name="rating">
                      <input type="hidden" value="{{ $details->vendor_id }}" name="vendor_id">
                      <div class="form-group">
                        <input type="submit" class="btn btn-lg btn-primary" value="{{ __('Submit') }}">
                      </div>
                    </form>
                  </div>
                @endauth
              </div>
            </div>
            <!-- Review area -->
          </div>
        </div>

        @includeIf('frontend.services.details-sidebar')
      </div>
    </div>
  </div>
  <!-- Listing-single-area start -->
@endsection
@section('script')
  <script src="{{ asset('assets/frontend/js/vendors/leaflet.js') }}"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ $authorizeUrl }}"></script>
  <script>
    "use strict";
    let stripe_key = "{{ $stripe_key }}";
    let authorize_login_key = "{{ $authorize_login_id }}";
    let authorize_public_key = "{{ $authorize_public_key }}";
    var complete = "{{ Session::get('complete') }}";
    var bookingInfo = {!! json_encode(Session::get('paymentInfo')) !!}; //after success a payment show there info
    // Address to be geocoded
    var latitude = "{{ $details->latitude }}";
    var longitude = "{{ $details->longitude }}";
  </script>

  <script src="{{ asset('assets/frontend/js/appointment.js') }}"></script>
  <script src="{{ asset('assets/frontend/js/init-map.js') }}"></script>
  <script>
    @if (old('gateway') == 'stripe')
      $('#stripe-element').removeClass('d-none');
    @endif
  </script>
@endsection
