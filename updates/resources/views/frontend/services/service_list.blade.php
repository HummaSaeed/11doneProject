@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->service_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_services }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_services }}
  @endif
@endsection
@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->service_page_title : __('Services'),
  ])
  <!-- Listing-list-area start -->
  <div class="listing-area pt-100 pb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <!--- services side-bar-->
        @includeIf('frontend.services.side-bar')
        <div class="col-lg-8 col-xl-9">
          <div class="sort-area" data-aos="fade-up">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <h5 class="mb-20">
                  @if ($total_services > 1)
                    <span class="color-primary" id="total-service">
                      {{ $total_services }}
                    </span>
                    {{ __('Services Found') }}
                  @elseif ($total_services == 1)
                    <span class="color-primary" id="total-service">
                      {{ $total_services }}
                    </span>
                    {{ __('Service Found') }}
                  @else
                    {{ __('No Service Available') }}
                  @endif
                </h5>
              </div>
              <div class="col-4 d-lg-none">
                <button class="btn btn-sm btn-outline icon-end radius-sm mb-20" type="button" data-bs-toggle="offcanvas"
                  data-bs-target="#widgetOffcanvas" aria-controls="widgetOffcanvas">
                  {{ __('Filter') }} <i class="fal fa-filter"></i>
                </button>
              </div>
              <div class="col-8 col-lg-6">
                <ul class="sort-list list-unstyled mb-20">
                  <li class="item">
                    <div class="sort-item d-flex align-items-center">
                      <label class="me-2 font-sm">{{ __('Sort By') }}:</label>
                      <select name="sort" class="sort nice-select right color-dark">
                        <option {{ request()->input('newest') == 'default' ? 'selected' : '' }} value="newest">
                          {{ __('Date : Newest on top') }}
                        </option>
                        <option {{ request()->input('sort') == 'oldest' ? 'selected' : '' }} value="oldest">
                          {{ __('Date : Oldest on top') }}
                        </option>
                        <option {{ request()->input('sort') == 'high-to-low' ? 'selected' : '' }} value="high-to-low">
                          {{ __('Price : High to Low') }}</option>
                        <option {{ request()->input('sort') == 'low-to-high' ? 'selected' : '' }} value="low-to-high">
                          {{ __('Price : Low to High') }}</option>
                      </select>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div id="search_container">
            <div class="row">
              @foreach ($featuredServices as $service)
                <div class="col-xl-4 col-sm-6" data-aos="fade-up">
                  <div class="product-default border radius-md p-15 mb-25 featured">
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
                        <a href="{{ route('frontend.services', ['category_id' => $service->categoryid]) }}">
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
                            data-tooltip="tooltip" data-bs-placement="right"
                            title="{{ $checkWishList == false ? __('Save to Wishlist') : __('Saved') }}">
                            <i class="fal fa-heart"></i>
                          </a>
                      </div>
                      <h6 class="product-title mb-0">
                        <a href="{{ route('frontend.service.details', ['slug' => $service->slug, 'id' => $service->id]) }}"
                          target="_self" title="service">
                          {{ truncateString($service->name, 60) }}
                        </a>
                      </h6>
                      <input type="hidden" value="{{ $service->language_id }}">
                      
                      
                      
                      
                      
                      <!--div class="author mb-10 mt-10">
                        @if ($service->vendor_id != 0)
                          @if ($service->vendor->photo != null)
                            <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                              target="_self" title="{{ $service->vendor->username }}">
                              <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/admin/img/vendor-photo/' . $service->vendor->photo) }}"
                                alt="Image">
                            </a>
                          @else
                            <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                              target="_self" title="{{ $service->vendor->username }}">
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                            </a>
                          @endif
                          <span class="font-sm">
                            {{ __('By') }} <a
                              href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                              target="_self" title="John Doe">{{ $service->vendor->username }}</a>
                          </span>
                        @else
                          <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}"
                            target="_self" title="{{ $admin->username }}">
                            <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                              data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="Image">
                          </a>
                          <span class="font-sm">
                            {{ __('By') }} <a
                              href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}"
                              target="_self" title="{{ $admin->username }}">{{ $admin->username }}</a>
                          </span>
                        @endif
                      </div>
                      @if (!empty($service->address))
                        <span class="font-sm icon-start"><i
                            class="fal fa-map-marker-alt"></i>{{ truncateString($service->address, 30) }}</span>
                      @endif
                      -->
                      
                      
                      
                      
                      @if ($service->zoom_meeting == 1)
                        <span class="font-sm icon-start"><i class="fal fa-video"></i>{{ __('Online') }}</span>
                      @endif
                      <div class="d-flex align-items-center justify-content-between gap-2 mt-10">
                        <div class="product-price">
                          <span class="h6 new-price"> {{ symbolPrice($service->price) }}</span>
                          <span
                            class="prev-price font-sm">{{ $service->prev_price ? symbolPrice($service->prev_price) : '' }}</span>
                        </div>
                        <a href="javaScript:void(0)" class="bookNowBtn btn btn-sm btn-outline-2" data-bs-toggle="modal"
                          data-id="{{ $service->id }}" data-bs-target="#makeBooking" target="_self">
                          {{ __('Book Now') }}</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach

              @foreach ($services as $service)
                <div class="col-xl-4 col-sm-6" data-aos="fade-up">
                  <div class="product-default border radius-md p-15 mb-25">
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
                          data-tooltip="tooltip" data-bs-placement="right"
                          title="{{ $checkWishList == false ? __('Save to Wishlist') : __('Saved') }}">
                          <i class="fal fa-heart"></i>
                        </a>
                      </div>
                      <h6 class="product-title mb-0">
                        <a href="{{ route('frontend.service.details', ['slug' => $service->slug, 'id' => $service->id]) }}"
                          target="_self" title="service">
                          {{ truncateString($service->name, 60) }}
                        </a>
                      </h6>
                      <input type="hidden" value="{{ $service->language_id }}">
                      
                      
                      
                      
                      <!--div class="author mb-10 mt-10">
                        @if ($service->vendor_id != 0)
                          @if ($service->vendor->photo != null)
                            <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                              target="_self" title="{{ $service->vendor->username }}">
                              <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/admin/img/vendor-photo/' . $service->vendor->photo) }}"
                                alt="Image">
                            </a>
                          @else
                            <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                              target="_self" title="{{ $service->vendor->username }}">
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                            </a>
                          @endif
                          <span class="font-sm">
                            {{ __('By') }} <a
                              href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                              target="_self"
                              title="{{ $service->vendor->username }}">{{ $service->vendor->username }}</a>
                          </span>
                        @else
                          <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}"
                            target="_self" title="{{ $admin->username }}">
                            <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                              data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="Image">
                          </a>
                          <span class="font-sm">
                            {{ __('By') }} <a
                              href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}"
                              target="_self">{{ $admin->username }}</a>
                          </span>
                        @endif
                      </div>
                      @if (!empty($service->address))
                        <span class="font-sm icon-start"><i
                            class="fal fa-map-marker-alt"></i>{{ truncateString($service->address, 30) }}</span>
                      @endif
                      -->
                      
                      
                      
                      
                      @if ($service->zoom_meeting == 1)
                        <span class="font-sm icon-start"><i class="fal fa-video"></i>{{ __('Online') }}</span>
                      @endif
                      <div class="d-flex align-items-center justify-content-between gap-2 mt-10">
                        <div class="product-price">
                          <span class="h6 new-price"> {{ symbolPrice($service->price) }}</span>
                          <span
                            class="prev-price font-sm">{{ $service->prev_price ? symbolPrice($service->prev_price) : '' }}</span>
                        </div>
                        <a href="javaScript:void(0)" class="bookNowBtn btn btn-sm btn-outline-2"
                          data-bs-target="#makeBooking" data-bs-toggle="modal" data-id="{{ $service->id }}"
                          target="_self">
                          {{ __('Book Now') }}</a>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <!--pagination -->
            <nav class="pagination-nav pb-25" data-aos="fade-up">
              <ul class="pagination justify-content-center">
                {{ $services->appends([
                        'category_id' => request()->input('category_id'),
                        'min_val' => request()->input('min_val'),
                        'max_val' => request()->input('max_val'),
                        'rating' => request()->input('rating'),
                        'sort_val' => request()->input('sort_val'),
                    ])->links() }}
              </ul>
            </nav>
          </div>
          @if (!empty(showAd(3)))
            <div class="text-center mt-4 mb-40">
              {!! showAd(3) !!}
            </div>
          @endif
          <form id="searchForm" action="{{ route('frontend.services.category.search') }}" method="get">
            <input type="hidden" id="category" name="category" value="{{ request()->input('category') }}">
            <input type="hidden" id="min_val" name="min_val" value="{{ request()->input('min_val') }}">
            <input type="hidden" id="max_val" name="max_val" value="{{ request()->input('max_val') }}">
            <input type="hidden" id="rating" name="rating" value="{{ request()->input('rating') }}">
            <input type="hidden" id="sort_val" name="sort_val" value="{{ request()->input('sort_val') }}">
            <input type="hidden" id="page" value="{{ request()->input('page') }}">
            <input type="hidden" id="location_val" name="location_val"
              value="{{ request()->input('location_val') }}">
            <input type="hidden" id="service_title" name="service_title"
              value="{{ request()->input('service_title') }}">
            <input type="hidden" id="service_type" name="service_type"
              value="{{ request()->input('service_type') }}">
          </form>

          <!-- Spacer -->
          <div class="mb-15"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Listing-list-area end -->
@endsection
@section('script')
  <script src="{{ asset('assets/frontend/js/service_search.js') }}"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ $authorizeUrl }}"></script>
  <script>
    let searchUrl = "{{ route('frontend.services.category.search') }}";
    let stripe_key = "{{ $stripe_key }}";
    let authorize_login_key = "{{ $authorize_login_id }}";
    let authorize_public_key = "{{ $authorize_public_key }}";
    var complete = "{{ Session::get('complete') }}";
    var bookingInfo = {!! json_encode(Session::get('paymentInfo')) !!};
  </script>
  <script src="{{ asset('assets/frontend/js/appointment.js') }}"></script>

  <script>
    @if (old('gateway') == 'stripe')
      $('#stripe-element').removeClass('d-none');
    @endif
  </script>
@endsection
