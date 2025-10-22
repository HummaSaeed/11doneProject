@extends('admin.layout')
@php
  use App\Models\Language;
  $selLang = Language::where('code', request()->input('language'))->first();
@endphp
@if (!empty($selLang->language) && $selLang->language->rtl == 1)
  @section('styles')
    <style>
      form input,
      form textarea,
      form select {
        direction: rtl;
      }

      form .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
      }
    </style>
  @endsection
@endif

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Edit package') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      <li class="nav-item">
        <a href="#">{{ __('Packages Management') }}</a>
      </li>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.package.index') }}">{{ __('Packages') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ $package->title }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Edit') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Edit package') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.package.index') }}">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            {{ __('Back') }}
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxForm" enctype="multipart/form-data" class="modal-form"
                action="{{ route('admin.package.update') }}" method="POST">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Icon *</label>
                      <div class="btn-group d-block">
                        <button type="button" class="btn btn-primary iconpicker-component"><i
                            class="{{ $package->icon }}"></i></button>
                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-car"
                          data-toggle="dropdown">
                        </button>
                        <div class="dropdown-menu"></div>
                      </div>
                      <input id="inputIcon" type="hidden" name="icon" value="{{ $package->icon }}">
                      @if ($errors->has('icon'))
                        <p class="mb-0 text-danger">{{ $errors->first('icon') }}</p>
                      @endif
                      <div class="mt-2">
                        <small>{{ __('NB: click on the dropdown sign to select an icon.') }}</small>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title">{{ __('Package title') }}*</label>
                      <input id="title" type="text" class="form-control" name="title"
                        placeholder="{{ __('Enter Package title') }}" value="{{ $package->title }}">
                      <p id="err_title" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="price">{{ __('Price') }} ({{ $settings->base_currency_text }})*</label>
                      <input id="price" type="number" class="form-control" name="price"
                        placeholder="{{ __('Enter Package price') }}" value="{{ $package->price }}">
                      <p class="text-warning">
                        <small>{{ __('If price is 0 , than it will appear as free') }}</small>
                      </p>
                      <p id="err_price" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="term">{{ __('Package term') }}*</label>
                      <select id="plan_term" name="term" class="form-control">
                        <option value="" selected disabled>{{ __('Select a Term') }}</option>
                        <option value="monthly" {{ $package->term == 'monthly' ? 'selected' : '' }}>
                          {{ __('monthly') }}</option>
                        <option value="yearly" {{ $package->term == 'yearly' ? 'selected' : '' }}>
                          {{ __('yearly') }}</option>
                        <option value="lifetime" {{ $package->term == 'lifetime' ? 'selected' : '' }}>
                          {{ 'lifetime' }}</option>
                      </select>
                      <p id="err_term" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ __('Number of services') }} *</label>
                      <input type="text" class="form-control" name="number_of_service_add"
                        placeholder="{{ __('Enter Number of services') }}"
                        value="{{ $package->number_of_service_add }}">
                      <p id="err_number_of_service_add" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ __('Number of images/service') }}
                        *</label>
                      <input type="text" name="number_of_service_image" class="form-control"
                        placeholder="{{ __('Enter Number of images/service') }}"
                        value="{{ $package->number_of_service_image }}">
                      <p id="err_number_of_service_image" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">{{ __('Number of appointments') }}
                        *</label>
                      <input type="text" name="number_of_appointment" class="form-control"
                        placeholder="{{ __('Enter Number of appointments') }}"
                        value="{{ $package->number_of_appointment }}">
                      <p id="err_number_of_appointment" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="status">{{ __('Number of staffs limit') }}*</label>
                      <input type="number" name="staff_limit" class="form-control"
                        value="{{ $package->staff_limit }}">
                      <p id="err_staff_limit" class="mb-0 text-danger em"></p>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="status">{{ __('Zoom Meeting') }}*</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="zoom_meeting_status" value="1"
                            class="selectgroup-input zoom_meeting_status"{{ $package->zoom_meeting_status == 1 ? 'checked' : '' }}>
                          <span class="selectgroup-button">{{ __('Enable') }}</span>
                        </label>

                        <label class="selectgroup-item">
                          <input type="radio" name="zoom_meeting_status" value="0"
                            class="selectgroup-input zoom_meeting_status"
                            {{ $package->zoom_meeting_status == 0 ? 'checked' : '' }}>
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
                            class="selectgroup-input calendar_status"{{ $package->calendar_status == 1 ? 'checked' : '' }}>
                          <span class="selectgroup-button">{{ __('Enable') }}</span>
                        </label>

                        <label class="selectgroup-item">
                          <input type="radio" name="calendar_status" value="0"
                            class="selectgroup-input calendar_status"
                            {{ $package->calendar_status == 0 ? 'checked' : '' }}>
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
                            {{ $package->support_ticket_status == 1 ? 'checked' : '' }}>
                          <span class="selectgroup-button">{{ __('Enable') }}</span>
                        </label>

                        <label class="selectgroup-item">
                          <input type="radio" name="support_ticket_status" value="0" class="selectgroup-input"
                            {{ $package->support_ticket_status == 0 ? 'checked' : '' }}>
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
                        <option value="1" {{ $package->status == '1' ? 'selected' : '' }}>
                          {{ __('Active') }}</option>
                        <option value="0" {{ $package->status == '0' ? 'selected' : '' }}>
                          {{ __('Deactive') }}</option>
                      </select>
                      <p id="err_status" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="status">{{ __('Recommended') }}*</label>
                      <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                          <input type="radio" name="recommended" value="1"
                            {{ $package->recommended == 1 ? 'checked' : '' }} class="selectgroup-input" checked="">
                          <span class="selectgroup-button">{{ __('Yes') }}</span>
                        </label>

                        <label class="selectgroup-item">
                          <input type="radio" name="recommended" value="0"
                            {{ $package->recommended == 0 ? 'checked' : '' }} class="selectgroup-input recommended">
                          <span class="selectgroup-button">{{ __('No') }}</span>
                        </label>
                      </div>
                      <p id="err_recommended" class="mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>{{ __('Custom Feature') }}</label>
                      <textarea name="custom_features" class="form-control">{{ $package->custom_features }}</textarea>
                      <p id="err_custom_features" class="mb-0 text-danger em"></p>
                      <p class="text-warning">
                        {{ __('Each new line will be shown as a new feature in the pricing plan') }}
                      </p>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">{{ __('Update') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('assets/js/packages.js') }}"></script>
  <script src="{{ asset('assets/admin/js/edit-package.js') }}"></script>
@endsection
