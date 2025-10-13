<div class="col-lg-4 col-xl-3">
  <aside class="widget-area" data-aos="fade-up">
    <!--div class="widget widget-form border p-25 radius-md mb-30">
      <h6 class="title text-center mb-20">
        {{ __('Contact for service inquiry') }}
      </h6>
      <div class="user mb-20">
        <div class="user-img">
          <div class="lazy-container ratio ratio-1-1 rounded-pill">
            @if ($details->vendor_id != 0)
              @if ($details->vendor->photo != null)
                <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                  <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                    data-src="{{ asset('assets/admin/img/vendor-photo/' . $details->vendor->photo) }}" alt="Image">
                </a>
              @else
                <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                  <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                    data-src="{{ asset('assets/img/user.png') }}" alt="Vendor">
                </a>
              @endif
            @else
              <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}">
                <img class="lazyload blur-up" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                  data-src="{{ asset('assets/img/admins/' . $admin->image) }}" alt="Image">
              </a>
            @endif
          </div>
        </div>
        <div class="user-info">
          @if ($details->vendor_id != 0)
            @if ($details->vendorInfo)
              @if ($details->vendorInfo->name != null)
                <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                  <h6 class="mb-1">
                    {{ $details->vendorInfo->name }}
                  </h6>
                </a>
              @else
                <a href="{{ route('frontend.vendor.details', ['username' => $details->vendor->username]) }}">
                  <h6 class="mb-1">
                    {{ $details->vendor->username }}
                  </h6>
                </a>
              @endif
            @endif
            @if ($details->vendor->show_phone_number == 1)
              <a href="tel:{{ $details->vendor->phone }}">{{ $details->vendor->phone }}</a>
            @endif
            @if ($details->vendor->show_email_addresss == 1)
              <a href="mailto:{{ $details->vendor->email }}">{{ $details->vendor->email }}</a>
            @endif
          @else
            <a href="{{ route('frontend.vendor.details', ['username' => $admin->username]) }}">
              <h6 class="mb-1">{{ $admin->username }}
              </h6>
            </a>
            <a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a>
          @endif
        </div>
      </div>
      <!--form action="{{ route('frontend.services.contact.message') }}" method="post">
        @csrf
        <div class="form-group mb-20">
          <input type="hidden" name="vendor_id" value="{{ $details->vendor_id }}">
          <input type="hidden" name="service_id" value="{{ $details->id }}">
          <input type="text" class="form-control" placeholder="{{ __('First Name') }}*" name="first_name">
        </div>
        <div class="form-group mb-20">
          <input type="text" class="form-control" placeholder="{{ __('Last Name') }}" name="last_name">
        </div>
        <div class="form-group mb-20">
          <input type="email" class="form-control" placeholder="{{ __('Email Address') }}*" name="email">
        </div>
        <div class="form-group mb-20">
          <textarea name="message" id="message" class="form-control" cols="30" rows="8"
            data-error="Please enter your message" placeholder="{{ __('Message') . '*' }}..."></textarea>
        </div>

        <button class="btn btn-md w-100 btn-primary btn-gradient" type="submit"
          aria-label="Send message">{{ __('Send message') }}</button>
      </form>
    </div>
    @if ($allDays->count() > 0)
      <div class="widget widget-time border p-25 radius-md mb-30">
        <h4 class="title mb-20">
          {{ __('Business Days') }}
        </h4>
        <ul class="list-group">
          @php
            if ($details->vendor_id != 0) {
                $holidays = App\Models\Staff\StaffGlobalDay::where('vendor_id', $details->vendor_id)
                    ->where('is_weekend', 1)
                    ->get();
            } else {
                $holidays = App\Models\Admin\AdminGlobalDay::where('is_weekend', 1)->get();
            }
          @endphp

          @foreach ($allDays as $day)
            <li class="d-flex align-items-center">
              <span>{{ __($day['day']) }}</span>
              <span>{{ $day['minTime'] }}-{{ $day['maxTime'] }}</span>
            </li>
          @endforeach
          @if ($holidays->count() > 0)
            @foreach ($holidays as $holiday)
              <li class="d-flex align-items-center">
                <span>{{ __($holiday->day) }}</span>
                <span class="text-danger">{{ __('Close') }}</span>
              </li>
            @endforeach
          @endif
        </ul>
      </div>
    @endif
    -->

    <!--div class="widget widget-address border p-25 radius-md mb-30">
      <h4 class="title mb-20">
        {{ __('Our Address') }}
      </h4>
      @if (!empty($details->latitude) && !empty($details->longitude))
        <div id="map"></div>
      @endif

      <ul class="list-group mt-20">
        @if (!empty($service->address))
          <li class="icon-start font-sm"><i class="far fa-map-marker-alt"></i>
            {{ $service->address }}
          </li>
        @endif
        @if ($details->vendor_id != 0)
          @if ($details->vendor_id != 0)
            @if ($details->vendor->phone != null)
              <li class="icon-start font-sm"><a href="tel:{{ $details->vendor->phone }}" target="_self"
                  title="link"><i class="far fa-headset"></i>{{ $details->vendor->phone }}</a></li>
              <li class="icon-start font-sm">
            @endif
          @endif
          <a class="text-break" href="mailTo:{{ $details->vendor->email }}" target="_self" title="link"><i
              class="far fa-envelope"></i>
            {{ $details->vendor->email }}
          </a>
          </li>
        @else
          <li class="icon-start font-sm">
            <a class="text-break" href="mailTo:{{ $admin->email }}" target="_self" title="link"><i
                class="far fa-envelope"></i>
              {{ $admin->email }}
            </a>
          </li>
        @endif
      </ul>
    </div-->
    <div class="pb-40"></div>
  </aside>
</div>
