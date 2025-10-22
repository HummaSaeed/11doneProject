@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->appointment_page_title : __('Appointments') }}
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->appointment_page_title : __('Appointments'),
  ])

  <!-- Dashboard-area start-->
  <div class="user-dashboard pt-100">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-3">
          @includeIf('frontend.user.side-navbar')
        </div>
        <div class="col-lg-9">
          <div class="account-info radius-md mb-40">
            <div class="title row">
              <div class="col-lg-6">
                <h4 class="mt-2">{{ __('Appointments') }}</h4>
              </div>

              <div class="col-lg-6">
                <form action="{{ route('user.appointment.index') }}" method="GET">
                  <input type="text" class="form-control search-input" name="search_appointment" placeholder="Search by Booking Number/Service Title..." value="{{ request()->search_appointment }}">
                </form>
              </div>
            </div>
            @if (count($appointments) == 0)
              <h6 class="text-center">{{ __('NO APPOINTMENTS FOUND') . '!' }}</h6>
            @else
              <div class="main-info">
                <div class="main-table">
                  <div class="table-responsiv">
                    <table class="table table-striped w-100">
                      <thead>
                        <tr>
                          <th>{{ __('Service Title') }}</th>
                          <th>{{ __('Vendor') }}</th>
                          <th>{{ __('Appointment Date') }}</th>
                          <th>{{ __('Appointment Time') }}</th>
                          <th>{{ __('Status') }}</th>
                          <th>{{ __('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($appointments as $appointment)
                          <tr>
                            <td width="200px">
                              @if (!empty($appointment->name))
                                <a href="{{ route('frontend.service.details', ['slug' => $appointment->slug, 'id' => $appointment->service_id]) }}"
                                  target="_blank">
                                  {{ truncateString($appointment->name, 40) }}
                                </a>
                              @endif
                            </td>
                            <td>
                              @if ($appointment->vendor_id != 0)
                                <a href="{{ route('frontend.vendor.details', ['username' => $appointment->vendor->username]) }}"
                                  target="_blank">
                                  {{ $appointment->vendor->username }}
                                </a>
                              @else
                                <a href="{{ route('frontend.vendor.details', ['username' => 'admin']) }}"
                                  target="_blank">
                                  {{ __('admin') }}
                                </a>
                              @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($appointment->booking_date)->isoFormat('Do MMMM YYYY') }}
                            </td>
                            <td>
                              {{ $appointment->start_date }} - {{ $appointment->end_date }}
                            </td>
                            <td>
                              @php
                                if ($appointment->order_status == 'pending') {
                                    $order_bg = 'bg-warning';
                                } elseif ($appointment->order_status == 'processing') {
                                    $order_bg = 'bg-info';
                                } elseif ($appointment->order_status == 'accepted') {
                                    $order_bg = 'bg-success';
                                } elseif ($appointment->order_status == 'rejected') {
                                    $order_bg = 'bg-danger';
                                }
                              @endphp
                              <span class="badge {{ $order_bg }}">{{ __($appointment->order_status) }}</span>
                            </td>
                            <td>
                              <a href="{{ route('user.appointment.details', $appointment->id) }}" class="btn"><i
                                  class="fas fa-eye"></i>
                                {{ __('Details') }}</a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            @endif
            <nav class="pagination-nav pb-25" data-aos="fade-up">
              <ul class="pagination justify-content-center">
                {{ $appointments->links() }}
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard-area end -->
@endsection
