<!DOCTYPE html>
<html lang="xxx" dir="{{ $currentLanguageInfo->direction == 1 ? 'rtl' : '' }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="KreativDev">

  <meta name="keywords" content="@yield('metaKeywords')">
  <meta name="description" content="@yield('metaDescription')">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Title -->
  <title>@yield('pageHeading') {{ '| ' . $websiteInfo->website_title }}</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/img/' . $websiteInfo->favicon) }}" type="image/x-icon">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/' . $websiteInfo->favicon) }}">
  <!-- Latest Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Google font -->
  <link rel="stylesheet" href="{{ asset('assets/frontend/css/font.css') }}">
  @php
    $primaryColor = $basicInfo->primary_color;
    $secondaryColor = $basicInfo->secondary_color;

    // check, whether color has '#' or not, will return 0 or 1
    if (!function_exists('checkColorCode')) {
        function checkColorCode($color)
        {
            return preg_match('/^#[a-f0-9]{6}/i', $color);
        }
    }

    // if, primary color value does not contain '#', then add '#' before color value
    if (isset($primaryColor) && checkColorCode($primaryColor) == 0) {
        $primaryColor = '#' . $primaryColor;
    }
    // if, secondary color value does not contain '#', then add '#' before color value
    if (isset($secondaryColor) && checkColorCode($secondaryColor) == 0) {
        $secondaryColor = '#' . $secondaryColor;
    }

    // change decimal point into hex value for opacity
    if (!function_exists('rgb')) {
        function rgb($color = null)
        {
            if (!$color) {
                echo '';
            }
            $hex = htmlspecialchars($color);
            [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
            echo "$r, $g, $b";
        }
    }
  @endphp

  @includeIf('frontend.partials.styles')
  <style>
    :root {
      --color-primary: {{ $primaryColor }};
      --color-secondary: {{ $secondaryColor }};
      --color-primary-rgb: {{ rgb(htmlspecialchars($primaryColor)) }};
    }
  </style>
</head>


<body dir="{{ $currentLanguageInfo->direction == 1 ? 'rtl' : '' }}">
  {{-- booking loader start --}}
  <div class="request-loader-time">
    <img src="{{ asset('assets/img/front-loader.gif') }}" alt="loader">
  </div>
  @if ($basicInfo->preloader_status == 1)
    <!-- Preloader start -->
    <div id="preLoader" data-preloader-status="{{ $basicInfo->preloader_status }}">
      <img src="{{ asset('assets/img/' . $basicInfo->preloader) }}" alt="">
    </div>
  @endif
  {{-- booking loader end --}}

  @php
    $theme_version = $basicInfo->theme_version;
  @endphp

  @if ($theme_version == 1)
    @includeIf('frontend.partials.header.header-v1')
  @elseif($theme_version == 2)
    @includeIf('frontend.partials.header.header-v2')
  @elseif($theme_version == 3)
    @includeIf('frontend.partials.header.header-v3')
  @endif



  @if (request()->routeIs('index'))
  @endif

  @yield('breadcrumb')

  @yield('content')
  <div id="razorPayForm"></div>
  @includeIf('frontend.partials.popups')

  @includeIf('frontend.partials.footer')

  {{-- cookie alert --}}
  @if (!is_null($cookieAlertInfo) && $cookieAlertInfo->cookie_alert_status == 1)
    @include('cookie-consent::index')
  @endif

  <div class="floating-btns">
    <!-- WhatsApp Chat Button -->
    <div id="WAButton"></div>
  </div>

  @if ($basicInfo->shop_status == 1)
    <!-- Floating Cart Button -->
    <div id="cartIconWrapper" class="cartIconWrapper">
      @php
        $position = $basicInfo->base_currency_symbol_position;
        $symbol = $basicInfo->base_currency_symbol;
        $totalPrice = 0;
        if (session()->has('productCart')) {
            $productCarts = session()->get('productCart');
            foreach ($productCarts as $key => $product) {
                $totalPrice += $product['price'];
            }
        }
        $totalPrice = number_format($totalPrice);
        $productCartQuantity = 0;
        if (session()->has('productCart')) {
            foreach (session()->get('productCart') as $value) {
                $productCartQuantity = $productCartQuantity + $value['quantity'];
            }
        }
      @endphp
      <a href="{{ route('shop.cart') }} " class="d-block" id="cartIcon">
        <div class="cart-length">
          <i class="fal fa-shopping-bag"></i>
          <span class="length totalItems">
            {{ $productCartQuantity }} {{ __('Items') }}
          </span>
        </div>
        <div class="cart-total">
          {{ $position == 'left' ? $symbol : '' }}<span
            class="totalPrice">{{ $totalPrice }}</span>{{ $position == 'right' ? $symbol : '' }}
        </div>
      </a>
    </div>
    <!-- Floating Cart Button End-->
  @endif
  @includeIf('frontend.partials.scripts')
  @includeIf('frontend.partials.toastr')
</body>

</html>
