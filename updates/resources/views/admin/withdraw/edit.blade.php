<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Withdraw Payment Method') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="updateWithdrawForm" class="modal-form" action="{{ route('admin.withdrawal.update.payment') }}"
          method="post">
          @csrf
          <input type="hidden" id="in_id" name="id">

          <div class="form-group">
            <label for="">{{ __('Name') }}*</label>
            <input type="text" id="in_name" class="form-control" name="name"
              placeholder="{{ __('Enter Category Name') }}">
            <p id="editErr_name" class="mt-2 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Minimum Limit') }} ({{ $settings->base_currency_text }})*</label>
            <input type="number" id="in_min_limit" class="form-control" name="min_limit"
              placeholder="{{ __('Enter Withdraw Minimum Limit') }}">
            <p id="editErr_min_limit" class="mt-1 mb-0 text-danger em"></p>
            <p id="editErr_limit_amount" class="text-danger"></p>
          </div>
          <div class="form-group">
            <label for="">{{ __('Maximum Limit') }} ({{ $settings->base_currency_text }})*</label>
            <input type="number" id="in_max_limit" class="form-control" name="max_limit"
              placeholder="{{ __('Enter Withdraw Maximum Limit') }}">
            <p id="editErr_max_limit" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Fixed Charge') }}</label>
            <input type="number" id="in_fixed_charge" class="form-control" name="fixed_charge"
              placeholder="{{ __('Enter Fixed Charge') }}">
            <p class="mt-1 mb-0 text-warning">{{ __('Value must be less then (Minimum Limit) amount.') }}</p>
            <p id="editErr_fixed_charge" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Percentage Charge') }}</label>
            <input type="number" id="in_percentage_charge" class="form-control" name="percentage_charge"
              placeholder="{{ __('Enter Percentage Charge') }}">
            <p id="editErr_percentage_charge" class="mt-1 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label for="">{{ __('Status') }}*</label>
            <select name="status" id="in_status" class="form-control">
              <option selected="" disabled="">{{ __('Select a Status') }}</option>
              <option value="1">{{ __('Active') }}</option>
              <option value="0">{{ __('Deactive') }}</option>
            </select>
            <p id="editErr_status" class="mt-1 mb-0 text-danger em"></p>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          {{ __('Close') }}
        </button>
        <button id="updateWithdrawBtn" type="button" class="btn btn-primary btn-sm">
          {{ __('Update') }}
        </button>
      </div>
    </div>
  </div>
</div>
