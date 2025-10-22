<div class="modal fade bd-example-modal-lg" id="payment_method" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('admin.withdrawal.store.payment') }}" method="post" id="withdrawForm">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Withdraw Payment Method') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          @csrf
          <div class="form-group">
            <label for="">{{ __('Name') }}*</label>
            <input type="text" class="form-control" name="name" placeholder="{{ __('Enter Method Name') }}">
            <p id="err_name" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Minimum Limit') }} ({{ $settings->base_currency_text }})*</label>
            <input type="number" class="form-control" name="min_limit"
              placeholder="{{ __('Enter Withdraw Minimum Limit') }}">
            <p id="err_min_limit" class="mt-1 mb-0 text-danger em"></p>
            <p id="err_limit_amount" class="text-danger"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Maximum Limit') }} ({{ $settings->base_currency_text }})*</label>
            <input type="number" class="form-control" name="max_limit"
              placeholder="{{ __('Enter Withdraw Maximum Limit') }}">
            <p id="err_max_limit" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Fixed Charge') }}</label>
            <input type="number" class="form-control" name="fixed_charge"
              placeholder="{{ __('Enter Fixed Charge') }}">
            <p class="mt-1 mb-0 text-warning">{{ __('Value must be less then (Minimum Limit) amount.') }}</p>
            <p id="err_fixed_charge" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Percentage Charge') }}</label>
            <input type="number" class="form-control" name="percentage_charge"
              placeholder="{{ __('Enter Percentage Charge') }}">
            <p id="err_percentage_charge" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Status') }}*</label>
            <select name="status" class="form-control">
              <option selected="" disabled="">{{ __('Select a Status') }}</option>
              <option value="1">{{ __('Active') }}</option>
              <option value="0">{{ __('Deactive') }}</option>
            </select>
            <p id="err_status" class="mt-1 mb-0 text-danger em"></p>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
            {{ __('Close') }}
          </button>
          <button id="withdrawBtn" type="button" class="btn btn-sm btn-primary">
            {{ __('Save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
