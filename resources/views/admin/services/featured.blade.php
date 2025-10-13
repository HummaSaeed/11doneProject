<div class="modal fade" id="featureModal_{{ $service->id }}" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Feature') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="add-featured" class="modal-form create" action="{{ route('admin.featured.payment') }}" method="POST"
          enctype="multipart/form-data">
          @csrf
          @if (!empty(request()->language))
            @php
              $language = App\Models\Language::where('code', request()->language)->firstOrFail();
            @endphp
          @endif
          <input type="hidden" name="service_id" value="{{ $service->id }}">
          <input type="hidden" name="language_id" value="{{ @$language->id }}">
          <input type="hidden" name="vendor_id" value="{{ $service->vendor_id }}">
          <div class="form-group p-0 mt-2">
            <label for="">{{ __('Promotion List') . '*' }}</label>
            @foreach ($promotionList as $list)
              <ul class="list-group list-group-bordered mb-2">
                <li class="list-group-item">
                  <div class="form-check p-0">
                    <label class="form-check-label mb-0 d-block" for="input_{{ $list->id }}{{ $service->id }}">
                      <input class="form-check-input ml-0 mr-0" required value="{{ $list->id }}" type="radio"
                        name="promotion_id" id="input_{{ $list->id }}{{ $service->id }}">
                      {{ $currencyInfo->base_currency_text_position == 'left' ? $currencyInfo->base_currency_text . ' ' : '' }}{{ number_format($list->amount, 2, '.', ',') }}{{ $currencyInfo->base_currency_text_position == 'right' ? ' ' . $currencyInfo->base_currency_text : '' }}
                      {{ __('For') }} {{ $list->day }} {{ __('Days') }}
                    </label>
                  </div>
                </li>
              </ul>
            @endforeach
          </div>

          <div class="form-group p-0 mt-3">
            <label>{{ __('Payment Method') }}</label>
            <select name="gatway" class="form-control">
              <option value="" selected disabled>{{ __('Select a Payment Method') }}</option>
              @foreach ($gateways as $gateway)
                <option value="{{ $gateway->name }}">{{ $gateway->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mt-2">
            <button class="btn btn-primary w-100" type="submit" id="add-featured">
              {{ __('Submit') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
