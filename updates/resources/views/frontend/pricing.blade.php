@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->pricing_page_title : __('Pricing') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_pricing }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_pricing }}
  @endif
@endsection
@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->pricing_page_title : __('Pricing'),
  ])

  <!-- Pricing-area Start -->
  <section class="pricing-area pricing-area_v1 pt-100 pb-70">
    <div class="container">
      <div class="row">
        <div class="col-12">
          @if (!empty($terms) && count($terms) > 0)
            <div class="section-title title-center mb-50" data-aos="fade-up">
              <h2 class="title mb-30">{{ __('Most Affordable Package') }}</h2>
              <div class="tabs-navigation">
                <ul class="nav nav-tabs p-3 radius-md bg-light" data-hover="fancyHover">
                  @foreach ($terms as $term)
                    <li class="nav-item {{ $loop->iteration == ceil($loop->count / 2) ? 'active' : '' }}">
                      <button
                        class="nav-link hover-effect {{ $loop->iteration == ceil($loop->count / 2) ? 'active' : '' }} btn-md radius-sm"
                        data-bs-toggle="tab" data-bs-target="#{{ $term }}"
                        type="button">{{ __("$term") }}</button>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
          <div class="tab-content" data-aos="fade-up">
            @foreach ($terms as $term)
              @php
                $packages = \App\Models\Package::where('status', '1')->where('term', strtolower($term))->get();
              @endphp
              <div class="tab-pane slide {{ $loop->iteration == ceil($loop->count / 2) ? ' show active' : '' }} "
                id="{{ $term }}">
                <div class="row justify-content-center">
                  @foreach ($packages as $package)
                    <div class="col-md-6 col-lg-4 item">
                      <div class="card p-30 mb-30 radius-lg border {{ $package->recommended == 1 ? 'active' : '' }}">
                        <div class="card_top">
                          <div class="card_icon">
                            <i class="{{ $package->icon }}"></i>
                          </div>
                          <div class="label">
                            <h3 class="card_title mb-1">{{ $package->title }}</h3>
                            @if ($package->recommended == 1)
                              <span>{{ __('Recommended') }}</span>
                            @endif
                          </div>
                        </div>
                        <div class="card_subtitle mt-15 d-flex align-items-center">
                          <h4 class="mb-0">
                            @if ($package->price == 0)
                              {{ __('Free') }}
                            @else
                              {{ format_price($package->price) }}
                            @endif
                          </h4>
                          @php
                            $tremText = str_replace('ly', '', $package->term);
                          @endphp
                          <span class="period">/ {{ __("$tremText") }}</span>
                        </div>
                        <ul class="card_list toggle-list list-unstyled mt-25">
                          <li>
                            <span>
                              <i class="fal fa-check"></i>{{ __('Services') }}
                              <span>({{ $package->number_of_service_add === 999999 ? '(' . __('Unlimited') . ')' : $package->number_of_service_add }})
                              </span>
                            </span>

                          </li>
                          <li>
                            <span><i class="fal fa-check"></i>{{ __('Images/Service') }} <span>
                                ({{ $package->number_of_service_image === 999999 ? '(' . __('Unlimited') . ')' : $package->number_of_service_image }})
                              </span></span>

                          </li>
                          <li>
                            <span><i class="fal fa-check"></i>{{ __('Appointments') }} <span>
                                ({{ $package->number_of_appointment === 999999 ? '(' . __('Unlimited') . ')' : $package->number_of_appointment }})</span></span>

                          </li>
                          <li>
                            <span><i class="fal fa-check"></i>{{ __('Staffs') }}
                              <span>
                                ({{ $package->staff_limit === 999999 ? '(' . __('Unlimited') . ')' : $package->staff_limit }})</span></span>

                          </li>
                          @if ($package->support_ticket_status == 1)
                            <li>
                              <span><i class="fal fa-check"></i>{{ __('Support Tickets') }}</span>
                            </li>
                          @else
                            <li>
                              <span><i class="fal fa-times"></i>{{ __('Support Tickets') }}</span>
                            </li>
                          @endif
                          <li>
                            <span>
                              @if ($package->zoom_meeting_status == 1)
                                <i class="fal fa-check"></i>
                              @else
                                <i class="fal fa-times"></i>
                              @endif
                              {{ __('Zoom Meeting') }}
                            </span>
                          </li>
                          <li>
                            <span>
                              @if ($package->calendar_status == 1)
                                <i class="fal fa-check"></i>
                              @else
                                <i class="fal fa-times"></i>
                              @endif
                              {{ __('Google Calendar') }}
                            </span>
                          </li>

                          @if (!is_null($package->custom_features))
                            @php
                              $features = explode("\n", $package->custom_features);
                            @endphp
                            @if (count($features) > 0)
                              @foreach ($features as $key => $value)
                                <li>
                                  <span><i class="fal fa-check"></i>{{ $value }}</span>
                                </li>
                              @endforeach
                            @endif
                          @endif
                        </ul>
                        <div class="card_action
                                  mt-25">
                          @if (Auth::guard('vendor')->check())
                            <a href="{{ route('vendor.plan.extend.checkout', ['package_id' => $package->id]) }}"
                              class="btn btn-lg btn-primary radius-sm w-100 no-animation" target="_self">
                              {{ __('Extend') }}</a>
                          @else
                            <a href="{{ route('vendor.login', ['redirectPath' => 'buy_plan', 'buy_package' => $package->id]) }}"
                              class="btn btn-lg btn-primary radius-sm w-100 no-animation" target="_self">
                              {{ __('Purchase') }}</a>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Pricing-area End -->
@endsection
