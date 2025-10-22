<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Category') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="ajaxEditForm" class="modal-form" action="{{ route('admin.service_managment.category.update') }}"
          method="post">
          @csrf
          <input type="hidden" id="in_id" name="id">

          @if ($settings->theme_version == 1 || $settings->theme_version == 2)
            <div class="form-group">
              <label>{{ __('Category Icon') . '*' }}</label>
              <div class="btn-group d-block">
                <button type="button" class="btn btn-primary iconpicker-component edit-iconpicker-component">
                  <i class="" id="in_icon"></i>
                </button>
                <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-car"
                  data-toggle="dropdown"></button>
                <div class="dropdown-menu"></div>
              </div>

              <input type="hidden" id="editInputIcon" name="icon">
              <p id="editErr_icon" class="mt-2 mb-0 text-danger em"></p>

              <div class="text-warning mt-2">
                <small>{{ __('Click on the dropdown icon to select an icon.') }}</small>
              </div>
            </div>
          @endif
          @if ($settings->theme_version == 3)
            <div class="form-group">
              <label>{{ __('Featured Image') . '*' }}</label>
              <br>
              <div class="thumb-preview">
                <img src="" alt="..." class="uploaded-img in_image">
              </div>

              <div class="mt-3">
                <div role="button" class="btn btn-primary btn-sm upload-btn">
                  {{ __('Choose Image') }}
                  <input type="file" class="img-input" name="image">
                </div>
              </div>
              <p id="editErr_image" class="mt-2 mb-0 text-danger em"></p>
            </div>
          @endif

          <div class="form-group">
            <label>{{ __('Background Color') . '*' }}</label>
            <input class="jscolor form-control ltr" id="in_background_color" name="background_color">
            <p id="err_background_color" class="mt-2 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label>{{ __('Name') . '*' }}</label>
            <input type="text" id="in_name" class="form-control" name="name"
              placeholder="{{ __('Enter Category Name') }}">
            <p id="editErr_name" class="mt-2 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label>{{ __('Status') . '*' }}</label>
            <select name="status" id="in_status" class="form-control">
              <option disabled>{{ __('Select Category Status') }}</option>
              <option value="1">{{ __('Active') }}</option>
              <option value="0">{{ __('Deactive') }}</option>
            </select>
            <p id="editErr_status" class="mt-2 mb-0 text-danger em"></p>
          </div>

          <div class="form-group">
            <label>{{ __('Serial Number') . '*' }}</label>
            <input type="number" id="in_serial_number" class="form-control ltr" name="serial_number"
              placeholder="{{ __('Enter Category Serial Number') }}">
            <p id="editErr_serial_number" class="mt-2 mb-0 text-danger em"></p>
            <p class="text-warning mt-2 mb-0">
              <small>{{ __('The higher the serial number is, the later the category will be shown.') }}</small>
            </p>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
          {{ __('Close') }}
        </button>
        <button id="updateBtn" type="button" class="btn btn-primary btn-sm">
          {{ __('Update') }}
        </button>
      </div>
    </div>
  </div>
</div>
