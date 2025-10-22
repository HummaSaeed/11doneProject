@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Rejected Appointments') }}</h4>
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
        <a href="#">{{ __('Rejected Appointments') }}</a>
      </li>
    </ul>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-10">
              <form id="searchForm" action="{{ route('admin.rejected_appointment') }}" method="GET">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Booking ID') }}</label>
                      <input name="order_no" type="text" class="form-control" placeholder="{{ __('Search Here...') }}"
                        value="{{ !empty(request()->input('order_no')) ? request()->input('order_no') : '' }}">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Payment') }}</label>
                      <select class="form-control h-42 select2" name="payment_status"
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
                      @includeIf('admin.partials.languages')
                    </div>
                  </div>
                </div>
              </form>
            </div>

            <div class="col-lg-2 mt-4 py-3">
              <button class="btn btn-danger btn-sm d-none bulk-delete float-lg-right"
                data-href="{{ route('admin.appointment.bulk-destory') }}" class="card-header-button">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($booking_item) == 0)
                <h3 class="text-center mt-3">{{ __('NO APPOINMENT FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-2">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Booking ID') }}</th>
                        <th scope="col">{{ __('Service Title') }}</th>
                        <th scope="col">{{ __('Vendor') }}</th>
                        <th scope="col">{{ __('Amount') }}</th>
                        <th scope="col">{{ __('Paid Via') }}</th>
                        <th scope="col">{{ __('Payment Status') }}</th>
                        <th scope="col">{{ __('Order Status') }}</th>
                        <th scope="col">{{ __('Staff') }}</th>
                        <th scope="col">{{ __('Refund Status') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($booking_item as $item)
                        @php
                          $symbol = $item->currency_symbol;
                          $symbol_positon = $item->currency_symbol_position;
                        @endphp
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
                                  {{ truncateString($content->name, 50) }}
                                </a>
                              @endforeach
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td>
                            @if ($item->vendor_id != 0)
                              <a
                                href="{{ route('admin.vendor_management.vendor_details', ['slug' => $item->vendor->username, 'id' => $item->vendor_id]) }}">{{ $item->vendor->username }}</a>
                            @else
                              <span class="badge badge-success">{{ __('Admin') }}</span>
                            @endif
                          </td>
                          <td>
                            {{ $symbol_positon == 'left' ? $symbol : '' }}{{ number_format($item->customer_paid, 2, '.', ',') }}{{ $symbol_positon == 'right' ? $symbol : '' }}
                          </td>
                          <td>{{ $item->payment_method }}</td>
                          <td>
                            @if ($item->gateway_type == 'online')
                              <h2 class="d-inline-block"><span class="badge badge-success">{{ __('Completed') }}</span>
                              </h2>
                            @else
                              @if ($item->payment_status == 'pending')
                                <form id="paymentStatusForm-{{ $item->id }}" class="d-inline-block"
                                  action="{{ route('admin.appointment.update_payment_status', ['id' => $item->id]) }}"
                                  method="post">
                                  @csrf
                                  <select
                                    class="form-control form-control-sm @if ($item->payment_status == 'pending') bg-warning text-dark @elseif ($item->payment_status == 'completed') bg-success @else bg-danger @endif"
                                    name="payment_status"
                                    onchange="document.getElementById('paymentStatusForm-{{ $item->id }}').submit()">
                                    <option value="pending" {{ $item->payment_status == 'pending' ? 'selected' : '' }}>
                                      {{ __('Pending') }}
                                    </option>
                                    <option value="completed"
                                      {{ $item->payment_status == 'completed' ? 'selected' : '' }}>
                                      {{ __('Complete') }}
                                    </option>
                                    <option value="rejected" {{ $item->payment_status == 'rejected' ? 'selected' : '' }}>
                                      {{ __('Reject') }}
                                    </option>
                                  </select>
                                </form>
                              @else
                                <h2 class="d-inline-block"><span
                                    class="badge badge-{{ $item->payment_status == 'completed' ? 'success' : 'danger' }}">{{ ucfirst($item->payment_status) }}</span>
                                </h2>
                              @endif
                            @endif
                          </td>
                          <td>
                            @if (!empty($item->service->id))
                              @if ($item->order_status == 'rejected')
                                <h2 class="d-inline-block"><span
                                    class="badge badge-danger">{{ ucfirst($item->order_status) }}</span>
                                </h2>
                              @endif
                            @else
                              {{ '-' }}
                            @endif
                          </td>

                          <td>
                            @if ($item->staff_id == null)
                              <a href="javascript::void(0)" class="btn btn-sm btn-primary editBtn" data-toggle="modal"
                                data-target="#editModal_{{ $item->id }}"
                                data-appointment_id="{{ $item->id }}">{{ __('Assign') }}</a>
                            @else
                              @php
                                $staffContent = App\Models\Staff\StaffContent::where('staff_id', $item->staff_id)
                                    ->where('language_id', $defaultLang->id)
                                    ->select('name')
                                    ->first();
                              @endphp
                              {{ $staffContent->name ?? $item->staff->username }}
                            @endif
                          </td>
                          <td>
                            @if ($item->refund != 'refunded')
                              <form id="refundStatus-{{ $item->id }}" class="d-inline-block"
                                action="{{ route('admin.appointment.update_refund_status', ['id' => $item->id]) }}"
                                method="post">
                                @csrf
                                <select
                                  class="form-control form-control-sm @if ($item->refund == 'pending') bg-warning text-dark @elseif ($item->refund == 'refunded') bg-success @endif"
                                  name="refund"
                                  onchange="document.getElementById('refundStatus-{{ $item->id }}').submit()">
                                  <option value="pending" {{ $item->refund == 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                  </option>
                                  <option value="refunded" {{ $item->refund == 'refunded' ? 'selected' : '' }}>
                                    {{ __('Refund') }}
                                  </option>
                                </select>
                              </form>
                            @else
                              <h2 class="d-inline-block"><span
                                  class="badge badge-{{ $item->refund == 'refunded' ? 'success' : 'danger' }}">{{ ucfirst($item->refund) }}</span>
                              </h2>
                            @endif
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ __('Select') }}
                              </button>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.appointment.details', ['id' => $item->id]) }}"
                                  class="dropdown-item">
                                  {{ __('Details') }}
                                </a>
                                @if (!empty($item->attachment))
                                  <a href="#" class="dropdown-item" data-toggle="modal"
                                    data-target="#receiptModal-{{ $item->id }}">
                                    {{ __('Receipt') }}
                                  </a>
                                @endif
                                <form class="deleteForm d-block"
                                  action="{{ route('admin.appointment.delete', ['id' => $item->id]) }}" method="post">
                                  @csrf
                                  <button type="submit" class="deleteBtn">
                                    {{ __('Delete') }}
                                  </button>
                                </form>
                              </div>
                            </div>
                          </td>
                        </tr>

                        @includeIf('admin.appointment.show-receipt')
                        @includeIf('admin.appointment.staff-assign')
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
                      'language' => request()->input('language'),
                  ])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
