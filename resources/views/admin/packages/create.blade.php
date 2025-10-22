  <!-- Create Blog Modal -->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Add Package') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form id="ajaxForm" enctype="multipart/form-data" class="modal-form"
            action="{{ route('admin.package.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">{{ __('Icon') . '*' }}</label>
                  <div class="btn-group d-block">
                    <button type="button" class="btn btn-primary iconpicker-component">
                      <i class="fa fa-fw fa-heart"></i>
                    </button>
                    <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-car"
                      data-toggle="dropdown"></button>
                    <div class="dropdown-menu"></div>
                  </div>

                  <input type="hidden" id="inputIcon" name="icon">
                  <p id="err_icon" class="mt-2 mb-0 text-danger em"></p>

                  <div class="text-warning mt-2">
                    <small>{{ __('Click on the dropdown icon to select an icon.') }}</small>
                  </div>
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group">
                  <label for="title">{{ __('Package title') }}*</label>
                  <input id="title" type="text" class="form-control" name="title"
                    placeholder="{{ __('Enter Package title') }}" value="">
                  <p id="err_title" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="price">{{ __('Price') }} ({{ $settings->base_currency_text }})*</label>
                  <input id="price" type="number" class="form-control" name="price"
                    placeholder="{{ __('Enter Package price') }}" value="">
                  <p id="err_price" class="mb-0 text-danger em"></p>
                  <p class="text-warning">
                    <small>{{ __('If price is 0 , than it will appear as free') }}</small>
                  </p>

                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="term">{{ __('Package term') }}*</label>
                  <select id="term" name="term" class="form-control" required>
                    <option value="" selected disabled>{{ __('Choose a Package term') }}</option>
                    <option value="monthly">{{ __('monthly') }}</option>
                    <option value="yearly">{{ __('yearly') }}</option>
                    <option value="lifetime">{{ __('lifetime') }}</option>
                  </select>
                  <p id="err_term" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">{{ __('Number of services') }} *</label>
                  <input type="text" class="form-control" name="number_of_service_add"
                    placeholder="{{ __('Enter Number of services') }}">
                  <p id="err_number_of_service_add" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">{{ __('Number of images/service') }}
                    *</label>
                  <input type="text" name="number_of_service_image" class="form-control"
                    placeholder="{{ __('Enter Number of images/service') }}">
                  <p id="err_number_of_service_image" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">{{ __('Number of appointments') }}
                    *</label>
                  <input type="text" name="number_of_appointment" class="form-control"
                    placeholder="{{ __('Enter Number of appointments') }}">
                  <p id="err_number_of_appointment" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">{{ __('Number of staffs') }}*</label>
                  <input type="number" placeholder="Enter Number of staffs" name="staff_limit"
                    class="form-control">
                  <p id="err_staff_limit" class="mb-0 text-danger em"></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">{{ __('Zoom Meeting') }}*</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="zoom_meeting_status" value="1"
                        class="selectgroup-input zoom_meeting_status">
                      <span class="selectgroup-button">{{ __('Enable') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="zoom_meeting_status" value="0"
                        class="selectgroup-input zoom_meeting_status" checked="">
                      <span class="selectgroup-button">{{ __('Disable') }}</span>
                    </label>
                  </div>
                  <p id="err_zoom_meeting_status" class="mb-0 text-danger em"></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">{{ __('Google Calendar') }}*</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="calendar_status" value="1"
                        class="selectgroup-input calendar_status">
                      <span class="selectgroup-button">{{ __('Enable') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="calendar_status" value="0"
                        class="selectgroup-input calendar_status" checked="">
                      <span class="selectgroup-button">{{ __('Disable') }}</span>
                    </label>
                  </div>
                  <p id="err_calendar_status" class="mb-0 text-danger em"></p>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">{{ __('Support Tickets') }}*</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="support_ticket_status" value="1" class="selectgroup-input"
                        checked="">
                      <span class="selectgroup-button">{{ __('Enable') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="support_ticket_status" value="0" class="selectgroup-input">
                      <span class="selectgroup-button">{{ __('Disable') }}</span>
                    </label>
                  </div>
                  <p id="err_support_ticket_status" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">{{ __('Status') }}*</label>
                  <select id="status" class="form-control ltr" name="status">
                    <option value="" selected disabled>{{ __('Select a status') }}</option>
                    <option value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Deactive') }}</option>
                  </select>
                  <p id="err_status" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="status">{{ __('Recommended') }}*</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="recommended" value="1" class="selectgroup-input">
                      <span class="selectgroup-button">{{ __('Yes') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="recommended" value="0" class="selectgroup-input recommended"
                        checked="">
                      <span class="selectgroup-button">{{ __('No') }}</span>
                    </label>
                  </div>
                  <p id="err_recommended" class="mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ __('Custom Feature') }}</label>
                  <textarea name="custom_features" class="form-control"></textarea>
                  <p id="err_custom_features" class="mb-0 text-danger em"></p>
                  <p class="text-warning">{{ __('Each new line will be shown as a new feature in the pricing plan') }}
                  </p>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
          <button id="submitBtn" type="button" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
      </div>
    </div>
  </div>
