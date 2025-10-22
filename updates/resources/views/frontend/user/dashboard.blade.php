@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->dashboard_page_title }}
  @endif
@endsection


@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => !empty($bgImg) ? $bgImg->breadcrumb : '',
      'title' => !empty($pageHeading) ? $pageHeading->dashboard_page_title : __('Dashboard'),
  ])
  <!-- Dashboard-area start -->
  <div class="user-dashboard pt-100 pb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-3">
          @includeIf('frontend.user.side-navbar')
        </div>
        <div class="col-lg-9">
          <div class="user-profile-details mb-30">
            <div class="account-info radius-md">
              <div class="title">
                <h4>{{ __('Account Information') }}</h4>
              </div>
              <div class="main-info">
                <ul class="list">
                  <li><span>{{ __('Username') . ':' }}</span> <span>{{ $authUser->username }}</span></li>
                  <li><span>{{ __('Name') . ':' }}</span> <span>{{ $authUser->name }}</span></li>
                  <li><span>{{ __('Email') . ':' }}</span> <span>{{ $authUser->email }}</span></li>
                  <li><span>{{ __('Phone') . ':' }}</span> <span>{{ $authUser->phone }}</span></li>
                  <li><span>{{ __('City') . ':' }}</span> <span>{{ $authUser->city }}</span></li>
                  <li><span>{{ __('Zip Code') . ':' }}</span> <span>{{ $authUser->zip_code }}</span></li>
                  <li><span>{{ __('Address') . ':' }}</span> <span>{{ $authUser->address }}</span></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <a href="{{ route('user.appointment.index') }}" target="_blank">
                <div class="card card-box radius-md mb-30 color-1">
                  <div class="card-icon mb-15">

                    <i class="fal fa-clipboard-list-check"></i>
                  </div>
                  <div class="card-info">
                    <h3 class="mb-0">
                      @if ($appointments > 0)
                        {{ $appointments }}
                      @else
                        00
                      @endif
                      </h4>
                      <p class="mb-0">{{ __('Total Appointments') }}</p>
                  </div>
                </div>
              </a>
            </div>
            @if ($basicInfo->shop_status == 1)
              <div class="col-md-4">
                <a href="{{ route('user.order.index') }}" target="_blank">
                  <div class="card card-box radius-md mb-30 color-2">
                    <div class="card-icon mb-15">
                      <i class="fal fa-shopping-bag"></i>
                    </div>
                    <div class="card-info">
                      <h3 class="mb-0">
                        @if ($orders > 0)
                          {{ $orders }}
                        @else
                          00
                        @endif
                        </h4>
                        <p class="mb-0">{{ __('Total Product Orders') }}</p>
                    </div>
                    <div class="card-line">
                      <svg class="mw-100" data-src="assets/images/chart-line.svg" data-unique-ids="disabled"
                        data-cache="disabled"></svg>
                    </div>
                  </div>
                </a>
              </div>
            @endif
            <div class="col-md-4">
              <a href="{{ route('user.wishlist') }}" target="_blank">
                <div class="card card-box radius-md mb-30 color-3">
                  <div class="card-icon mb-15">
                    <i class="fal fa-heart"></i>
                  </div>
                  <div class="card-info">
                    <h3 class="mb-0">
                      @if ($wishlists > 0)
                        {{ $wishlists }}
                      @else
                        00
                      @endif
                      </h4>
                      <p class="mb-0">{{ __('Wishlist Items') }}</p>
                  </div>
                  <div class="card-line">
                    <svg class="mw-100" data-src="assets/images/chart-line.svg" data-unique-ids="disabled"
                      data-cache="disabled"></svg>
                  </div>
                </div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard-area end -->
@endsection
