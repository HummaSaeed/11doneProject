<!DOCTYPE html>
<html>

<head lang="{{ $currentLanguageInfo->code }}" @if ($currentLanguageInfo->direction == 1) dir="rtl" @endif>
  {{-- required meta tags --}}
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{-- title --}}
  <title>{{ 'Featured Service Request Invoice | ' . config('app.name') }}</title>

  {{-- fav icon --}}
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/' . $websiteInfo->favicon) }}">

  {{-- styles --}}
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>


<body>
  @php
    $mb = '35px';
    $width = '50%';
    $ml = '18px';
    $pl = '15px';
    $pr = '15px';
    $float = 'right';
    $floatL = 'left';
  @endphp
  <div class="purchase-product-invoice my-5">
    <div class="logo text-center ml-auto mr-auto" style="margin-bottom: {{ $mb }}; max-width: 180px;">
      <img class="img-fluid" src="{{ public_path('assets/img/' . $websiteInfo->logo) }}" alt="website logo">
    </div>

    <div class="bg-primary">
      <h2 class="text-center text-light pt-2">
        {{ __('FEATUED SERVICE INVOICE - 85') }}
      </h2>
    </div>

    @php
      $position = $orderInfo->currency_text_position;
      $currency = $orderInfo->currency_text;
    @endphp

    <div class="row clearfix">
      {{-- order details start --}}
      <div style="width: {{ $width }}; float: {{ $floatL }}; padding-left: {{ $pl }}">
        <div class="mt-4 mb-1">
          <h4><strong>{{ __('Order Details') }}</strong></h4>
        </div>

        @php
          $service_id = $orderInfo->service_id;
          $serviceContent = App\Models\Services\ServiceContent::where('service_id', $service_id)
              ->select('name', 'slug')
              ->first();

        @endphp
        <p>
          <strong>{{ __('Order No') . ': ' }}</strong>{{ '#' . $orderInfo->order_number }}
        </p>
        <p>
          <strong>{{ __('Service Title') . ': ' }}</strong>{{ truncateString($serviceContent->name, 25) }}
        </p>

        <p>
          <strong>{{ __('Paid Amount') . ': ' }}</strong>{{ $position == 'left' ? $currency . ' ' : '' }}{{ number_format($orderInfo->amount, 2) }}{{ $position == 'right' ? ' ' . $currency : '' }}
        </p>

        <p>
          <strong>{{ __('Payment Method') . ': ' }}</strong>{{ $orderInfo->payment_method }}
        </p>

        <p>
          <strong>{{ __('Payment Status') . ': ' }}</strong>{{ ucfirst($orderInfo->payment_status) }}
        </p>
        <p>
          <strong>{{ __('Order Status') . ': ' }}</strong>{{ ucfirst($orderInfo->order_status) }}
        </p>
      </div>
      {{-- order details end --}}

      {{-- billing details start --}}
      <div style="width: {{ $width }}; float: {{ $float }};padding-left: {{ $pl }}">
        <div class="mt-4 mb-1">
          <h4><strong>{{ __('Billing Details') }}</strong></h4>
        </div>
        <p>
          <strong>{{ __('Name') . ': ' }}</strong>{{ $orderInfo->vendor->username }}
        </p>
        <p>
          <strong>{{ __('Email') . ': ' }}</strong>{{ $orderInfo->vendor->email }}
        </p>
      </div>
      {{-- billing details end --}}
    </div>
  </div>

</body>

</html>
