@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->about_us_title : __('About Us') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_about_page }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_about_page }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->about_us_title : __('About Us'),
  ])

  @if ($secInfo->about_section_status == 1)
    <section class="about-area pt-100 pb-60">
      <div class="container">
        <div class="row align-items-center gx-xl-5">
          <div class="col-lg-6">
            <div class="image img-left mb-40">
              <img class="blur-up lazyload" src="{{ asset('assets/img/about-us/' . $about->about_section_image) }}"
                alt="Image">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="content-title mb-40">
              <span class="subtitle">{{ @$about->title }}</span>
              <h2 class="title mb-20 mt-0">
                {{ @$about->subtitle }}
              </h2>
              <p>
                {!! @$about->text !!}
              </p>
              @if (!empty($about->button_url))
                <a href="{{ $about->button_url }}"
                  class="btn btn-lg btn-primary icon-start ">{{ $about->button_text }}</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  @if (count($after_about) > 0)
    @foreach ($after_about as $customAbout)
      @if (isset($aboutSec[$customAbout->id]))
        @if ($aboutSec[$customAbout->id] == 1)
          @php
            $afAboutCon = App\Models\CustomSectionContent::where('custom_section_id', $customAbout->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          <section class="custom-section-area pt-100 pb-60">
            <div class="container">
              <div class="section-title title-center mb-50" data-aos="fade-up">
                <h2 class="title mb-0">
                  {{ @$afAboutCon->section_name }}
                </h2>
              </div>
              <div class="row align-items-center gx-xl-5">
                {!! $afAboutCon->content !!}
              </div>
            </div>
          </section>
        @endif
      @endif
    @endforeach
  @endif

  <!-- Feature-area start -->
  @if ($secInfo->features_section_status == 1)
    <section class="feature-area feature-1 ptb-70">
      <div class="container">
        <div class="section-title title-center mb-50" data-aos="fade-up">
          <h2 class="title mb-0">
            {{ @$about->features_title }}
          </h2>
        </div>
        <div class="row">
          @if (count($features) > 0)
            @foreach ($features as $feature)
              <div class="col-xl-3 col-lg-4 col-md-6 item">
                <div class="card p-25 border radius-md mb-30">
                  <div class="card-icon radius-md mb-20">
                    <i class="{{ $feature->icon }}"></i>
                  </div>
                  <h4 class="card-title mb-15">
                    {{ $feature->title }}
                  </h4>
                  <p class="text">
                    {{ $feature->text }}
                  </p>
                </div>
              </div>
            @endforeach
          @endif
        </div>
        @if (!empty(showAd(3)))
          <div class="text-center mt-4">
            {!! showAd(3) !!}
          </div>
        @endif
      </div>
    </section>
  @endif
  <!-- Feature-area end -->

  @if (count($after_features) > 0)
    @foreach ($after_features as $Cufeatures)
      @if (isset($aboutSec[$Cufeatures->id]))
        @if ($aboutSec[$Cufeatures->id] == 1)
          @php
            $cuFeatures = App\Models\CustomSectionContent::where('custom_section_id', $Cufeatures->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          <section class="custom-section-area pt-100 pb-60">
            <div class="container">
              <div class="section-title title-center mb-50" data-aos="fade-up">
                <h2 class="title mb-0">
                  {{ @$cuFeatures->section_name }}
                </h2>
              </div>
              <div class="row align-items-center gx-xl-5">
                {!! @$cuFeatures->content !!}
              </div>
            </div>
          </section>
        @endif
      @endif
    @endforeach
  @endif


  <!-- Works-area start -->
  @if ($basicInfo->theme_version != 2)
    @if ($secInfo->about_work_status == 1)
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
  @endif
  @if ($basicInfo->theme_version == 2)
    @if ($secInfo->about_work_status == 1)
      <section class="works-area works-2 pt-100 pb-70 bg-primary-light">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <div class="section-title title-center mb-50" data-aos="fade-up">
                <h2 class="title">
                  {{ !empty($sectionContent->workprocess_section_title) ? $sectionContent->workprocess_section_title : 'How the Appointment Booking System Works ' }}
                </h2>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                @foreach ($processes as $processe)
                  <div class="col-xl-3 col-lg-4 col-sm-6" data-aos="fade-up">
                    <div class="card p-30 radius-lg text-center mb-30 shadow-md">
                      <div class="card-img mb-20">
                        <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                          data-src="{{ asset('assets/img/workprocess/' . $processe->image) }}" alt="Image">
                      </div>
                      <h4 class="card-title lc-1 mb-0">
                        {{ $processe->title }}
                      </h4>
                      <span class="h1 color-primary stroke-gradient">0{{ $loop->iteration }}</span>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </section>
    @endif
  @endif
  <!-- Works-area end -->
  @if (count($after_work_process) > 0)
    @foreach ($after_work_process as $Cuwork_process)
      @if (isset($aboutSec[$Cuwork_process->id]))
        @if ($aboutSec[$Cuwork_process->id] == 1)
          @php
            $cuWorkProcess = App\Models\CustomSectionContent::where('custom_section_id', $Cuwork_process->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          <section class="custom-section-area pt-100 pb-60">
            <div class="container">
              <div class="section-title title-center mb-50" data-aos="fade-up">
                <h2 class="title mb-0">
                  {{ @$cuWorkProcess->section_name }}
                </h2>
              </div>
              <div class="row align-items-center gx-xl-5">
                {!! @$cuWorkProcess->content !!}
              </div>
            </div>
          </section>
        @endif
      @endif
    @endforeach
  @endif
  @if ($secInfo->about_testimonial_section_status == 1)
    <section class="testimonial-area testimonial-1 parallax ptb-60">
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
    @foreach ($after_testimonial as $Cutestimonial)
      @if (isset($aboutSec[$Cutestimonial->id]))
        @if ($aboutSec[$Cutestimonial->id] == 1)
          @php
            $cuTestimonial = App\Models\CustomSectionContent::where('custom_section_id', $Cutestimonial->id)
                ->where('language_id', $currentLanguageInfo->id)
                ->first();
          @endphp
          <section class="custom-section-area pt-100 pb-60">
            <div class="container">
              <div class="section-title title-center mb-50" data-aos="fade-up">
                <h2 class="title mb-0">
                  {{ @$cuTestimonial->section_name }}
                </h2>
              </div>
              <div class="row align-items-center gx-xl-5">
                {!! @$cuTestimonial->content !!}
              </div>
            </div>
          </section>
        @endif
      @endif
    @endforeach
  @endif

  @if (!empty(showAd(3)))
    <div class="text-center mt-5 mb-5">
      {!! showAd(3) !!}
    </div>
  @endif
@endsection
