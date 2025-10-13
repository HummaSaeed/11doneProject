<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Hour') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form autocomplete="off" id="ajaxForm" class="modal-form create"
          action="{{ route('vendor.service-hour.store') }}" method="post">
          <input type="hidden" name="staff_id" value="{{ request()->staff_id }}">
          <input type="hidden" name="staff_day_id" value="{{ request()->day_id }}">
          @csrf
          <div class="form-group">
            <label for="">{{ __('Start Time') . '*' }}</label>
            <input type="text" name="start_time" class="form-control timepicker"
              placeholder="{{ __('Choose Start Time') }}" id="in_start_time">
            <p id="err_start_time" class="mt-1 mb-0 text-danger em"></p>
          </div>
          <div class="form-group">
            <label for="">{{ __('End Time') . '*' }}</label>
            <input type="text" name="end_time" class="form-control timepicker"
              placeholder="{{ __('Choose End Time') }}" id="in_end_time">
            <p id="err_end_time" class="mt-1 mb-0 text-danger em"></p>
          </div>
          <div class="form-group">
            <label for="">{{ __('Max Booking') }}</label>
            <input type="number" name="max_booking" class="form-control"
              placeholder="{{ __('Add Maximum Booking Number') }}" id="in_max_booking">
            <p id="err_max_booking" class="mt-1 mb-0 text-danger em"></p>
            <p class="text-warning mt-2 mb-0">
              <small>
                {{ __('Maximum number of bookings staff can take during this time slot.') }}
                <br>
                {{ __('If you do not want to put any limit, then leave it blank.') }}
              </small>
            </p>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          {{ __('Close') }}
        </button>
        <button id="submitBtn" type="button" class="btn btn-primary btn-sm">
          {{ __('Save') }}
        </button>
      </div>
    </div>
  </div>
</div>
