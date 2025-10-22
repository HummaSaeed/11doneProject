@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('All Requests') }}</h4>
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
        <a href="#">{{ __('Service Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Featured Services') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('All Requests') }}</a>
      </li>
    </ul>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-10">
              <form id="searchForm" action="{{ route('admin.all-featured.service') }}" method="GET">
                <div class="row">
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Order Number') }}</label>
                      <input name="order_no" type="text" class="form-control" placeholder="Search Here..."
                        value="{{ !empty(request()->input('order_no')) ? request()->input('order_no') : '' }}">
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group">
                      <label>{{ __('Payment') }}</label>
                      <select class="form-control select2" name="payment_status"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="" {{ empty(request()->input('payment_status')) ? 'selected' : '' }}>
                          {{ __('All') }}
                        </option>
                        <option value="completed"
                          {{ request()->input('payment_status') == 'completed' ? 'selected' : '' }}>
                          {{ __('Completed') }}
                        </option>
                        <option value="pending" {{ request()->input('payment_status') == 'pending' ? 'selected' : '' }}>
                          {{ __('Pending') }}
                        </option>
                        <option value="rejected"
                          {{ request()->input('payment_status') == 'rejected' ? 'selected' : '' }}>
                          {{ __('Rejected') }}
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <div class="form-group">
                      <label>{{ __('Status') }}</label>
                      <select class="form-control select2" name="order_status"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="" {{ empty(request()->input('order_status')) ? 'selected' : '' }}>
                          {{ __('All') }}
                        </option>
                        <option value="pending" {{ request()->input('order_status') == 'pending' ? 'selected' : '' }}>
                          {{ __('Pending') }}
                        </option>
                        <option value="approved" {{ request()->input('order_status') == 'approved' ? 'selected' : '' }}>
                          {{ __('Approved') }}
                        </option>
                        <option value="rejected" {{ request()->input('order_status') == 'rejected' ? 'selected' : '' }}>
                          {{ __('Rejected') }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
                    <div class="form-group">
                      <label>{{ __('Active') }}</label>
                      <select class="form-control select2" name="active_status"
                        onchange="document.getElementById('searchForm').submit()">
                        <option value="" {{ empty(request()->input('active_status')) ? 'selected' : '' }}>
                          {{ __('All') }}
                        </option>
                        <option value="yes" {{ request()->input('active_status') == 'yes' ? 'selected' : '' }}>
                          {{ __('YES') }}
                        </option>
                        <option value="no" {{ request()->input('active_status') == 'no' ? 'selected' : '' }}>
                          {{ __('NO') }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-2">
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
                data-href="{{ route('admin.featued-service.bulk-destory') }}" class="card-header-button">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($featureds) == 0)
                <h3 class="text-center mt-3">{{ __('NO FEATURED SERVICES FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-2">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Order Number') }}</th>
                        <th scope="col">{{ __('Service Title') }}</th>
                        <th scope="col">{{ __('Paid via') }}</th>
                        <th scope="col">{{ __('Payment Status') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Days') }}</th>
                        <th scope="col">{{ __('Active') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($featureds as $featured)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $featured->id }}">
                          </td>
                          <td>{{ '#' . $featured->order_number }}</td>
                          <td>
                            @if ($featured->serviceContent->isNotEmpty())
                              @foreach ($featured->serviceContent as $content)
                                <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $featured->service->id]) }}"
                                  target="_blank">
                                  {{ truncateString($content->name, 40) }}
                                </a>
                              @endforeach
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td>{{ $featured->payment_method }}</td>
                          <td>
                            @if ($featured->gateway_type == 'online')
                              <h2 class="d-inline-block"><span class="badge badge-success">{{ __('Completed') }}</span>
                              </h2>
                            @else
                              @if ($featured->payment_status == 'pending')
                                <form id="paymentStatusForm-{{ $featured->id }}" class="d-inline-block"
                                  action="{{ route('admin.featured_service.order.update_payment_status', ['id' => $featured->id]) }}"
                                  method="post">
                                  @csrf
                                  <select
                                    class="form-control form-control-sm @if ($featured->payment_status == 'pending') bg-warning text-dark @elseif ($featured->payment_status == 'completed') bg-success @else bg-danger @endif"
                                    name="payment_status"
                                    onchange="document.getElementById('paymentStatusForm-{{ $featured->id }}').submit()">
                                    <option value="pending"
                                      {{ $featured->payment_status == 'pending' ? 'selected' : '' }}>
                                      {{ __('Pending') }}
                                    </option>
                                    <option value="completed"
                                      {{ $featured->payment_status == 'completed' ? 'selected' : '' }}>
                                      {{ __('Completed') }}
                                    </option>
                                    <option value="rejected"
                                      {{ $featured->payment_status == 'rejected' ? 'selected' : '' }}>
                                      {{ __('Rejected') }}
                                    </option>
                                  </select>
                                </form>
                              @else
                                <h2 class="d-inline-block"><span
                                    class="badge badge-{{ $featured->payment_status == 'completed' ? 'success' : 'danger' }}">{{ ucfirst($featured->payment_status) }}</span>
                                </h2>
                              @endif
                            @endif
                          </td>
                          <td>
                            @if ($featured->order_status == 'pending')
                              <form id="orderStatusForm-{{ $featured->id }}" class="d-inline-block"
                                action="{{ route('admin.featured_service.order.update_order_status', ['id' => $featured->id]) }}"
                                method="post">
                                @csrf
                                <select
                                  class="form-control form-control-sm @if ($featured->order_status == 'pending') bg-warning text-dark @elseif ($featured->order_status == 'processing') bg-primary @elseif ($featured->order_status == 'approved') bg-success @else bg-danger @endif"
                                  name="order_status"
                                  onchange="document.getElementById('orderStatusForm-{{ $featured->id }}').submit()">
                                  <option value="pending" {{ $featured->order_status == 'pending' ? 'selected' : '' }}>
                                    {{ __('Pending') }}
                                  </option>
                                  <option value="approved"
                                    {{ $featured->order_status == 'approved' ? 'selected' : '' }}>
                                    {{ __('Approve') }}
                                  </option>
                                  <option value="rejected"
                                    {{ $featured->order_status == 'rejected' ? 'selected' : '' }}>
                                    {{ __('Reject') }}
                                  </option>
                                </select>
                              </form>
                            @else
                              <h2 class="d-inline-block"><span
                                  class="badge badge-{{ $featured->order_status == 'approved' ? 'success' : 'danger' }}">{{ ucfirst($featured->order_status) }}</span>
                              </h2>
                            @endif
                          </td>
                          <td>
                            {{ $featured->day }} {{ __('Days') }}
                            @if ($featured->start_date && $featured->end_date)
                              ({{ \Carbon\Carbon::parse($featured->start_date)->formatLocalized('%e %B %Y') }} -
                              {{ \Carbon\Carbon::parse($featured->end_date)->formatLocalized('%e %B %Y') }})
                            @endif
                          </td>
                          <td>
                            @if ($featured->end_date <= \Carbon\Carbon::now()->format('Y-m-d'))
                              <h2 class="d-inline-block"><span class="badge badge-danger">{{ __('NO') }}</span>
                              </h2>
                            @endif
                            @if ($featured->end_date >= \Carbon\Carbon::now()->format('Y-m-d'))
                              <h2 class="d-inline-block"><span class="badge badge-success">{{ __('YES') }}</span>
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
                                <a href="javascript:void()" class="dropdown-item" data-toggle="modal"
                                  data-target="#detailModal-{{ $featured->id }}">
                                  {{ __('Details') }}
                                </a>

                                @if (!is_null($featured->attachment))
                                  <a href="javascript:void()" class="dropdown-item" data-toggle="modal"
                                    data-target="#receiptModal-{{ $featured->id }}">
                                    {{ __('Receipt') }}
                                  </a>
                                @endif

                                <form class="deleteForm d-block"
                                  action="{{ route('admin.featued-service.delete', ['id' => $featured->id]) }}"
                                  method="post">
                                  @csrf
                                  <button type="submit" class="deleteBtn">
                                    {{ __('Delete') }}
                                  </button>
                                </form>
                              </div>
                            </div>
                          </td>
                        </tr>

                        @includeIf('admin.featured-service.show-receipt')
                        @includeIf('admin.featured-service.details')
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
              {{ $featureds->appends([
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
