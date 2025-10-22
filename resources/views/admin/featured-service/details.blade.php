<div class="modal fade" id="detailModal-{{ $featured->id }}" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Details') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        @php
          $symbol = $featured->currency_symbol;
          $symbol_positon = $featured->currency_symbol_position;
          if ($featured->vendor_id != 0) {
              $vendor = App\Models\Vendor::join('vendor_infos', 'vendor_infos.vendor_id', 'vendors.id')
                  ->where('language_id', $language_id)
                  ->where('vendors.id', $featured->vendor_id)
                  ->select('vendors.username', 'vendor_infos.name', 'email')
                  ->first();
          } else {
              $vendor = App\Models\Admin::whereNull('role_id')->select('username', 'first_name', 'email')->first();
          }
          $vendorInfo = [];
          if ($vendor) {
              $vendorInfo['username'] = $vendor->username;
              $vendorInfo['name'] = $vendor->name ?? $vendor->first_name;
          }
        @endphp

        <h3 class="text-warning">{{ __('Featured request details') }}</h3>
        <p>
          <strong>{{ __('Name') . ': ' }}</strong>{{ !empty($vendorInfo['name']) ? $vendorInfo['name'] : $vendorInfo['username'] }}
        </p>
        <p><strong>{{ __('Email') . ': ' }}</strong>{{ $vendor->email }}</p>

        <h3 class="text-warning">{{ __('Payment details') }}</h3>
        <p>
          <strong>{{ __('Price') }}: </strong>
          {{ $symbol_positon == 'left' ? $symbol : '' }}{{ $featured->amount }}{{ $symbol_positon == 'right' ? $symbol : '' }}
        </p>
        <p><strong>{{ __('Method') }}: </strong> {{ $featured->payment_method }}
        </p>
        <h3 class="text-warning">{{ __('Service Details') }}</h3>
        @php
          $content = $featured->serviceContent->first();
        @endphp
        <p><strong>{{ __('Service Title') }}:
          </strong>
          @if (!empty($content))
            <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $featured->service_id]) }}"
              target="_blank">
              {{ !empty($content) ? truncateString($content->name, 40) : '-' }}
            </a>
          @else
            {{ '-' }}
          @endif
        </p>
        <p><strong>{{ __('Start Date') }}: </strong>
          @if ($featured->start_date == null)
            <span class="badge badge-danger">{{ __('Never Activated') }}</span>
          @else
            {{ \Carbon\Carbon::parse($featured->start_date)->formatLocalized('%e %B %Y') }}
          @endif
        </p>
        <p><strong>{{ __('Expire Date') }}: </strong>
          @if ($featured->end_date == null)
            <span class="badge badge-danger">{{ __('Never Activated') }}</span>
          @else
            {{ \Carbon\Carbon::parse($featured->end_date)->formatLocalized('%e %B %Y') }}
          @endif
        </p>
      </div>
    </div>
  </div>
</div>
