@extends('staffs.layout')


@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Accepted Appointments') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('staff.dashboard') }}">
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
        <a href="#">{{ __('Accepted Appointments') }}</a>
      </li>
    </ul>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-10">
              <form id="searchForm" action="{{ route('staff.accepted_appointment') }}" method="GET">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Booking ID') }}</label>
                      <input name="order_no" type="text" class="form-control" placeholder="Search Here..."
                        value="{{ !empty(request()->input('order_no')) ? request()->input('order_no') : '' }}">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Payment') }}</label>
                      <select class="form-control select2" name="payment_status"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="" {{ empty(request()->input('payment_status')) ? 'selected' : '' }}>
                          {{ __('All') }}
                        </option>
                              <option value="pending" {{ request()->input('payment_status') == 'pending' ? 'selected' : '' }}>
                          {{ __('Pending') }}
                        </option>
                        <option value="completed"
                          {{ request()->input('payment_status') == 'completed' ? 'selected' : '' }}>
                          {{ __('Completed') }}
                        </option>

                        <option value="rejected"
                          {{ request()->input('payment_status') == 'rejected' ? 'selected' : '' }}>
                          {{ __('Rejected') }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Refunded') }}</label>
                      <select class="form-control h-42 select2" name="refund"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="" {{ empty(request()->input('refund')) ? 'selected' : '' }}>
                          {{ __('All') }}
                        </option>
                        <option value="pending" {{ request()->input('refund') == 'pending' ? 'selected' : '' }}>
                          {{ __('Pending') }}
                        </option>
                        <option value="refunded" {{ request()->input('refund') == 'refunded' ? 'selected' : '' }}>
                          {{ __('Refunded') }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Language') }}</label>
                      @includeIf('staffs.partials.languages')
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <div class="col-lg-2 mt-4 py-3">
              <button class="btn btn-danger btn-sm d-none bulk-delete float-lg-right"
                data-href="{{ route('admin.featued-service.bulk-destory') }}" class="card-header-button">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($booking_item) == 0)
                <h3 class="text-center mt-3">{{ __('NO APPOINTMENT FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-2">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Booking ID.') }}</th>
                        <th scope="col">{{ __('Service Title') }}</th>
                        <th scope="col">{{ __('Appointment Date') }}</th>
                        <th scope="col">{{ __('Appointment Time') }}</th>
                        <th scope="col">{{ __('Meeting') }}</th>
                        <th scope="col">{{ __('Order Status') }}</th>
                        <th scope="col">{{ __('Customer') }}</th>
                        <th scope="col">{{ __('Refund Status') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($booking_item as $item)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $item->id }}">
                          </td>
                          <td>{{ '#' . $item->order_number }}</td>
                          <td>
                            @if ($item->serviceContent->isNotEmpty())
                              @foreach ($item->serviceContent as $content)
                                <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $item->service->id]) }}"
                                  target="_blank">
                                  {{ truncateString($content->name, 30) }}
                                </a>
                              @endforeach
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td>
                            {{ \Carbon\Carbon::parse($item->booking_date)->format('M d, Y') }}
                          </td>
                          <td>
                            {{ $item->start_date }} - {{ $item->end_date }}
                          </td>
                          <td>
                            @if ($item->order_status != 'rejected')
                              @if ($item->zoom_info)
                                @php
                                  $zoom_link = json_decode($item->zoom_info, true);
                                @endphp
                                <a href="{{ $zoom_link['start_url'] }}" class="btn-sm btn-success text-decoration-none"
                                  target="_blank">Join</a>
                              @else
                                {{ '-' }}
                              @endif
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td>
                            @if ($item->order_status == 'accepted')
                              <h2 class="d-inline-block"><span class="badge badge-success">{{ __('Accepted') }}</span>
                              </h2>
                            @endif
                          </td>
                          <td>{{ $item->customer_name }}</td>
                          <td>
                            <h2 class="d-inline-block"><span
                                class="badge badge-{{ $item->refund == 'refunded' ? 'success' : 'warning' }}">{{ ucfirst($item->refund) }}</span>
                            </h2>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Select') }}
                              </button>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('staff.appointment.details', ['id' => $item->id]) }}"
                                  class="dropdown-item">
                                  {{ __('Details') }}
                                </a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="mt-3 text-center">
            <div class="d-inline-block mx-auto">
              {{ $booking_item->appends([
                      'order_no' => request()->input('order_no'),
                      'payment_status' => request()->input('payment_status'),
                      'order_status' => request()->input('order_status'),
                  ])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
