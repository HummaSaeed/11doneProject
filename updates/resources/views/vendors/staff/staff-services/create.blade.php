<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Assign Service') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="ajaxForm" class="modal-form create" action="{{ route('vendor.staff_service_assign.store') }}"
          method="post">
          <input type="hidden" name="staff_id" value="{{ request()->id }}">
          <input type="hidden" id="language" name="language" value="{{ request()->language }}">
          @csrf

          <div class="form-group">
            <label for="">{{ __('Service Title') . '*' }}</label>
            <select id="service" name="service_id" class="form-control select2">
              <option selected disabled>{{ __('Select a service') }}</option>
              @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
              @endforeach
            </select>
            <p id="err_service_id" class="mt-1 mb-0 text-danger em"></p>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          {{ __('Close') }}
        </button>
        <button id="submitBtn" type="button" class="btn btn-primary btn-sm">
          {{ __('Assign Service') }}
        </button>
      </div>
    </div>
  </div>
</div>
