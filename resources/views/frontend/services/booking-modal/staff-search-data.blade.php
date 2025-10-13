@if ($staffs->isEmpty())
  <div id="staff-not-found">
    <h5 class="title mb-20 text-center">{{ __('NO STAFF FOUND') . ' !' }}</h5>
  </div>
@else
  <div class="swiper-wrapper">
    @foreach ($staffs as $staff)
      <div class="swiper-slide staff_select" onclick="bookingStepper.next()" data-day="{{ $staff->is_day }}"
        data-id="{{ $staff->id }}">
        <div class="card radius-md">
          <figure class="card-img">
            <a href="javaScript:void(0)" target="_self" title="Image" class="lazy-container ratio ratio-2-3">
              <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                data-src="{{ asset('assets/img/staff/' . $staff->image) }}" alt="Staff">
            </a>
          </figure>
          <div class="card-details text-center p-20">
            <h5 class="card-title mb-0"><a href="javaScript:void(0)" target="_self"
                title="{{ $staff->name }}">{{ $staff->name }}</a></h5>
            <span class="card-category font-sm">{{ $staff->email }}</span>
            <a href="javaScript:void(0)" class="btn-text color-primary mt-10" title="{{ __('Select Staff') }}"
              target="_self">{{ __('Select Staff') }}</a>
          </div>
        </div><!-- card -->
      </div>
    @endforeach
  </div>
  <div class="swiper-pagination position-static mt-10" id="staff-slider-pagination"></div>
@endif
