@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ __('Appointment Details') }}
@endsection
@section('style')
@endsection
@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->orders_page_title : __('Appointment Details'),
  ])

  <!-- Dashboard-area start -->
  <div class="user-dashboard pt-100 pb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-3">
          @includeIf('frontend.user.side-navbar')
        </div>
        <div class="col-lg-9">
          <div class="user-profile-details mb-40">
            <div class="order-details radius-md">
              <div class="title">
                <h4>{{ __('Appointment details') }}</h4>
              </div>
              <div class="view-order-page mb-40">
                <div class="order-info-area">
                  <div class="row align-items-center">
                    <div class="col-lg-8">
                      @php
                        if ($appointment->order_status == 'pending') {
                            $text_color = 'text-waring';
                        } elseif ($appointment->order_status == 'accepted') {
                            $text_color = 'text-success';
                        } elseif ($appointment->order_status == 'rejected') {
                            $text_color = 'text-danger';
                        }
                      @endphp
                      <div class="order-info mb-20">
                        <h6>{{ __('Booking No.') }} {{ '#' . $appointment->order_number }} <span
                            class="{{ $text_color }}">
                            [{{ ucfirst(strtolower(__($appointment->order_status))) }}]

                          </span>
                        </h6>
                        <p class="m-0">{{ __('Booking Date') }}
                          {{ \Carbon\Carbon::parse($appointment->created_at)->isoFormat('Do MMMM YYYY') }}
                        </p>
                      </div>
                    </div>
                    @if (!is_null($appointment->invoice))
                      <div class="col-lg-4">
                        <div class="prinit mb-20">
                          <a href="{{ asset('assets/file/invoices/service/' . $appointment->invoice) }}" download
                            class="btn btn-md radius-sm"><i class="fas fa-print"></i>{{ __('Download Invoice') }}</a>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="billing-add-area mb-10">
                <div class="row">
                  <div class="col-md-6">
                    <div class="main-info mb-30">
                      <h5>{{ __('Billing Address') }}</h5>
                      <ul class="list">
                        <li><span>{{ __('Name') . ':' }}</span>{{ $appointment->customer_name }}</li>
                        <li><span>{{ __('Email') . ':' }}</span>{{ $appointment->customer_email }}</li>
                        <li><span>{{ __('Phone') . ':' }}</span>{{ $appointment->customer_phone }}</li>
                        <li><span>{{ __('Country') . ':' }}</span> {{ $appointment->customer_country }}</li>
                        <li><span>{{ __('Address') . ':' }}</span> {{ $appointment->customer_address }}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="main-info mb-30">
                      <h5>{{ __('Payment Information') }}</h5>
                      @php
                        if ($appointment->payment_status == 'pending') {
                            $payment_bg = 'bg-warning';
                        } elseif ($appointment->payment_status = 'completed') {
                            $payment_bg = 'bg-success';
                        } elseif ($appointment->payment_status = 'rejected') {
                            $payment_bg = 'bg-danger';
                        }
                        $symbol = $appointment->currency_symbol;
                        $position = $appointment->currency_symbol_position;
                      @endphp
                      <ul class="list">
                        <li>
                          <span>{{ __('Paid Amount') . ':' }}</span>
                          {{ $position == 'left' ? $symbol : '' }}{{ number_format($appointment->customer_paid, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}
                        </li>
                        <li>
                          <span>{{ __('Payment Method') . ':' }}</span>
                          {{ __($appointment->payment_method) }}
                        </li>
                        <li>
                          <span>{{ __('Payment Status') . ':' }}</span>
                          <span class="badge {{ $payment_bg }}">{{ __($appointment->payment_status) }}</span>
                        </li>
                        <li>
                          @php
                            if ($appointment->order_status == 'pending') {
                                $order_bg = 'bg-warning';
                            } elseif ($appointment->order_status = 'accepted') {
                                $order_bg = 'bg-success';
                            } elseif ($appointment->order_status = 'rejected') {
                                $order_bg = 'bg-danger';
                            }
                          @endphp
                          <span>{{ __('Booking Status') . ':' }}</span>
                          <span class="badge {{ $order_bg }}">{{ __($appointment->order_status) }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="main-info mb-30">
                      <h5>{{ __('Booking details') }}</h5>
                      @php
                        $content = $appointment->serviceContent->first();
                      @endphp
                      <ul class="list">
                        <li>
                          <span>{{ __('Service Title') . ': ' }}</span>
                          @if ($content)
                            <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $appointment->service->id]) }}"
                              target="_blank">
                              {{ truncateString($content->name, 38) }}
                            </a>
                          @endif
                        </li>
                        <li>
                          <span>{{ __('Service Address') . ': ' }}</span>
                          <p>
                            @if ($content)
                              {{ $content->address }}
                            @endif
                          </p>
                        </li>

                        @if ($appointment->zoom_info && $appointment->order_status == 'accepted')
                          @php
                            $zoom_link = json_decode($appointment->zoom_info, true);
                          @endphp
                          <li>
                            <span>{{ __('Meeting Url') . ':' }}</span>
                            <p>
                              <a target="_blank" href="{{ $zoom_link['join_url'] }}">
                                {{ truncateString($zoom_link['join_url'], 40) }}
                              </a>
                            </p>
                          </li>
                          <li>
                            <span>{{ __('Meeting Passcode') . ':' }}</span>
                            <p> {{ $zoom_link['password'] }}</p>
                          </li>
                        @endif
                        <li>
                          <span>{{ __('Appointment Date') . ':' }}</span>
                          {{ \Carbon\Carbon::parse($appointment->booking_date)->isoFormat('Do MMMM YYYY') }}
                        </li>
                        <li>
                          <span>{{ __('Appointment Time') . ':' }}</span>
                          <p>
                            {{ $appointment->start_date . ' - ' . $appointment->end_date }}
                          </p>
                        </li>

                        <li>
                          <span>
                            @if ($appointment->max_person > 1)
                              {{ __('Persons') . ':' }}
                            @else
                              {{ __('Person') . ':' }}
                            @endif
                          </span>
                          <p>
                            {{ $appointment->max_person }}
                          </p>
                        </li>
                        <li>
                          <span>{{ __('Staff Name') . ': ' }}</span>
                          <p>
                            {{ $staff->name ?? $staff->username }}
                          </p>
                        </li>
                        @if ($staff->info_status == 1)
                          @if ($staff->information)
                            <li>
                              <span class="col-md-4">{{ __('Staff Information') . ': ' }}</span>
                              <p>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                  data-bs-target="#staffInfoModal">{{ __('Show') }}</button>
                              </p>
                            </li>
                          @endif
                        @endif

                      </ul>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="main-info mb-30">
                      <h5>{{ __('Vendor Details') }}</h5>
                      <ul class="list">
                        <li><span>{{ __('Name') . ':' }}</span>
                          @if ($appointment->vendor_id != 0)
                            {{ !empty($vendor->name) ? $vendor->name : $vendor->username }}
                          @else
                            {{ !empty($vendor->first_name) ? $vendor->first_name : $vendor->username }}
                          @endif
                        </li>
                        @if ($vendor->show_email_addresss == 1)
                          <li><span>{{ __('Email') . ':' }}</span>{{ $vendor->email }}</li>
                        @endif
                        @if ($vendor->show_phone_number == 1 && !empty($vendor->phone))
                          <li><span>{{ __('Phone') . ':' }}</span>{{ $vendor->phone }}</li>
                        @endif
                        @if (!empty($vendor->country))
                          <li><span>{{ __('Country') . ':' }}</span> {{ $vendor->country }}</li>
                        @endif
                        @if (!empty($vendor->address))
                          <li><span>{{ __('Address') . ':' }}</span> {{ $vendor->address }}</li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard-area end -->
  <!-- staff info modal -->
  <div class="modal fade" id="staffInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Information') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
        </div>
        <div class="modal-body">
          @php
            $information = explode("\n", $staff->information);
          @endphp
          @if (count($information) > 0)
            <ul class="list-unstyled">
              @foreach ($information as $info)
                <li>{{ $info }}</li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        </div>
      </div>
    </div>
  </div>
@endsection
