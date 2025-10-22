@extends('staffs.layout')

@section('content')
  <div class="mt-2 mb-4">
    <h2 class="pb-2">{{ __('Welcome back,') }} {{ Auth::guard('staff')->user()->username . '!' }}</h2>
  </div>

  {{-- dashboard information start --}}
  <div class="row dashboard-items">
    <div class="col-sm-6 col-md-6 col-lg-3">
      <a href="{{ route('staff.service_managment', ['language' => $defaultLang->code]) }}">
        <div class="card card-stats card-secondary  card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="fas fa-wrench"></i>
                </div>
              </div>

              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">{{ __('Services') }}</p>
                  <h4 class="card-title">{{ $totalServices }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
      <a href="{{ route('staff.appointment') }}">
        <div class="card card-stats card-primary card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="far fa-calendar"></i>
                </div>
              </div>

              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">{{ __('All Appointments') }}</p>
                  <h4 class="card-title">{{ $totalAppointment }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
      <a href="{{ route('staff.pending_appointment') }}">
        <div class="card card-stats card-warning card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="far fa-clock"></i>
                </div>
              </div>

              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">{{ __('Pending Appointments') }}</p>
                  <h4 class="card-title">{{ $totalPendingAppointment }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
      <a href="{{ route('staff.accepted_appointment') }}">
        <div class="card card-stats card-success card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="far fa-check-circle"></i>
                </div>
              </div>

              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">{{ __('Accepted Appointments') }}</p>
                  <h4 class="card-title">{{ $totalCompleteAppointment }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
      <a href="{{ route('staff.rejected_appointment') }}">
        <div class="card card-stats card-danger card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="far fa-times-circle"></i>
                </div>
              </div>

              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">{{ __('Rejected Appointments') }}</p>
                  <h4 class="card-title">{{ $totalRejectedAppointment }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <div class="card-head-row">
          <h4 class="card-title">{{ __('Recent Appointments') }}</h4>
        </div>
        <p class="card-category">
          @if (count($recent_appointments) > 0)
            {{ count($recent_appointments) }}
            {{ __('latest Appointments') }}
          @endif
        </p>
      </div>
      @if (count($recent_appointments) == 0)
        <h4 class="text-center mt-3 mb-3">{{ __('NO APPOINTMENTS FOUND!') }}</h4>
      @else
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table class="table table-striped mt-3">
                  <thead>
                    <tr>
                      <th scope="col">{{ __('Order Number') }}</th>
                      <th scope="col">{{ __('Service Title') }}</th>
                      <th scope="col">{{ __('Amount') }}</th>
                      <th scope="col">{{ __('Payment Status') }}</th>
                      <th scope="col">{{ __('Status') }}</th>
                      <th scope="col">{{ __('Actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($recent_appointments as $appointment)
                      @php
                        $position = $appointment->currency_text_position;
                        $currency = $appointment->currency_text;
                      @endphp

                      <tr>
                        <td>
                          {{ '#' . $appointment->order_number }}
                        </td>
                        <td>
                          @if ($appointment->serviceContent->isNotEmpty())
                            @foreach ($appointment->serviceContent as $content)
                              <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $appointment->service->id]) }}"
                                target="_blank">
                                {{ strlen($content->name) > 20 ? mb_substr($content->name, 0, 20, 'utf-8') . '...' : $content->name }}
                              </a>
                            @endforeach
                          @else
                            {{ '-' }}
                          @endif
                        </td>
                        <td>
                          {{ $appointment->currency_text_position == 'left' ? $appointment->currency_text . ' ' : '' }}{{ number_format($appointment->customer_paid, 2, '.', ',') }}{{ $appointment->currency_text_position == 'right' ? ' ' . $appointment->currency_text : '' }}
                        </td>
                        <td>
                          @if ($appointment->payment_status == 'pending')
                            <h2 class="d-inline-block"><span class="badge badge-warning">{{ __('Pending') }}</span>
                            </h2>
                          @elseif($appointment->payment_status == 'completed')
                            <h2 class="d-inline-block"><span class="badge badge-success">{{ __('Completed') }}</span>
                            </h2>
                          @else
                            <h2 class="d-inline-block"><span class="badge badge-danger">{{ __('Rejected') }}</span>
                            </h2>
                          @endif
                        </td>
                        <td>
                          @if ($appointment->order_status == 'accepted')
                            <h2 class="d-inline-block"><span class="badge badge-success">{{ __('Accepted') }}</span>
                            </h2>
                          @else
                            @if ($appointment->order_status == 'pending')
                              <h2 class="d-inline-block"><span class="badge badge-warning">{{ __('Pending') }}</span>
                              </h2>
                            @else
                              <h2 class="d-inline-block"><span class="badge badge-danger">{{ __('Rejected') }}</span>
                              </h2>
                            @endif
                          @endif
                        </td>
                        <td>
                          <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                            data-target="#detailsModal45">{{ __('Detail') }}</a>
                        </td>
                      </tr>
                      <div class="modal fade" id="detailsModal45" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">
                                {{ __('Appointment Details') }}
                              </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h3 class="text-warning">
                                {{ __('Customer details') }}</h3>
                              <label>{{ __('Name') }}</label>
                              <p>{{ $appointment->customer_name }}
                              </p>
                              <label>{{ __('Email') }}</label>
                              <p>{{ $appointment->customer_email }}</p>
                              <label>{{ __('Phone') }}</label>
                              <p>{{ $appointment->customer_phone }}</p>
                              <h3 class="text-warning">
                                {{ __('Payment details') }}</h3>
                              <p><strong>{{ 'Price' . ': ' }}</strong>
                                {{ $position == 'left' ? $currency . ' ' : '' }}{{ number_format($appointment->customer_paid, 2, '.', ',') }}{{ $position == 'right' ? ' ' . $currency : '' }}
                              </p>
                              <p><strong>{{ __('Payment Method') . ': ' }} </strong>
                                {{ $appointment->payment_method }}
                              </p>
                              <h3 class="text-warning">
                                {{ __('Appointment Details') }}</h3>
                              <p><strong>{{ __('Appointment Date') }}:
                                </strong>{{ \Carbon\Carbon::parse($appointment->booking_date)->format('M d, Y') }}
                              </p>
                              <p><strong>{{ __('Duration') . ': ' }}
                                </strong> {{ $appointment->start_date }} - {{ $appointment->end_date }}
                              </p>
                              <p>
                                <strong>{{ __('Service Type') . ': ' }} </strong>
                                @if ($appointment->zoom_info != null)
                                  {{ __('Online') }}
                                @else
                                  {{ __('Offline') }}
                                @endif
                              </p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                {{ __('Close') }}
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      @endif
      <div class="card-footer"></div>
    </div>
  </div>

@endsection
