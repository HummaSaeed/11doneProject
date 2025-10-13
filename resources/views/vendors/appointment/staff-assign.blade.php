<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Staff Assign') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="ajaxForm" class="modal-form create" action="{{ route('vendor.appointment.staff_assign') }}"
          method="post">
          @php
            $staffs = App\Models\Staff\Staff::join('staff_contents', 'staff.id', '=', 'staff_contents.staff_id')
                ->where('staff_contents.language_id', $defaultLang->id)
                ->where('staff.vendor_id', $item->vendor_id)
                ->select('staff.id', 'staff.username', 'staff_contents.name')
                ->get();
          @endphp
          <input type="hidden" name="appointment_id" id="in_appointment_id">
          @csrf
          <div class="form-group">
            <label>{{ __('Staff') . '*' }}</label>
            <select name="staff_id" class="select2">
              <option value="" selected>{{ __('Select Staff') }}</option>
              @foreach ($staffs as $staff)
                @if (!empty($staff->username))
                  <option value="{{ $staff->id }}">{{ $staff->username }}</option>
                @else
                  <option value="{{ $staff->id }}">{{ @$staff->name }}</option>
                @endif
              @endforeach
            </select>
            <p id="err_staff_id" class="mt-1 mb-0 text-danger em"></p>
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
