@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ __('Order Details') }}
@endsection
@section('style')
@endsection
@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->orders_page_title : __('Orders Details'),
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
              @if ($order->order_status != 'rejected')
                <div class="progress-area-step">
                  <ul class="progress-steps d-flex justify-content-center">
                    @php
                      $order_status_color = $order->order_status == 'rejected' ? 'red' : '';
                    @endphp
                    <li
                      class="{{ in_array($order->order_status, ['pending', 'processing', 'completed', 'rejected']) ? 'active' : '' }}">
                      <div class="icon">1</div>
                      <div class="progress-title" style="color: {{ $order_status_color }}">{{ __('Order placed') }}</div>
                    </li>
                    <li
                      class="{{ in_array($order->order_status, ['processing', 'completed', 'rejected']) ? 'active' : '' }}">
                      <div class="icon">2</div>
                      <div class="progress-title" style="color: {{ $order_status_color }}">{{ __('On delivery') }}</div>
                    </li>

                    <li class="{{ in_array($order->order_status, ['completed', 'rejected']) ? 'active' : '' }}">
                      <div class="icon">3</div>
                      <div class="progress-title" style="color: {{ $order_status_color }}">
                        {{ $order->order_status == 'rejected' ? __('Rejected') : __('Delivered') }}
                      </div>
                    </li>
                  </ul>
                </div>
              @endif

              <div class="title">
                <h4>{{ __('Order Details') }}</h4>
              </div>
              <div class="view-order-page mb-40">
                <div class="order-info-area">
                  <div class="row align-items-center">
                    <div class="col-lg-8">
                      @php
                        if ($order->order_status == 'pending') {
                            $text_color = 'text-waring';
                        } elseif ($order->order_status == 'processing') {
                            $text_color = 'text-info';
                        } elseif ($order->order_status == 'completed') {
                            $text_color = 'text-success';
                        } elseif ($order->order_status == 'rejected') {
                            $text_color = 'text-danger';
                        }
                      @endphp
                      <div class="order-info mb-20">
                        <h6>{{ __('Order') }} {{ '#' . $order->order_number }} <span
                            class="{{ $text_color }}">[{{ __($order->order_status) }}]</span>
                        </h6>
                        <p class="m-0">{{ __('Order Date') }}
                          {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('Do MMMM YYYY') }}</p>
                      </div>
                    </div>
                    @if (!is_null($order->invoice))
                      <div class="col-lg-4">
                        <div class="prinit mb-20">
                          <a href="{{ asset('assets/file/invoices/product/' . $order->invoice) }}" download
                            class="btn btn-md radius-sm"><i class="fas fa-print"></i>{{ __('Download Invoice') }}</a>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              </div>
              <div class="billing-add-area mb-10">
                <div class="row">
                  <div class="col-md-4">
                    <div class="main-info mb-30">
                      <h5>{{ __('Billing Address') }}</h5>
                      <ul class="list">
                        <li><span>{{ __('Name') . ':' }}</span>{{ $order->billing_name }}</li>
                        <li><span>{{ __('Email') . ':' }}</span>{{ $order->billing_email }}</li>
                        <li><span>{{ __('Phone') . ':' }}</span>{{ $order->billing_phone }}</li>
                        <li><span>{{ __('City') . ':' }}</span>{{ $order->billing_city }}</li>
                        @if (!empty($order->billing_state))
                          <li><span>{{ __('State') . ':' }}</span>{{ $order->billing_state }}</li>
                        @endif
                        <li><span>{{ __('Country') . ':' }}</span> {{ $order->billing_country }}</li>
                        <li><span>{{ __('Address') . ':' }}</span> {{ $order->billing_address }}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="main-info mb-30">
                      <h5>{{ __('Shipping Address') }}</h5>
                      <ul class="list">
                        <li><span>{{ __('Name') . ':' }}</span>{{ $order->shipping_name }}</li>
                        <li><span>{{ __('Email') . ':' }}</span>{{ $order->shipping_email }}</li>
                        <li><span>{{ __('Phone') . ':' }}</span>{{ $order->shipping_phone }}</li>
                        <li><span>{{ __('City') . ':' }}</span>{{ $order->shipping_city }}</li>
                        @if (!empty($order->shipping_state))
                          <li><span>{{ __('State') . ':' }}</span>{{ $order->shipping_state }}</li>
                        @endif
                        <li><span>{{ __('Country') . ':' }}</span> {{ $order->shipping_country }}</li>
                        <li><span>{{ __('Address') . ':' }}</span> {{ $order->shipping_address }}</li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="main-info mb-30">
                      <h5>{{ __('Payment Information') }}</h5>
                      @php
                        if ($order->payment_status == 'pending') {
                            $payment_bg = 'bg-warning';
                        } elseif ($order->payment_status = 'completed') {
                            $payment_bg = 'bg-success';
                        } elseif ($order->payment_status = 'rejected') {
                            $payment_bg = 'bg-danger';
                        }
                        $symbol = $order->currency_symbol;
                        $position = $order->currency_symbol_position;
                      @endphp
                      <ul class="list">
                        <li><span>{{ __('Cart Total') . ':' }}(<i class="far fa-minus text-success"></i>)
                            :</span>{{ $position == 'left' ? $symbol : '' }}{{ number_format($order->total, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}
                        </li>
                        <li><span>{{ __('Discount') . ':' }}(<i class="far fa-minus text-success"></i>)
                            :</span>{{ $position == 'left' ? $symbol : '' }}{{ number_format($order->discount, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}
                        </li>
                        <li>
                          @php
                            $total = floatval($order->total);
                            $discount = floatval($order->discount);
                            $subtotal = $total - $discount;
                          @endphp
                          <span>{{ __('Subtotal') . ':' }}(<i class="far fa-minus text-success"></i>)
                            :</span>{{ $position == 'left' ? $symbol : '' }}{{ number_format($subtotal, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}
                        </li>
                        <li><span>{{ __('Tax') . ':' }} {{ '(' . $tax->product_tax_amount . '%)' }}<span
                              class="text-danger">(<i class="far fa-plus"></i>)</span>
                            :</span>{{ $position == 'left' ? $symbol : '' }}{{ number_format($order->tax, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}
                        </li>
                        <li>
                          @php $shippingMethod = $order->shippingMethod()->first(); @endphp
                          @if ($order->productType == 'digital')
                            <span>
                              {{ __('Shipping Cost') . ':' }}(<i class="far fa-plus text-danger"></i>):
                            </span>
                            @if (is_null($order->shipping_cost))
                              {{ '-' }}
                            @else
                              {{ $position == 'left' ? $symbol : '' }}{{ number_format($order->shipping_cost, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}(<small>{{ is_null($shippingMethod) ? '-' : $shippingMethod->title }}</small>)
                            @endif
                          @endif
                        </li>
                        <li>
                          <span>{{ __('Paid Amount') . ':' }}
                            :</span>{{ $position == 'left' ? $symbol : '' }}{{ number_format($order->grand_total, 2, '.', ',') }}{{ $position == 'right' ? $symbol : '' }}
                        </li>
                        <li>
                          <span>{{ __('Payment Method') . ':' }}</span>{{ __($order->payment_method) }}
                        </li>
                        <li>
                          <span>{{ __('Payment Status') . ':' }}
                            :</span><span class="badge {{ $payment_bg }}">{{ __($order->payment_status) }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="table-responsive product-list">
                <h5>{{ __('Ordered Product') }}</h5>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('Name') }}</th>
                      <th>{{ __('Quantity') }}</th>
                      <th>{{ __('Price') }}</th>
                      <th>{{ __('Total') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $iteration = 1;
                    @endphp
                    @foreach ($items as $item)
                      @if ($item->productType == 'digital')
                        @for ($i = 0; $i < $item->quantity; $i++)
                          <tr>
                            <td>{{ $iteration++ }}</td>
                            <td>
                              @if ($item->slug == '')
                                <p> {{ $item->productTitle }}</p>
                              @else
                                <a href="{{ route('shop.product_details', ['slug' => $item->slug]) }}" target="_blank">
                                  {{ $item->productTitle }}
                                </a>
                              @endif
                              @if ($item->productType == 'digital' && $order->payment_status == 'completed')
                                <!-- if digital then qty will be loop -->
                                @if ($item->inputType == 'link')
                                  <div class="mt-1">
                                    <a href="{{ $item->link }}" target="_blank" class="btn btn-primary btn-sm">
                                      {{ __('Download') }}
                                    </a>
                                  </div>
                                @else
                                  <form
                                    action="{{ route('user.product_order.product.download', ['product_id' => $item->product_id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm mt-1">
                                      {{ __('Download') }}
                                    </button>
                                  </form>
                                @endif
                              @endif
                            </td>
                            <td>
                              <b>{{ __('Quantity') }}:</b> <span>1</span><br>
                            </td>
                            <td>
                              {{ $position == 'left' ? $symbol : '' }}{{ $item->price }}{{ $position == 'right' ? $symbol : '' }}
                            </td>
                            <td>
                              @php
                                $eachItemTotal = floatval($item->price) * $item->quantity;
                              @endphp
                              {{ $position == 'left' ? $symbol : '' }}{{ number_format($eachItemTotal, 2) }}{{ $position == 'right' ? $symbol : '' }}
                            </td>
                          </tr>
                        @endfor
                      @else
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>
                            @if ($item->slug == '')
                              <p>{{ $item->productTitle }}</p>
                            @else
                              <a href="{{ route('shop.product_details', ['slug' => $item->slug]) }}" target="_blank">
                                {{ $item->productTitle }}
                              </a>
                            @endif

                            @if ($item->productType == 'digital' && $order->payment_status == 'completed')
                              {{-- if digital then qty will be loop --}}
                              @if ($item->inputType == 'link')
                                <div class="mt-1">
                                  <a href="{{ $item->link }}" target="_blank" class="btn btn-primary btn-sm">
                                    {{ __('Download') }}
                                  </a>
                                </div>
                              @else
                                <form
                                  action="{{ route('user.product_order.product.download', ['id' => $item->product_id]) }}"
                                  method="POST">
                                  @csrf
                                  <button type="submit" class="btn btn-primary btn-sm mt-1">
                                    {{ __('Download') }}
                                  </button>
                                </form>
                              @endif
                            @endif
                          </td>
                          <td>
                            {{ $item->quantity }}
                          </td>
                          <td>
                            {{ $position == 'left' ? $symbol : '' }}{{ $item->price }}{{ $position == 'right' ? $symbol : '' }}
                          </td>
                          <td>
                            @php
                              $eachItemTotal = floatval($item->price) * $item->quantity;
                            @endphp

                            {{ $position == 'left' ? $symbol : '' }}{{ number_format($eachItemTotal, 2) }}{{ $position == 'right' ? $symbol : '' }}
                          </td>
                        </tr>
                        @php
                          $iteration = $iteration + 1;
                        @endphp
                      @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard-area end -->
@endsection
