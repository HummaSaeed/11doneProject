@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->orders_page_title : __('Orders') }}
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->orders_page_title : __('Orders'),
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
                <h4 class="mt-2">{{ __('Orders') }}</h4>
              </div>

              <div class="col-lg-6">
                <form action="{{ route('user.order.index') }}" method="GET">
                  <input type="text" class="form-control search-input" name="product"
                    placeholder="{{ __('Search by Order Number/Product Name') . '...' }}"
                    value="{{ request()->product }}">
                </form>
              </div>
            </div>
            <div class="main-info">
              <div class="main-table">
                @if (count($orders) == 0)
                  <h6 class="text-center mt-3">{{ __('NO ORDER FOUND') . '!' }}</h6>
                @else
                  <div class="table-responsiv">
                    <table id="myTable" class="table table-striped w-100">
                      <thead>
                        <tr>
                          <th>{{ __('Product Name') }}</th>
                          <th>{{ __('Date') }}</th>
                          <th>{{ __('Payment Status') }}</th>
                          <th>{{ __('Order Status') }}</th>
                          <th>{{ __('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($orders as $order)
                          <tr>
                            <td width="200px">
                              @if (!empty($order->title))
                                <a href="{{ route('shop.product_details', ['slug' => $order->slug]) }}" target="_blank">
                                  {{ truncateString($order->title, 40) }}
                                </a>
                              @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->isoFormat('Do MMMM YYYY') }}</td>
                            @php
                              if ($order->payment_status == 'pending') {
                                  $payment_bg = 'bg-warning';
                              } elseif ($order->payment_status == 'completed') {
                                  $payment_bg = 'bg-success';
                              } elseif ($order->payment_status == 'rejected') {
                                  $payment_bg = 'bg-danger';
                              }
                            @endphp
                            <td><span class="badge {{ $payment_bg }}">{{ __($order->payment_status) }}</span></td>
                            @php
                              if ($order->order_status == 'pending') {
                                  $order_bg = 'bg-warning';
                              } elseif ($order->order_status == 'processing') {
                                  $order_bg = 'bg-info';
                              } elseif ($order->order_status == 'completed') {
                                  $order_bg = 'bg-success';
                              } elseif ($order->order_status == 'rejected') {
                                  $order_bg = 'bg-danger';
                              }
                            @endphp
                            <td><span class="badge {{ $order_bg }}">{{ __($order->order_status) }}</span></td>
                            <td>
                              <a href="{{ route('user.order.details', $order->id) }}" class="btn"><i
                                  class="fas fa-eye"></i> {{ __('Details') }}</a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
                <nav class="pagination-nav pb-25" data-aos="fade-up">
                  <ul class="pagination justify-content-center">
                    {{ $orders->links() }}
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard-area end -->
@endsection
