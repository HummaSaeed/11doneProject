@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ __('Home') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_home }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_home }}
  @endif
@endsection
@section('content')
  <!-- Home-area start-->
  <section class="hero-banner hero-banner-1 parallax">
    <div class="container container-lg-fluid">
      <div class="row align-items-center gx-xl-5">
        <div class="col-lg-7">
          <div class="fluid-left">
            <div class="banner-content mb-40">
              <h1 class="title mb-30" data-aos="fade-up" data-aos-delay="100">
                {{ !empty($sectionContent->hero_section_title) ? $sectionContent->hero_section_title : 'Find Anything From Nearest Location To Make A Booking' }}
              </h1>
              <p class="text" data-aos="fade-up" data-aos-delay="100">
                {{ !empty($sectionContent->hero_section_subtitle) ? $sectionContent->hero_section_subtitle : 'Link Build is an advanced and modern-looking directory script with rich SEO features where you can create your.' }}
              </p>
              <div class="banner-filter-form mt-40" data-aos="fade-up" data-aos-delay="150">
                <div class="form-wrapper shadow-md bg-white p-20 radius-md">
                  <form id="homepage_search" action="{{ route('frontend.services') }}" method="get">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                          <label for="service_location" class="text-gradient"><i
                              class="fal fa-map-marker-alt"></i></label>
                          <input type="text" id="service_location" name="location" class="form-control"
                            placeholder="{{ __('Search By Location') }}">
                          <div class="vr"></div>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="input-group">
                          <label for="service_title" class="text-gradient"><i class="fal fa-clipboard-list"></i></label>
                          <input type="text" id="service_name" name="service_title" class="form-control"
                            placeholder="{{ __('Search Service') }}">
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-6">
                        <button type="submit" class="btn btn-lg btn-primary icon-start w-100">
                          <i class="fal fa-search"></i>
                          {{ __('Find Now') }}
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5" data-aos="fade-up">
          <div class="banner-image mb-40 parallax-img" data-speed="0.5" data-revert="true">
            <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
              data-src="{{ asset('assets/img/hero/' . @$sectionContent->hero_section_background_img) }}"
              alt="Banner Image">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Home-area end -->
  @if (count($after_hero) > 0)
    @foreach ($after_hero as $cusHero)
      @if (isset($homecusSec[$cusHero->id]))
        @if ($homecusSec[$cusHero->id] == 1)
          @php
            $cusHeroContent = App\Models\CustomSectionContent::where('custom_section_id', $cusHero->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusHeroContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Category-area start -->
  @if ($secInfo->category_section_status == 1)
    <section class="category-area category-1 pb-100">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-center mb-50" data-aos="fade-up">
              <h2 class="title mb-0">
                {{ !empty($sectionContent->category_section_title) ? $sectionContent->category_section_title : 'Most Popular Categories' }}
              </h2>
            </div>
          </div>
          <div class="col-12" data-aos="fade-up">
            @if (count($categories) == 0)
              <h4 class="text-center">{{ __('NO CATEGORIES FOUND') }}!</h4>
            @else
              <div class="swiper category-slider" id="category-slider-1" data-slides-per-view="5"
                data-swiper-loop="false">
                <div class="swiper-wrapper">
                  @foreach ($categories as $category)
                    <style>
                      .category-area.category-1 .swiper-slide .card-icon.icon-bg{{ $loop->iteration }} {
                        background-color: #{{ $category->background_color }};
                        box-shadow: 0 15px 30px -12px rgba({{ hexdec(substr($category->background_color, 0, 2)) }}, {{ hexdec(substr($category->background_color, 2, 2)) }}, {{ hexdec(substr($category->background_color, 4, 2)) }}, 0.7);
                      }

                      .category-area.category-1 .swiper-slide .card:hover .card-title.title-hover{{ $loop->iteration }} {
                        color: #{{ $category->background_color }};
                      }
                    </style>
                    <a href="{{ route('frontend.services', ['category' => $category->slug]) }}" target="_self">
                      <div class="swiper-slide">
                        <div class="card p-25 border radius-md text-center">
                          <div class="card-icon icon-bg{{ $loop->iteration }} radius-md mx-auto mb-20">
                            <i class="{{ $category->icon }}"></i>
                          </div>
                          <h4 class="card-title title-hover{{ $loop->iteration }} lc-1 mb-1">
                            <a href="{{ route('frontend.services', ['category' => $category->slug]) }}" target="_self"
                              title="{{ $category->name }}">
                              {{ $category->name }}
                            </a>
                          </h4>
                          <span class="font-sm">
                            @if ($category->service_count > 1)
                              {{ $category->service_count }}
                              {{ __('Services Available') }}
                            @elseif($category->service_count == 1)
                              {{ $category->service_count }}
                              {{ __('Service Available') }}
                            @endif
                          </span>
                        </div>
                      </div>
                    </a>
                  @endforeach
                </div>
                <div class="swiper-pagination position-static mt-40" id="category-slider-1-pagination"></div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Category-area end -->
  @if (count($after_category) > 0)
    @foreach ($after_category as $cusCategory)
      @if (isset($homecusSec[$cusCategory->id]))
        @if ($homecusSec[$cusCategory->id] == 1)
          @php
            $cusCategoryContent = App\Models\CustomSectionContent::where('custom_section_id', $cusCategory->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusCategoryContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Works-area start -->
  @if ($secInfo->work_process_section_status == 1)
    <section class="works-area works-1 pt-100 pb-60 bg-img bg-cover"
      data-bg-image="{{ !empty($sectionContent->work_process_background_img) ? asset('assets/img/' . $sectionContent->work_process_background_img) : asset('assets/frontend/images/work-process.png') }}">

      <div class="container">
        <div class="row align-items-center gx-xl-5">
          <div class="col-lg-5">
            <div class="content-title mb-40" data-aos="fade-up">
              <h2 class="title mb-25 color-white">
                {{ !empty($sectionContent->workprocess_section_title) ? $sectionContent->workprocess_section_title : 'How appointment Booking System Works' }}
              </h2>
              <p class="color-white">
                {{ !empty($sectionContent->workprocess_section_subtitle) ? $sectionContent->workprocess_section_subtitle : 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind. ' }}
              </p>
              @if (!empty($sectionContent->workprocess_section_url))
                <div class="mt-30">
                  <a href="{{ @$sectionContent->workprocess_section_url }}"
                    class="btn btn-lg btn-primary btn-gradient icon-start">
                    <i class="{{ @$sectionContent->workprocess_icon }}"></i>
                    {{ @$sectionContent->workprocess_section_btn }}
                  </a>
                </div>
              @endif
            </div>
          </div>
          <div class="col-lg-7">
            <div class="swiper works-slider mb-40" id="works-slider-1" data-aos="fade-up">
              <div class="swiper-wrapper">
                @foreach ($processes as $processe)
                  <style>
                    .works-area.works-1 .swiper-slide .card.card-bg{{ $loop->iteration }} {
                      background-color: #{{ $processe->background_color }};
                      background-image: linear-gradient(-35deg, #{{ $processe->background_color }} 0%, #021B79 100%);
                    }
                  </style>
                  <div class="swiper-slide">
                    <div class="card card-bg{{ $loop->iteration }} p-30 radius-lg">
                      <div class="card-icon color-white">
                        <i class="{{ $processe->icon }}"></i>
                      </div>
                      <div class="line bg-white my-3 rounded-pill"></div>
                      <h4 class="card-title color-white lc-1 mb-15">
                        {{ $processe->title }}
                      </h4>
                      <p class="card-text color-light">
                        {{ $processe->text }}
                      </p>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="swiper-pagination position-static mt-30" id="works-slider-1-pagination"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Works-area end -->
  @if (count($after_work_process) > 0)
    @foreach ($after_work_process as $work_process)
      @if (isset($homecusSec[$work_process->id]))
        @if ($homecusSec[$work_process->id] == 1)
          @php
            $work_processContent = App\Models\CustomSectionContent::where('custom_section_id', $work_process->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $work_processContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Service-area start -->
  @if ($secInfo->feature_section_status == 1)
    <section class="service-area service-1 ptb-100">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-inline mb-50" data-aos="fade-up">
              <h2 class="title">
                {{ !empty($sectionContent->featured_service_section_title) ? $sectionContent->featured_service_section_title : 'Our Top Featured Services' }}
              </h2>
              <!-- Slider navigation buttons -->
              @if ($featured_services->count() > 4)
                <div class="slider-navigation">
                  <button type="button" title="Slide prev" class="slider-btn" id="product-slider-1-prev">
                    <i class="fal fa-angle-left"></i>
                  </button>
                  <button type="button" title="Slide next" class="slider-btn" id="product-slider-1-next">
                    <i class="fal fa-angle-right"></i>
                  </button>
                </div>
              @endif
            </div>
          </div>
          <div class="col-12">
            @if ($featured_services->count() == 0)
              <h4 class="text-center">{{ __('NO SERVICE FOUND') . '!' }}</h4>
            @else
              <!-- Slider main container -->
              <div class="swiper product-slider" id="product-slider-1" data-slides-per-view="4"
                data-swiper-loop="false" data-aos="fade-up">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                  @foreach ($featured_services as $service)
                    <!-- Slides -->
                    <div class="swiper-slide">
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
                            <a href="{{ route('frontend.services', ['category_id' => $category->categoryId]) }}">
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
                              target="_self" title="{{ $service->name }}">
                              {{ truncateString($service->name, 60) }}
                            </a>
                          </h6>
                          <input type="hidden" value="{{ $service->language_id }}">
                          <div class="author mb-10 mt-10">
                            @if ($service->vendor_id != 0)
                              @if ($service->vendor->photo != null)
                                <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                                  target="_self" title="{{ $service->vendor->username }}">
                                  <img class="lazyload blur-up"
                                    src="{{ asset('assets/frontend/images/placeholder.png') }}"
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
                              title="Book Now" target="_self">
                              {{ __('Book Now') }}</a>
                          </div>
                        </div>
                      </div><!-- product-default -->
                    </div>
                  @endforeach

                </div>

                <!-- If we need pagination -->
                <div class="swiper-pagination position-static" id="product-slider-1-pagination"></div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Service-area end -->
  
  <!-- Why Choose Us section start -->
  <section class="why-choose-us-area ptb-100 bg-primary-light">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title title-center mb-50" data-aos="fade-up">
            <h2 class="title mb-20">{{ __('Why Choose Us') }}</h2>
            <p class="text">{{ __('We provide the best service with experienced professionals') }}</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <div class="card text-center p-30 radius-md mb-30 shadow-md bg-white">
            <div class="card-icon mx-auto mb-20 rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="fal fa-certificate fa-2x text-white"></i>
            </div>
            <h4 class="card-title mb-15">{{ __('Certified & Experienced Professionals') }}</h4>
            <p class="card-text">{{ __('Our team consists of certified and highly experienced professionals dedicated to providing top-quality service') }}</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="card text-center p-30 radius-md mb-30 shadow-md bg-white">
            <div class="card-icon mx-auto mb-20 rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="fal fa-tags fa-2x text-white"></i>
            </div>
            <h4 class="card-title mb-15">{{ __('Affordable & Transparent Pricing') }}</h4>
            <p class="card-text">{{ __('We offer competitive and transparent pricing with no hidden fees, ensuring you get the best value for your money') }}</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="card text-center p-30 radius-md mb-30 shadow-md bg-white">
            <div class="card-icon mx-auto mb-20 rounded-circle bg-info d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="fal fa-headset fa-2x text-white"></i>
            </div>
            <h4 class="card-title mb-15">{{ __('24/7 Customer Support') }}</h4>
            <p class="card-text">{{ __('Our dedicated support team is available round the clock to assist you with any questions or concerns') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Why Choose Us section end -->
  
  <!-- How It Works section start -->
  <section class="how-it-works-area ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title title-center mb-50" data-aos="fade-up">
            <h2 class="title mb-20">{{ __('How It Works') }}</h2>
            <p class="text">{{ __('Book your service in 4 simple steps') }}</p>
          </div>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="card text-center p-30 radius-lg mb-30 position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <div class="position-absolute" style="top: -20px; right: -20px; font-size: 100px; opacity: 0.1; color: white; font-weight: bold;">01</div>
            <div class="card-icon mx-auto mb-20 rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
              <i class="fal fa-search fa-2x" style="color: #667eea;"></i>
            </div>
            <h4 class="card-title mb-15 text-white">{{ __('Search Service') }}</h4>
            <p class="card-text text-white opacity-75">{{ __('Browse and find the perfect service that meets your needs') }}</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="card text-center p-30 radius-lg mb-30 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none;">
            <div class="position-absolute" style="top: -20px; right: -20px; font-size: 100px; opacity: 0.1; color: white; font-weight: bold;">02</div>
            <div class="card-icon mx-auto mb-20 rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
              <i class="fal fa-calendar-alt fa-2x" style="color: #f5576c;"></i>
            </div>
            <h4 class="card-title mb-15 text-white">{{ __('Select Date & Time') }}</h4>
            <p class="card-text text-white opacity-75">{{ __('Choose your preferred date and time slot from available options') }}</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="card text-center p-30 radius-lg mb-30 position-relative overflow-hidden" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
            <div class="position-absolute" style="top: -20px; right: -20px; font-size: 100px; opacity: 0.1; color: white; font-weight: bold;">03</div>
            <div class="card-icon mx-auto mb-20 rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
              <i class="fal fa-credit-card fa-2x" style="color: #00f2fe;"></i>
            </div>
            <h4 class="card-title mb-15 text-white">{{ __('Make Payment') }}</h4>
            <p class="card-text text-white opacity-75">{{ __('Complete your booking with secure online payment options') }}</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="card text-center p-30 radius-lg mb-30 position-relative overflow-hidden" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border: none;">
            <div class="position-absolute" style="top: -20px; right: -20px; font-size: 100px; opacity: 0.1; color: white; font-weight: bold;">04</div>
            <div class="card-icon mx-auto mb-20 rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
              <i class="fal fa-check-circle fa-2x" style="color: #43e97b;"></i>
            </div>
            <h4 class="card-title mb-15 text-white">{{ __('Get Confirmation') }}</h4>
            <p class="card-text text-white opacity-75">{{ __('Receive instant confirmation and enjoy your booked service') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- How It Works section end -->
  
  @if (count($after_featured_service) > 0)
    @foreach ($after_featured_service as $cusFeature)
      @if (isset($homecusSec[$cusFeature->id]))
        @if ($homecusSec[$cusFeature->id] == 1)
          @php
            $cusFeatureContent = App\Models\CustomSectionContent::where('custom_section_id', $cusFeature->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusFeatureContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Action banner start -->
  @if ($secInfo->call_to_action_section_status == 1)
    <section class="action-banner">
      <div class="container">
        <div class="wrapper radius-md pt-40 px-60 bg-img bg-cover"
          data-bg-image="{{ asset('assets/img/' . @$sectionContent->call_to_action_section_image) }}">
          <div class="row align-items-center gx-xl-5">
            <div class="col-lg-6">
              <div class="content-title mb-40" data-aos="fade-up">
                <h2 class="title color-white mb-25">
                  {{ !empty($sectionContent->call_to_action_section_title) ? $sectionContent->call_to_action_section_title : '' }}
                </h2>
                <p class="color-light">
                  {{ !empty($sectionContent->action_section_text) ? $sectionContent->action_section_text : '' }}</p>
                @if (!empty($sectionContent->call_to_action_url))
                  <div class="mt-30">
                    <a href="{{ @$sectionContent->call_to_action_url }}"
                      class="btn btn-lg btn-primary btn-gradient icon-start"><i
                        class="{{ @$sectionContent->call_to_action_icon }}"></i>{{ @$sectionContent->call_to_action_section_btn }}</a>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-lg-6">
              <div class="image mb-40" data-aos="fade-left">
                <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                  data-src="{{ asset('assets/img/' . @$sectionContent->call_to_action_section_inner_image) }}"
                  alt="Image">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Action banner end -->
  @if (count($after_call_to_action) > 0)
    @foreach ($after_call_to_action as $cusAction)
      @if (isset($homecusSec[$cusAction->id]))
        @if ($homecusSec[$cusAction->id] == 1)
          @php
            $cusActionContent = App\Models\CustomSectionContent::where('custom_section_id', $cusAction->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusActionContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Service-area start -->
  @if ($secInfo->latest_service_section_status == 1)
    <section class="service-area service-1 ptb-100">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-center mb-50" data-aos="fade-up">
              <h2 class="title mb-20">
                {{ !empty($sectionContent->latest_service_section_title) ? $sectionContent->latest_service_section_title : 'Most Popular Booking Services We Offer' }}
              </h2>
              @if (count($categories) > 0)
                <div class="tabs-navigation">
                  <ul class="nav nav-tabs" data-hover="fancyHover">
                    <li class="nav-item active">
                      <button class="nav-link hover-effect active btn-md radius-sm" data-bs-toggle="tab"
                        data-bs-target="#forAll" type="button">{{ __('All Services') }}</button>
                    </li>
                    @foreach ($categories as $category)
                      <li class="nav-item">
                        <button class="nav-link hover-effect btn-md radius-sm" data-bs-toggle="tab"
                          data-bs-target="#serviceTab{{ $category->id }}"
                          type="button">{{ $category->name }}</button>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
          </div>
          <div class="col-12">
            @if (count($services) == 0)
              <h4 class="text-center">{{ __('NO SERVICE FOUND') }}!</h4>
            @else
              <div class="tab-content" data-aos="fade-up">
                <div class="tab-pane fade show active" id="forAll">
                  <div class="row">
                    @foreach ($services as $service)
                      <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up">
                        <div class="product-default border radius-md p-15 mb-25">
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
                              <a href="{{ route('frontend.services', ['category_id' => $service->categoryId]) }}">
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
                                target="_self">
                                {{ truncateString($service->name, 60) }}
                              </a>
                            </h6>
                            <input type="hidden" value="{{ $service->language_id }}">
                            <div class="author mb-10 mt-10">
                              @if ($service->vendor_id != 0)
                                @if ($service->vendor->photo != null)
                                  <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                                    target="_self" title="{{ $service->vendor->username }}">
                                    <img class="lazyload blur-up"
                                      src="{{ asset('assets/frontend/images/placeholder.png') }}"
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
                                  <img class="lazyload blur-up"
                                    src="{{ asset('assets/frontend/images/placeholder.png') }}"
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
                                title="Book Now" target="_self">
                                {{ __('Book Now') }}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="cta-btn text-center mt-15">
                    <a href="{{ route('frontend.services') }}" class="btn btn-lg btn-primary btn-gradient icon-start"
                      title="View More" target="_self"><i class="fal fa-arrow-right"></i>{{ __('View More') }}</a>
                  </div>
                </div>
                @foreach ($categories as $category)
                  @php
                    $vendorStatus = App\Models\Vendor::where('status', 1)->select('id')->get()->toArray();
                    $services = App\Models\Services\Services::join(
                        'service_contents',
                        'service_contents.service_id',
                        '=',
                        'services.id',
                    )
                        ->join('service_categories', 'service_categories.id', '=', 'service_contents.category_id')
                        ->where('service_contents.language_id', $language->id)
                        ->where('service_categories.language_id', $language->id)
                        ->where('service_contents.category_id', $category->id)
                        ->where(function ($query) use ($vendorStatus) {
                            $query->whereIn('services.vendor_id', $vendorStatus)->orWhere('services.vendor_id', 0);
                        })
                        ->when('services.vendor_id' != '0', function ($query) {
                            return $query
                                ->leftJoin('memberships', 'services.vendor_id', '=', 'memberships.vendor_id')
                                ->where(function ($query) {
                                    $query
                                        ->where([
                                            ['memberships.status', '=', 1],
                                            ['memberships.start_date', '<=', now()->format('Y-m-d')],
                                            ['memberships.expire_date', '>=', now()->format('Y-m-d')],
                                        ])
                                        ->orWhere('services.vendor_id', '=', 0);
                                });
                        })
                        ->select(
                            'services.*',
                            'service_contents.name',
                            'service_contents.address',
                            'service_contents.slug',
                        )
                        ->paginate(8);
                  @endphp
                  @if (count($services) > 0)
                    <div class="tab-pane fade" id="serviceTab{{ $category->id }}">
                      <div class="row">
                        @foreach ($services as $service)
                          <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up">
                            <div class="product-default border radius-md p-15 mb-25">
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
                                    class="btn btn-icon border radius-sm {{ $checkWishList == false ? '' : 'wishlist-active' }}"
                                    data-tooltip="tooltip" data-bs-placement="right"
                                    title="{{ $checkWishList == false ? __('Save to Wishlist') : __('Saved') }}">
                                    <i class="fal fa-heart"></i>
                                  </a>
                                </div>
                                <h6 class="product-title mb-0">
                                  <a href="{{ route('frontend.service.details', ['slug' => $service->slug, 'id' => $service->id]) }}"
                                    target="_self" title="{{ $service->name }}">
                                    {{ truncateString($service->name, 60) }}
                                  </a>
                                </h6>
                                <div class="author mb-10 mt-10">
                                  @if ($service->vendor_id != 0)
                                    @if ($service->vendor->photo)
                                      <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                                        target="_self" title="{{ $service->vendor->username }}">
                                        <img class="lazyload blur-up"
                                          src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                          data-src="{{ asset('assets/admin/img/vendor-photo/' . $service->vendor->photo) }}"
                                          alt="Image">
                                      </a>
                                    @else
                                      <a href="{{ route('frontend.vendor.details', ['username' => $service->vendor->username]) }}"
                                        target="_self" title="{{ $service->vendor->username }}">
                                        <img class="lazyload"
                                          src="{{ asset('assets/frontend/images/placeholder.png') }}"
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
                                      <img class="lazyload blur-up"
                                        src="{{ asset('assets/frontend/images/placeholder.png') }}"
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
                                @if ($service->zoom_meeting == 1)
                                  <span class="font-sm icon-start"><i
                                      class="fal fa-video"></i>{{ __('Online') }}</span>
                                @endif
                                <div class="d-flex align-items-center justify-content-between gap-2 mt-10">
                                  <div class="product-price">
                                    <span class="h6 new-price">{{ symbolPrice($service->price) }}</span>
                                    <span
                                      class="prev-price font-sm">{{ $service->prev_price ? symbolPrice($service->prev_price) : '' }}</span>
                                  </div>
                                  <a href="javaScript:void(0)" class="bookNowBtn btn btn-sm btn-outline-2"
                                    data-bs-toggle="modal" data-bs-target="#makeBooking"
                                    data-id="{{ $service->id }}" title="Book Now" target="_self">
                                    {{ __('Book Now') }}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                      <div class="cta-btn text-center mt-15">
                        <a href="{{ route('frontend.services', ['category_id' => $category->id]) }}"
                          class="btn btn-lg btn-primary btn-gradient icon-start" target="_self"><i
                            class="fal fa-arrow-right"></i>{{ __('View More') }}</a>
                      </div>
                    </div>
                  @endif
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Service-area end -->
  @if (count($after_latest_service) > 0)
    @foreach ($after_latest_service as $cusLatestServie)
      @if (isset($homecusSec[$cusLatestServie->id]))
        @if ($homecusSec[$cusLatestServie->id] == 1)
          @php
            $cusLatestServieContent = App\Models\CustomSectionContent::where('custom_section_id', $cusLatestServie->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusLatestServieContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Shop-area start -->
  @if ($secInfo->vendor_featured_section_status == 1)
    <section class="shop-area shop-1 pb-100">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="section-title title-inline mb-50" data-aos="fade-up">
              <h2 class="title">
                {{ !empty($sectionContent->vendor_section_title) ? $sectionContent->vendor_section_title : 'Our Top Featured Vendor' }}
              </h2>
              @if ($vendors > 0)
                <a href="{{ route('frontend.vendors') }}" class="btn btn-lg btn-primary btn-gradient icon-start"
                  title="View All Vendor" target="_self"><i class="fal fa-arrow-right"></i>
                  @if ($vendors > 1)
                    {{ __('View All Vendors') }}
                  @else
                    {{ __('View All Vendor') }}
                  @endif
                </a>
              @endif
            </div>
          </div>
          <div class="col-12">
            @if ($featuredVendors->count() == 0)
              <h4 class="text-center">{{ __('NO VENDOR FOUND') . '!' }}</h4>
            @else
              <!-- Slider main container -->
              <div class="swiper product-slider" id="product-slider-2" data-slides-per-view="4"
                data-swiper-loop="false" data-aos="fade-up">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                  <!-- Slides -->
                  @foreach ($featuredVendors as $vendor)
                    <div class="swiper-slide">
                      <div class="product-default border radius-md p-15 mb-25">
                        <figure class="product-img mb-15">
                          <a href="{{ route('frontend.vendor.details', ['username' => $vendor->username]) }}"
                            title="Image" target="_self" class="lazy-container radius-sm ratio ratio-2-3">
                            @if ($vendor->photo)
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}"
                                alt="Vendor">
                            @else
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                            @endif
                          </a>
                        </figure>
                        <div class="product-details">
                          @php
                            $vendorInfo = App\Models\VendorInfo::where([
                                ['vendor_id', $vendor->vendorId],
                                ['language_id', $language->id],
                            ])->first();
                          @endphp
                          <h6 class="product-title mb-0">
                            <a href="{{ route('frontend.vendor.details', ['username' => $vendor->username]) }}"
                              target="_self" title="{{ $vendor->username }}">
                              @if ($vendorInfo->name != null)
                                {{ $vendorInfo->name }}
                              @else
                                {{ $vendor->username }}
                              @endif
                            </a>
                          </h6>
                          @if ($vendorInfo)
                            @if ($vendorInfo->address != null)
                              <span class="font-sm icon-start"><i
                                  class="fal fa-map-marker-alt"></i>{{ truncateString($vendorInfo->address, 30) }}</span>
                            @endif
                          @endif
                          <div class="d-flex align-items-center gap-15 mt-10">
                            <a href="{{ route('frontend.vendor.details', ['username' => $vendor->username]) }}"
                              class="btn btn-sm btn-outline-2" title="{{ __('Visit Store') }}"
                              target="_self">{{ __('Visit Store') }}</a>
                            <span class="font-sm">
                              @if ($vendor->total_service > 1)
                                {{ $vendor->total_service }}
                                {{ __('Services Available') }}
                              @elseif($vendor->total_service == 1)
                                {{ $vendor->total_service }}
                                {{ __('Services Available') }}
                              @else
                                {{ __('No Service Available') }}
                              @endif
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>

                <!-- If we need pagination -->
                <div class="swiper-pagination position-static" id="product-slider-2-pagination"></div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- Shop-area end -->
  @if (count($after_vendor) > 0)
    @foreach ($after_vendor as $cusVendor)
      @if (isset($homecusSec[$cusVendor->id]))
        @if ($homecusSec[$cusVendor->id] == 1)
          @php
            $cusVendorContent = App\Models\CustomSectionContent::where('custom_section_id', $cusVendor->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusVendorContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Testimonial-area start -->
  @if ($secInfo->testimonial_section_status == 1)
    <section class="testimonial-area testimonial-1 parallax pb-60">
      <div class="container container-lg-fluid">
        <div class="row align-items-center gx-xl-5">
          <div class="col-lg-6">
            <div class="fluid-left">
              <div class="content-title mb-40" data-aos="fade-up">
                <h2 class="title mb-20">
                  {{ !empty($sectionContent->testimonial_section_title) ? $sectionContent->testimonial_section_title : 'What Customers Say About Our Booking Systems ' }}
                </h2>
                <div class="content-text mb-40">
                  <p>
                    {{ !empty($sectionContent->testimonial_section_subtitle) ? $sectionContent->testimonial_section_subtitle : 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum omnis natus cumque possimus dicta suscipit enim, aperiam, voluptatum quis deleniti. ' }}
                  </p>
                </div>
              </div>
              @if (count($testimonials) > 0)
                <div class="swiper mb-40" id="testimonial-slider-1" data-aos="fade-up">
                  <div class="swiper-wrapper">
                    @foreach ($testimonials as $testimonial)
                      <div class="swiper-slide">
                        <div class="slider-item radius-md">
                          <div class="client gap-20 flex-wrap">
                            <div class="client-info d-flex align-items-center">
                              <div class="client-img">
                                <div class="lazy-container rounded-pill ratio ratio-1-1">
                                  <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                    data-src="{{ asset('assets/img/clients/' . $testimonial->image) }}"
                                    alt="Person Image">
                                </div>
                              </div>
                              <div class="content">
                                <h6 class="name mb-0">{{ $testimonial->name }}</h6>
                                <span class="designation font-sm">{{ $testimonial->occupation }}</span>
                              </div>
                            </div>
                            <div class="rating-area flex-column align-items-start">
                              <div class="ratings">
                                <div class="rate bg-img"
                                  data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                  <div class="rating-icon bg-img"
                                    data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}"
                                    style="width: {{ $testimonial->rating * 20 . '%;' }}">
                                  </div>
                                </div>
                              </div>
                              <span class="ratings-total">
                                {{ $testimonial->rating }} {{ __('star of') }}
                                {{ $total_testimonial }}
                                @if ($total_testimonial > 1)
                                  {{ __('reviews') }}
                                @else
                                  {{ __('review') }}
                                @endif
                              </span>
                            </div>
                          </div>
                          <div class="quote">
                            <span class="icon"><i class="fal fa-quote-right"></i></span>
                            <p class="text font-lg mb-0">
                              {{ $testimonial->comment }}
                            </p>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <div class="swiper-pagination position-static mt-30" id="testimonial-slider-1-pagination">
                  </div>
                </div>
              @else
                <h4>{{ __('NO TESTIMONIAL FOUND') }}!</h4>
              @endif
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left">
            <div class="image mb-40 parallax-img" data-speed="0.5" data-revert="true">
              <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                data-src="{{ asset('assets/img/' . @$sectionContent->testimonial_section_image) }}" alt="Image">
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  @if (count($after_testimonial) > 0)
    @foreach ($after_testimonial as $cusTest)
      @if (isset($homecusSec[$cusTest->id]))
        @if ($homecusSec[$cusTest->id] == 1)
          @php
            $cusTestContent = App\Models\CustomSectionContent::where('custom_section_id', $cusTest->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          @include('frontend.home.custom-section', ['data' => $cusTestContent])
        @endif
      @endif
    @endforeach
  @endif
  <!-- Testimonial-area end -->
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

  <script>
    @if (old('gateway') == 'stripe')
      $('#stripe-element').removeClass('d-none');
    @endif
  </script>
@endsection
