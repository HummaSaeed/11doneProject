<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Work Process') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="ajaxEditForm" class="modal-form" action="{{ route('admin.home_page.update_work_process') }}"
          method="post">
          @csrf
          <input type="hidden" name="id" id="in_id">
          @if ($settings->theme_version == 1 || $settings->theme_version == 3)
            <div class="form-group">
              <label for="">{{ __('Work Process Icon') . '*' }}</label>
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
             <div class="form-group">
              <label>{{ __('Background Color') . '*' }}</label>
              <input class="jscolor form-control" name="background_color" id="in_background_color">
              <p id="editErr_background_color" class="mt-2 mb-0 text-danger em"></p>
            </div>
          @endif
          @if ($settings->theme_version == 2)
            <div class="form-group">
              <label for="">{{ __('Work Process Image') . '*' }}</label>
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
            <label for="">{{ __('Title') . '*' }}</label>
            <input type="text" class="form-control" name="title" placeholder="{{ __('Enter Work Process Title') }}"
              id="in_title">
            <p id="editErr_title" class="mt-2 mb-0 text-danger em"></p>
          </div>
          @if ($settings->theme_version == 1 || $settings->theme_version == 3)
            <div class="form-group">
              <label for="">{{ __('Text') . '*' }}</label>
              <textarea name="text" class="form-control" placeholder="{{ __('Enter Text') }}" id="in_text"></textarea>
              <p id="editErr_text" class="mt-2 mb-0 text-danger em"></p>
            </div>
          @endif
          <div class="form-group">
            <label for="">{{ __('Serial Number') . '*' }}</label>
            <input type="number" class="form-control ltr" name="serial_number"
              placeholder="{{ __('Enter Work Process Serial Number') }}" id="in_serial_number">
            <p id="editErr_serial_number" class="mt-2 mb-0 text-danger em"></p>
            <p class="text-warning mt-2 mb-0">
              <small>{{ __('The higher the serial number is, the later the work process will be shown.') }}</small>
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
