@extends('vendors.layout')


@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Appointments Details') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Appointments') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('All Appointments') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Details') }}</a>
      </li>
    </ul>
  </div>
  <div class="text-right mb-3">
    <a href="{{ route('vendor.all_appointment') }}" class="btn btn-primary">{{ __('Back') }}</a>
  </div>

  <div class="row">
    @php
      $symbol = $details->currency_symbol;
      $symbol_positon = $details->currency_symbol_position;
    @endphp

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">
            {{ __('Booking No.') . ' ' . '#' . $details->order_number }}
          </div>
        </div>

        <div class="card-body">
          <div class="payment-information">
            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Service Title') . ' :' }}</strong>
              </div>

              <div class="col-lg-6">
                @if ($details->serviceContent->isNotEmpty())
                  @foreach ($details->serviceContent as $content)
                    <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $details->service->id]) }}"
                      target="_blank">
                      {{ truncateString($content->name, 50) }}
                    </a>
                  @endforeach
                @else
                  {{ '-' }}
                @endif
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Booking Date') . ' :' }}</strong>
              </div>

              <div class="col-lg-6">
                {{ date_format($details->created_at, 'M d, Y') }}
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Appointment Date') . ' :' }}</strong>
              </div>

              <div class="col-lg-6">
                {{ \Carbon\Carbon::parse($details->booking_date)->format('M d, Y') }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Appointment Time') . ' :' }}</strong>
              </div>
              <div class="col-lg-6">
                {{ $details->start_date }} - {{ $details->end_date }}
              </div>
            </div>


            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>
                  @if ($details->max_person > 1)
                    {{ __('Persons') . ' :' }}
                  @else
                    {{ __('Person') . ' :' }}
                  @endif
                </strong>
              </div>

              <div class="col-lg-6">
                {{ $details->max_person }}
                @if ($details->max_person > 1)
                  {{ __('Persons') }}
                @else
                  {{ __('Person') }}
                @endif
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Price') . ' :' }}</strong>
              </div>

              <div class="col-lg-6">
                {{ $symbol_positon == 'left' ? $symbol : '' }}
                {{ number_format($details->customer_paid, 2, '.', ',') }}
                {{ $symbol_positon == 'right' ? $symbol : '' }}
              </div>
            </div>
            @if ($details->zoom_info != null)
              <div class="row mb-2">
                <div class="col-lg-6">
                  <strong>{{ __('Zoom Host Url') . ' :' }}</strong>
                </div>
                <div class="col-lg-6">
                  @if ($details->zoom_info)
                    @php
                      $zoom_link = json_decode($details->zoom_info, true);
                    @endphp
                    <a target="_blank" href="{{ $zoom_link['start_url'] }}">
                      {{ strlen($zoom_link['start_url']) > 50 ? mb_substr($zoom_link['start_url'], 0, 50, 'utf-8') . '...' : $zoom_link['start_url'] }}
                    </a>
                  @else
                    {{ '-' }}
                  @endif
                </div>
              </div>

              <div class="row mb-2">
                <div class="col-lg-6">
                  <strong>{{ __('Zoom Join Url') . ' :' }}</strong>
                </div>
                <div class="col-lg-6">
                  @if ($details->zoom_info)
                    @php
                      $zoom_link = json_decode($details->zoom_info, true);
                    @endphp
                    <a target="_blank" href="{{ $zoom_link['join_url'] }}">
                      {{ strlen($zoom_link['join_url']) > 50 ? mb_substr($zoom_link['join_url'], 0, 50, 'utf-8') . '...' : $zoom_link['join_url'] }}
                    </a>
                  @else
                    {{ '-' }}
                  @endif
                </div>
              </div>


              <div class="row mb-2">
                <div class="col-lg-6">
                  <strong>{{ __('Meeting Join Password') . ' :' }}</strong>
                </div>
                <div class="col-lg-6">
                  @if ($details->zoom_info)
                    {{ $zoom_link['password'] }}
                  @else
                    {{ '-' }}
                  @endif
                </div>
              </div>
            @endif

            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Payment Status') . ' :' }}</strong>
              </div>

              <div class="col-lg-6">
                @if ($details->payment_status == 'completed')
                  <span class="badge badge-success">{{ __('Completed') }}</span>
                @elseif ($details->payment_status == 'pending')
                  <span class="badge badge-warning">{{ __('Pending') }}</span>
                @else
                  <span class="badge badge-danger">{{ __('Rejected') }}</span>
                @endif
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-6">
                <strong>{{ __('Appointment Status') . ' :' }}</strong>
              </div>

              <div class="col-lg-6">
                @if ($details->order_status == 'accepted')
                  <span class="badge badge-success">{{ __('Accepted') }}</span>
                @elseif ($details->order_status == 'pending')
                  <span class="badge badge-warning">{{ __('Pending') }}</span>
                @else
                  <span class="badge badge-danger">{{ __('Rejected') }}</span>
                @endif
              </div>
            </div>
            @if ($details->order_status == 'rejected')
              <div class="row mb-2">
                <div class="col-lg-6">
                  <strong>{{ __('Refund Status') . ' :' }}</strong>
                </div>
                <div class="col-lg-6">
                  @if ($details->order_status == 'rejected')
                    @if ($details->refund == 'pending')
                      <span class="badge badge-success">{{ __('Pending') }}</span>
                    @else
                      <span class="badge badge-success">{{ __('Refunded') }}</span>
                    @endif
                  @endif
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">
            {{ __('Billing Details') }}
          </div>
        </div>

        <div class="card-body">
          <div class="payment-information">
            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Name') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $details->customer_name }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Email') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $details->customer_email }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Phone') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $details->customer_phone }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Address') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $details->customer_address }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Country') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $details->customer_country }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">
            {{ __('Vendor Details') }}
          </div>
        </div>

        <div class="card-body">
          <div class="payment-information">
            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Name') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $vendor_details->name ?? $vendor_details->username }}
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-lg-4">
                <strong>{{ __('Email') . ' :' }}</strong>
              </div>

              <div class="col-lg-8">
                {{ $vendor_details->email }}
              </div>
            </div>

            @if (!empty($vendor_details->phone))
              <div class="row mb-2">
                <div class="col-lg-4">
                  <strong>{{ __('Phone') . ' :' }}</strong>
                </div>

                <div class="col-lg-8">
                  {{ $vendor_details->phone }}
                </div>
              </div>
            @endif

            @if (!empty($vendor_details->address))
              <div class="row mb-2">
                <div class="col-lg-4">
                  <strong>{{ __('Address') . ' :' }}</strong>
                </div>

                <div class="col-lg-8">
                  {{ $vendor_details->address }}
                </div>
              </div>
            @endif

            @if (!empty($vendor_details->city))
              <div class="row mb-2">
                <div class="col-lg-4">
                  <strong>{{ __('City') . ' :' }}</strong>
                </div>

                <div class="col-lg-8">
                  {{ $vendor_details->city }}
                </div>
              </div>
            @endif

            @if (!empty($vendor_details->state))
              <div class="row mb-2">
                <div class="col-lg-4">
                  <strong>{{ __('State') . ' :' }}</strong>
                </div>

                <div class="col-lg-8">
                  {{ $vendor_details->state }}
                </div>
              </div>
            @endif

            @if (!empty($vendor_details->country))
              <div class="row mb-1">
                <div class="col-lg-4">
                  <strong>{{ __('Country') . ' :' }}</strong>
                </div>

                <div class="col-lg-8">
                  {{ $vendor_details->country }}
                </div>
              </div>
            @endif

          </div>
        </div>
      </div>
    </div>
    @if ($details->staff_id != null)
      @if ($staff->role != 'vendor')
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <div class="card-title d-inline-block">
                {{ __('Staff Details') }}
              </div>
            </div>

            <div class="card-body">
              <div class="payment-information">
                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>{{ __('Name') . ' :' }}</strong>
                  </div>

                  <div class="col-lg-8">
                    {{ $staff->name ?? $staff->username }}
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>{{ __('Email') . ' :' }}</strong>
                  </div>

                  <div class="col-lg-8">
                    {{ $staff->email }}
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-4">
                    <strong>{{ __('Phone') . ' :' }}</strong>
                  </div>

                  <div class="col-lg-8">
                    {{ $staff->phone }}
                  </div>
                </div>

                @if (!empty($staff->address))
                  <div class="row mb-2">
                    <div class="col-lg-4">
                      <strong>{{ __('Address') . ' :' }}</strong>
                    </div>

                    <div class="col-lg-8">
                      {{ $staff->address }}
                    </div>
                  </div>
                @endif

                @if (!empty($staff->information))
                  <div class="row mb-2">
                    <div class="col-lg-4">
                      <strong>{{ __('Information') . ' :' }}</strong>
                    </div>
                    <div class="col-lg-8">
                      <button class="btn btn-info btn-sm" data-toggle="modal"
                        data-target="#staffInfoModal">{{ __('Show') }}</button>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endif
    @endif
  </div>
  <div class="modal fade" id="staffInfoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('Information') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection
