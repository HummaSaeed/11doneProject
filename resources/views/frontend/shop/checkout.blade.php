@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->checkout_page_title }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_home }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_home }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->checkout_page_title : __('Checkout'),
  ])

  <!-- Checkout-area start -->
  <div class="shopping-area pt-100 pb-60">
    <div class="container">
      <form action="{{ route('shop.purchase_product') }}" method="POST" enctype="multipart/form-data" id="payment-form">
        @csrf
        <div class="row gx-xl-5">
          <!-- Billing Details Start-->
          <div class="col-lg-8">
            <div class="billing-details">
              <h4 class="mb-20">{{ __('Billing Details') }}</h4>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="firstName">{{ __('Name') . '*' }}</label>
                    <input id="firstName" type="text" class="form-control" name="billing_name"
                      placeholder="{{ __('Enter Full Name') }}" value="{{ old('billing_name', $authUser->name) }}">
                    @error('billing_name')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="lastName">{{ __('Phone Number') . '*' }}</label>
                    <input id="lastName" type="text" class="form-control" name="billing_phone"
                      placeholder="{{ __('Phone Number') }}" value="{{ old('billing_phone', $authUser->phone) }}">
                    @error('billing_phone')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group mb-30">
                    <label for="phone">{{ __('Email Address') }}</label>
                    <input type="email" class="form-control" name="billing_email"
                      placeholder="{{ __('Email Address') }}"
                      value="{{ old('billing_email', Auth::guard('web')->user()->email) }}">
                    @error('billing_email')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="email">{{ __('City') . '*' }}</label>
                    <input type="text" class="form-control" name="billing_city" placeholder="{{ __('City') }}"
                      value="{{ old('billing_city', $authUser->city) }}">
                    @error('billing_city')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="company_name">{{ __('State') }}</label>
                    <input id="" type="text" class="form-control" name="billing_state"
                      placeholder="{{ __('State') }}" value="{{ old('billing_state', $authUser->state) }}">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group mb-30">
                    <label for="address">{{ __('Address') }}*</label>
                    <input type="text" name="billing_address" class="form-control" placeholder="{{ __('Address') }}"
                      value="{{ old('billing_address', $authUser->address) }}">
                    @error('billing_address')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="address">{{ __('Postcode/Zip') }}</label>
                    <input type="text" name="billing_postcode" class="form-control"
                      placeholder="{{ __('Postcode/Zip') }}" value="{{ old('billing_postcode', $authUser->zip_code) }}">
                    @error('billing_postcode')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group mb-30">
                    <label for="">{{ __('Country') }}*</label>
                    <input id="" type="text" class="form-control" name="billing_country"
                      placeholder="{{ __('Country') }}" value="{{ old('billing_country', $authUser->country) }}">
                    @error('billing_country')
                      <p class="mt-2 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <div class="ship-details mb-10">
              <div class="form-group mb-20">
                <div class="custom-checkbox">
                  <input class="input-checkbox" type="checkbox" name="checkbox" id="differentaddress">
                  <label class="form-check-label" data-bs-toggle="collapse" data-target="#collapseAddress"
                    href="#collapseAddress" aria-controls="collapseAddress"
                    for="differentaddress"><span>{{ __('Ship to a different address') }}</span></label>
                </div>
              </div>
              <div id="collapseAddress" class="collapse">
                <h4 class="mb-20">{{ __('Shipping Details') }}</h4>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="firstName">{{ __('Name') . '*' }}</label>
                      <input type="text" class="form-control" name="shipping_name"
                        placeholder="{{ __('Name') }}"
                        value="{{ old('shipping_name', Auth::guard('web')->user()->name) }}">
                      @error('shipping_name')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="phone">{{ __('Phone Number') . '*' }}</label>
                      <input id="phone" type="text" class="form-control" name="shipping_phone"
                        placeholder="{{ __('Phone Number') }}" value="{{ old('shipping_phone', $authUser->phone) }}">
                      @error('shipping_phone')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="email">{{ __('Email Address') . '*' }}</label>
                      <input id="email" type="email" class="form-control" name="shipping_email"
                        placeholder="{{ __('Email Address') }}"
                        value="{{ old('shipping_email', Auth::guard('web')->user()->email) }}">
                      @error('shipping_email')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="city">{{ __('City') . '*' }}</label>
                      <input id="city" type="text" class="form-control" name="shipping_city"
                        placeholder="{{ __('City') }}" value="{{ old('shipping_city', $authUser->city) }}">
                      @error('shipping_city')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group mb-30">
                      <label for="address">{{ __('Address') . '*' }}</label>
                      <input name="shipping_address" class="form-control" placeholder="{{ __('Address') }}"
                        value="{{ old('shipping_address', $authUser->address) }}">
                      @error('shipping_address')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="state">{{ __('State') }}</label>
                      <input id="state" type="text" class="form-control" name="shipping_state"
                        placeholder="{{ __('State') }}" value="{{ old('shipping_state', $authUser->state) }}">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="company_name">{{ __('State') }}</label>
                      <input id="" type="text" class="form-control" name="billing_state"
                        placeholder="{{ __('State') }}" value="{{ old('billing_state', $authUser->state) }}">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="address">{{ __('Postcode/Zip') }}</label>
                      <input type="text" name="billing_postcode" class="form-control"
                        placeholder="{{ __('Postcode/Zip') }}"
                        value="{{ old('billing_postcode', $authUser->zip_code) }}">
                      @error('billing_postcode')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group mb-30">
                      <label for="country">{{ __('Country') . '*' }}</label>
                      <input id="country" type="text" class="form-control" name="shipping_country"
                        placeholder="{{ __('Country') }}" value="{{ old('shipping_country', $authUser->country) }}">
                      @error('shipping_country')
                        <p class="mt-2 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @if (!onlyDigitalItemsInCart())
              <div class="ship-details mb-10">
                <h4 class="mb-20">{{ __('Shipping Method') }}</h4>
                <table class="shopping-table table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('Method') }}</th>
                      <th>{{ __('Charge') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($charges as $charge)
                      <tr>
                        <td>
                          <input type="radio" id="shipping_{{ $charge->id }}" name="shipping_method"
                            value="{{ $charge->id }}" class="shipping_method"
                            data-shipping_charge="{{ $charge->shipping_charge }}"
                            {{ Session::get('shipping_id') == $charge->id ? 'checked' : '' }}>
                        </td>
                        <td>
                          <label for="shipping_{{ $charge->id }}">{{ $charge->title }}
                            <br>
                            <small>{{ $charge->short_text }}</small></label>
                        </td>
                        <td>{{ symbolPrice($charge->shipping_charge) }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

          <!-- Billing Details End-->

          <!-- Order Summary Start-->
          <div class="col-lg-4">
            <!-- Package Summary -->
            <div class="order-summery form-block border radius-md mb-30">
              <h4>{{ __('Order Summary') }}</h4>
              <table class="shopping-table table-responsive">
                @php
                  $total = 0;
                @endphp
                @foreach ($productItems as $key => $productItem)
                  @php
                    $product = App\Models\Shop\Product::where('id', $key)->first();
                    $total += $productItem['price'];
                    //calculate tax
                    $taxAmout = $tax->product_tax_amount;
                  @endphp
                  <tbody>
                    <tr class="item">
                      <td class="product ps-0">
                        <div class="d-flex align-items-center gap-2">
                          <figure class="product-img">
                            <a href="{{ route('shop.product_details', ['slug' => @$productItem['slug']]) }}"
                              target="_self" title="Link" class="lazy-container radius-sm ratio ratio-3-4">
                              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                data-src="{{ asset('assets/img/products/featured-images/' . $productItem['image']) }}"
                                alt="Product">
                            </a>
                          </figure>
                          <div class="product-desc">
                            <h6>
                              <a class="product-title" target="_self" title="Link"
                                href=" {{ route('shop.product_details', ['slug' => @$productItem['slug']]) }}">
                                {{ strlen(@$productItem['title']) > 60 ? mb_substr(@$productItem['title'], 0, 60, 'UTF-8') . '...' : @$productItem['title'] }}
                              </a>
                            </h6>
                            <div class="ratings">
                              <div class="rate bg-img"
                                data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                <div class="rating-icon bg-img"
                                  style="width: {{ $product->average_rating * 20 . '%;' }}"
                                  data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                </div>
                              </div>
                              <span class="ratings-total">({{ $product->average_rating }})</span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="color-primary">
                        <span>x{{ $productItem['quantity'] }}</span>
                      </td>
                      <td class="price">
                        <span>{{ symbolPrice($productItem['quantity'] * $product->current_price) }}</span>
                      </td>
                    </tr>
                  </tbody>
                @endforeach
              </table>
            </div>
            <!-- Order Summary -->
            <div id="couponReload">
              @php
                $position = $currencyInfo->base_currency_symbol_position;
                $symbol = $currencyInfo->base_currency_symbol;
              @endphp
              <div class="order-summary form-block border radius-md mb-30">
                <h4 class="pb-20 mb-20 border-bottom">{{ __('Order Summary') }}</h4>
                <ul class="product-list">
                  @foreach ($productItems as $key => $item)
                    @php
                      $product = App\Models\Shop\Product::where('id', $key)->first();
                    @endphp
                    <li class="d-flex justify-content-between">
                      <span
                        class="font-medium color-dark">{{ strlen(@$item['title']) > 60 ? mb_substr(@$item['title'], 0, 10, 'UTF-8') . '...' : @$item['title'] }}</span>
                      <span class="price">{{ symbolPrice($item['quantity'] * $product->current_price) }}</span>
                    </li>
                  @endforeach
                </ul>
                <hr>
                <div class="sub-total d-flex justify-content-between">
                  <h6>{{ __('Cart Total') }}</h6>
                  <span class="price">{{ $position == 'left' ? $symbol : '' }}<span
                      id="subtotal-amount">{{ $total }}</span>{{ $position == 'right' ? $symbol : '' }}</span>
                </div>
                @if (Session::has('discount'))
                  <div class="sub-total d-flex justify-content-between">
                    <span class="font-medium color-dark">{{ __('Discount') }}</span>
                    <span class="price">- {{ $position == 'left' ? $symbol : '' }}<span
                        id="discount">{{ Session::get('discount') }}</span>{{ $position == 'right' ? $symbol : '' }}</span>
                  </div>

                  <div class="sub-total d-flex justify-content-between">
                    <span class="font-medium color-dark">{{ __('Subtotal ') }}</span>
                    <span class="price">{{ $position == 'left' ? $symbol : '' }}<span
                        id="subtotal-amount">{{ $total - Session::get('discount') }}</span>{{ $position == 'right' ? $symbol : '' }}</span>
                  </div>
                @endif
                <ul class="service-charge-list">
                  <li class="d-flex justify-content-between">
                    @php
                      $tax_amount = ($total - Session::get('discount')) * ($tax->product_tax_amount / 100);
                    @endphp
                    <span class="font-medium color-dark">{{ __('Tax') }}({{ $tax->product_tax_amount . '%' }})
                    </span>
                    <span class="price">+{{ $position == 'left' ? $symbol : '' }}
                      <span id="tax-amount">{{ number_format($tax_amount, 2, '.', ',') }}</span>
                      {{ $position == 'right' ? $symbol : '' }}
                    </span>
                  </li>
                  @if (!onlyDigitalItemsInCart())
                    @php
                      $shipping_id = Session::get('shipping_id');
                      if ($shipping_id != null) {
                          $charge = App\Models\Shop\ShippingCharge::where('id', $shipping_id)->first();
                          $shipping_charge = $charge->shipping_charge;
                      } else {
                          $charge = App\Models\Shop\ShippingCharge::first();
                          $shipping_charge = $charge->shipping_charge;
                      }
                    @endphp
                    <li class="d-flex justify-content-between">
                      <span class="font-medium color-dark">{{ __('Shipping Charge') }}</span>
                      <span class="price">+{{ $position == 'left' ? $symbol : '' }}<span
                          class="shipping-charge-amount">{{ $shipping_charge }}</span><span>{{ $position == 'right' ? $symbol : '' }}</span></span>
                    </li>
                  @else
                    @php
                      $shipping_charge = 0;
                    @endphp
                  @endif
                </ul>
                <hr>
                <div class="total d-flex justify-content-between">
                  <h6>{{ __('Total') }}</h6>
                  @php
                    // calculate grand total
                    $grandTotal = $total - Session::get('discount') + $shipping_charge + $tax_amount;
                  @endphp
                  <span class="price" dir="ltr">{{ $position == 'left' ? $symbol : '' }}
                    <span id="grandtotal-amount">{{ number_format($grandTotal, 2, '.', ',') }}
                    </span>
                    {{ $position == 'right' ? $symbol : '' }}
                  </span>
                </div>
              </div>
            </div>
            <!-- Coupon Apply -->
            <div class="form-wrapper mb-40 bg-white shadow-md border radius-md p-1">
              <div class="input-inline">
                <input type="text" class="form-control border-0 radius-md"
                  placeholder="{{ __('Enter Coupon Code') }}" id="coupon-code">
                <button class="btn btn-lg btn-primary btn-gradient no-animation radius-md icon-start" type="button"
                  aria-label="Search" onclick="applyCoupon(event)">{{ __('Apply') }}</button>
              </div>
            </div>
            <!-- Payment Method -->
            <div class="order-payment form-block border radius-md mb-30">
              <h4 class="mb-20">{{ __('Payment Method') }}</h4>
              <div class="form-group mb-30">
                <select name="gateway" id="gateway" class="niceselect form-control">
                  <option value="" selected="" disabled>{{ __('Choose a Payment Method') }}</option>
                  @foreach ($onlineGateways as $onlineGateway)
                    <option @selected(old('gateway') == $onlineGateway->keyword) value="{{ $onlineGateway->keyword }}">
                      {{ __($onlineGateway->name) }}</option>
                  @endforeach
                  @if (count($offline_gateways) > 0)
                    @foreach ($offline_gateways as $offlineGateway)
                      <option @selected(old('gateway') == $offlineGateway->id) value="{{ $offlineGateway->id }}">
                        {{ __($offlineGateway->name) }}</option>
                    @endforeach
                  @endif
                </select>
                @if (Session::has('error'))
                  <p class="mt-2 text-danger">{{ Session::get('error') }}</p>
                @endif
              </div>


              <!-- Stripe Payment Will be Inserted here -->
              <div id="stripe-element" class="mb-2">
                <!-- A Stripe Element will be inserted here. -->
              </div>
              <!-- Used to display form errors -->
              <div id="stripe-errors" class="pb-2" role="alert"></div>

              <!-- Authorize.net Payment Will be Inserted here -->
              <div class="row gateway-details pb-4 d-none" id="authorizenet-element">
                <div class="col-lg-6">
                  <div class="form-group mb-3">
                    <input class="form-control" type="text" id="anetCardNumber" placeholder="Card Number"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 mb-3">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetExpMonth" placeholder="Expire Month"
                      disabled />
                  </div>
                </div>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetExpYear" placeholder="Expire Year" disabled />
                  </div>
                </div>
                <div class="col-lg-6 ">
                  <div class="form-group">
                    <input class="form-control" type="text" id="anetCardCode" placeholder="Card Code" disabled />
                  </div>
                </div>
                <input type="hidden" name="opaqueDataValue" id="opaqueDataValue" disabled />
                <input type="hidden" name="opaqueDataDescriptor" id="opaqueDataDescriptor" disabled />
                @php
                  $display = 'none';
                @endphp
                <ul id="authorizeNetErrors" style="display: {{ $display }}"></ul>
              </div>

              @foreach ($offline_gateways as $offlineGateway)
                <div class="@if ($errors->has('attachment') && request()->session()->get('gatewayId') == $offlineGateway->id) d-block @else d-none @endif offline-gateway-info"
                  id="{{ 'offline-gateway-' . $offlineGateway->id }}">
                  @if (!is_null($offlineGateway->short_description))
                    <div class="form-group mb-4">
                      <label>{{ __('Description') }}</label>
                      <p>{{ $offlineGateway->short_description }}</p>
                    </div>
                  @endif

                  @if (!is_null($offlineGateway->instructions))
                    <div class="form-group mb-4">
                      <label>{{ __('Instructions') }}</label>
                      {!! replaceBaseUrl($offlineGateway->instructions, 'summernote') !!}
                    </div>
                  @endif

                  @if ($offlineGateway->has_attachment == 1)
                    <div class="form-group mb-4">
                      <label>{{ __('Attachment') . '*' }}</label>
                      <br>
                      <input type="file" name="attachment">
                      @error('attachment')
                        <p class="text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  @endif

                </div>
              @endforeach


              <div class="text-center">
                <button class="btn btn-lg btn-primary btn-gradient w-100" type="submit"
                  aria-label="button">{{ __('Place Order') }}</button>
              </div>
            </div>
          </div>
          <!-- Order Summary End-->
        </div>
      </form>
    </div>
  </div>
  <!-- Checkout-area end -->
@endsection
@section('script')
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ $authorizeUrl }}"></script>
  <script src="{{ asset('assets/frontend/js/shop.js') }}"></script>
  <script>
    let stripe_key = "{{ $stripe_key }}";
    let authorize_login_key = "{{ $authorize_login_id }}";
    let authorize_public_key = "{{ $authorize_public_key }}";
  </script>
  <script src="{{ asset('assets/frontend/js/product_checkout.js') }}"></script>
  <script>
    @if (old('gateway') == 'stripe')
      $(document).ready(function() {
        $('#stripe-element').removeClass('d-none');
      })
    @endif
  </script>
@endsection
