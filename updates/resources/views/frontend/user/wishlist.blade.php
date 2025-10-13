@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->wishlist_page_title }}
  @endif
@endsection


@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->wishlist_page_title : __('Wishlist'),
  ])

  <!-- Wishlist-area Start -->
  <div class="shopping-area user-dashboard pt-100 pb-60">
    <div class="container">
      <div class="row justify-content-center gx-xl-5">
        <div class="col-lg-3">
          @includeIf('frontend.user.side-navbar')
        </div>
        <div class="col-lg-9">
          <div class="account-info radius-md mb-40">
            <div class="title row">
              <div class="col-lg-6">
                <h4 class="mt-2">{{ __('Wishlist') }}</h4>
              </div>

              <div class="col-lg-6">
                <form action="{{ route('user.wishlist') }}" method="GET">
                  <input type="text" class="form-control search-input" name="service"
                    placeholder="{{ __('Search by Service Title') . '...' }}" value="{{ request()->service }}">
                </form>
              </div>
            </div>
            @if (count($wishlists) == 0)
              <h6 class="text-center">{{ __('NO WISHLIST FOUND') . '!' }}</h6>
            @else
              <div class="main-info">
                <div class="main-table">
                  <div class="table-responsiv">
                    <table id="myTable" class="table table-striped w-100">
                      <thead>
                        <tr class="table-heading">
                          <th scope="col">{{ __('Service Title') }}</th>
                          <th scope="col">{{ __('Price') }}</th>
                          <th scope="col">{{ __('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($wishlists as $item)
                          <tr class="item">
                            <td class="product">
                              <div class="d-flex align-items-center gap-3">
                                <figure class="product-img">
                                  <a target="_blank"
                                    href="{{ route('frontend.service.details', ['slug' => $item->slug, 'id' => $item->service_id]) }}"
                                    target="_blank" title="Link" class="lazy-container radius-md ratio ratio-1-1">
                                    <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                                      data-src="{{ asset('assets/img/services/' . $item->service_image) }}"
                                      alt="Service Image">
                                  </a>
                                </figure>
                                <div class="product-desc">
                                  <h6>
                                    <a class="product-title" target="_blank" title="Link"
                                      href="{{ route('frontend.service.details', ['slug' => $item->slug, 'id' => $item->service_id]) }}">
                                      {{ truncateString($item->name, 50) }}
                                    </a>
                                  </h6>
                                  <div class="ratings d-flex">
                                    <div class="rate bg-img"
                                      data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                      @php
                                        $ratingStaticWidth = '0%';
                                      @endphp
                                      @if (!empty($item->average_rating))
                                        <div class="rating-icon bg-img"
                                          style="width: {{ $item->average_rating * 20 . '%;' }}"
                                          data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                        </div>
                                      @else
                                        <div class="rating-icon bg-img" style="width: {{ $ratingStaticWidth }}"
                                          data-bg-image="{{ asset('assets/frontend/images/rate-star.png') }}">
                                        </div>
                                      @endif
                                    </div>
                                    
                                    <span
                                      class="ratings-total">({{ $item->average_rating ? $item->average_rating : 0.0 }})</span>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td class="price">
                              <span>{{ symbolPrice($item->price) }}</span>
                            </td>
                            <td class="text-center">
                              <a href="{{ route('frontend.service.details', ['slug' => $item->slug, 'id' => $item->service_id]) }}"
                                target="_blank" title="Remove" class="btn btn-remove rounded-pill mx-auto">
                                <i class="fal fa-eye"></i>
                              </a>
                              <a href="{{ route('remove.wishlist', ['id' => $item->service_id]) }}" target="_self"
                                title="Remove" class="btn btn-remove rounded-pill mx-auto">
                                <i class="fal fa-trash-alt"></i>
                              </a>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <nav class="pagination-nav pb-25" data-aos="fade-up">
                    <ul class="pagination justify-content-center">
                      {{ $wishlists->links() }}
                    </ul>
                  </nav>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Wishlist-area End -->
@endsection
