@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->vendor_page_title : __('Vendors') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_page }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_page }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_page_title : __('Vendors'),
  ])

  <!-- Vendor-area start -->
  <div class="vendor-area pt-100 pb-60">
    <div class="container">
      <div class="sort-area" data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-lg-5">
            <h5 class="mb-20">
              @php
                $t_vendor = $vendors->count();
                if ($admin) {
                    $a_vendor = 1;
                } else {
                    $a_vendor = 0;
                }
                $totalvendor = $t_vendor + $a_vendor;
              @endphp
              {{ $totalvendor }}
              {{ count($vendors) > 1 ? __('Vendors') : __('Vendor') }} {{ __('Found') }}
            </h5>
          </div>
          <div class="col-lg-7">
            <form action="{{ route('frontend.vendors') }}" method="GET">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group icon-start mb-20">
                    <span class="icon color-primary">
                      <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" value="{{ request()->input('name') }}"
                      class="form-control border-primary" placeholder="{{ __('Vendor name/username') }}">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group icon-start mb-20">
                    <span class="icon color-primary">
                      <i class="fas fa-map-marker-alt"></i>
                    </span>
                    <input type="text" name="location" class="form-control border-primary"
                      value="{{ request()->input('location') }}" placeholder="{{ __('Enter location') }}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group icon-start">
                    <button type="submit" class="btn btn-icon bg-primary radius-sm color-white w-100">
                      <i class="fal fa-search"></i>
                      <span class="d-inline-block d-md-none">{{ __('Search') }}</span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="row">
        @if ($admin)
          <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up">
            <div class="card text-center border radius-md p-15 mb-25">
              <figure class="card-img mx-auto mb-15">
                <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}" title="Image"
                  target="_self" class="lazy-container rounded-circle ratio ratio-1-1">
                  @if ($admin->image)
                    <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                      data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="Vendor">
                  @else
                    <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                      data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                  @endif

                </a>
              </figure>
              <div class="card-details">
                <h6 class="card-title mb-1">
                  <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}" target="_self"
                    title="{{ $admin->username }}">
                    {{ __('Admin') }}
                  </a>
                </h6>

                @if ($admin->address != null)
                  <span class="font-sm icon-start"><i
                      class="fal fa-map-marker-alt"></i>{{ truncateString($admin->address, 30) }}</span>
                @endif
                <div class="mt-10 pt-10 border-top text-center">
                  @php
                    $total_service = App\Models\Services\Services::where('vendor_id', 0)->where('status', 1)->count();
                  @endphp
                  <span class="font-sm">
                    @if ($total_service > 1)
                      {{ $total_service }} {{ __('Services Available') }}
                    @elseif($total_service == 1)
                      {{ $total_service }} {{ __('Service Available') }}
                    @else
                      {{ __('No Service Available') }}
                    @endif
                  </span>
                </div>
              </div>
              <div class="ratings d-flex justify-content-center mt-2">
                @php
                  $reviews = App\Models\Services\ServiceReview::where('vendor_id', 0)->get();
                  if ($reviews != '[]') {
                      $totalRating = 0;
                      foreach ($reviews as $review) {
                          $totalRating += $review->rating;
                      }
                      $numOfReview = count($reviews);
                      $averageRating = number_format($totalRating / $numOfReview, 1);
                  }
                @endphp
                <div class="rate bg-img" data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                  @if (empty($averageRating))
                    @php
                      $width = '0%';
                    @endphp
                    <div class="rating-icon bg-img" style="width: {{ $width }}"
                      data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                    </div>
                  @else
                    <div class="rating-icon bg-img" style="width: {{ $averageRating * 20 . '%;' }}"
                      data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                    </div>
                  @endif
                </div>
                <span class="ratings-total">
                  @if (!empty($averageRating))
                    ({{ $averageRating }} {{ __('Ratings') }})
                  @else
                    (0 {{ __('Rating') }})
                  @endif
                </span>
              </div>
            </div>
          </div>
        @endif
        @foreach ($vendors as $vendor)
          <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up">
            <div class="card text-center border radius-md p-15 mb-25">
              <figure class="card-img mx-auto mb-15">
                <a href="{{ route('frontend.vendor.details', ['username' => $vendor->username]) }}" title="Image"
                  target="_self" class="lazy-container rounded-circle ratio ratio-1-1">
                  @if ($vendor->photo)
                    <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                      data-src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}" alt="Vendor">
                  @else
                    <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                      data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                  @endif

                </a>
              </figure>
              <div class="card-details">
                @php
                  $vendorInfo = App\Models\VendorInfo::where([
                      ['vendor_id', $vendor->vendorId],
                      ['language_id', $language->id],
                  ])->first();
                @endphp
                <h6 class="card-title mb-1">
                  <a href="{{ route('frontend.vendor.details', ['username' => $vendor->username]) }}" target="_self"
                    title="{{ $vendor->username }}">
                    @if ($vendorInfo->name != null)
                      {{ $vendorInfo->name }}
                    @else
                      {{ $vendor->username }}
                    @endif
                  </a>
                </h6>
                @if ($vendorInfo)
                  @if ($vendorInfo->address != null)
                    <span class="font-sm icon-start"><i
                        class="fal fa-map-marker-alt"></i>{{ truncateString($vendorInfo->address, 30) }}</span>
                  @endif
                @endif
                <div class="mt-10 pt-10 border-top text-center">
                  @php
                    $total_service = App\Models\Services\Services::where('vendor_id', $vendor->vendorId)
                        ->where('status', 1)
                        ->count();
                  @endphp

                  <span class="font-sm">
                    @if ($total_service > 1)
                      {{ $total_service }} {{ __('Services Available') }}
                    @elseif($total_service == 1)
                      {{ $total_service }} {{ __('Service Available') }}
                    @else
                      {{ __('No Service Available') }}
                    @endif
                  </span>
                </div>
              </div>
              <div class="ratings d-flex justify-content-center mt-2">
                @php
                  $reviews = App\Models\Services\ServiceReview::where('vendor_id', $vendor->id)->get();
                  if ($reviews != '[]') {
                      $totalRating = 0;
                      foreach ($reviews as $review) {
                          $totalRating += $review->rating;
                      }
                      $numOfReview = count($reviews);
                      $averageRating = number_format($totalRating / $numOfReview, 1);
                  }
                @endphp
                <div class="rate bg-img" data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                  @if (empty($averageRating))
                    @php
                      $width = '0%';
                    @endphp
                    <div class="rating-icon bg-img" style="width:{{ $width }}"
                      data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                    </div>
                  @else
                    <div class="rating-icon bg-img" style="width: {{ $averageRating * 20 . '%;' }}"
                      data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                    </div>
                  @endif
                </div>
                <span class="ratings-total">
                  @if (!empty($averageRating))
                    ({{ $averageRating }} {{ __('Ratings') }})
                  @else
                    (0 {{ __('Rating') }})
                  @endif
                </span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <nav class="pagination-nav pb-25 d-flex justify-content-center" data-aos="fade-up">
        {{ $vendors->links() }}
      </nav>
      @if (!empty(showAd(3)))
        <div class="text-center mt-4">
          {!! showAd(3) !!}
        </div>
      @endif
    </div>
  </div>
  <!-- Vendor-area end -->
@endsection
