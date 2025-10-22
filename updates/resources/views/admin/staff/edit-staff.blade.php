@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Edit Staff') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Staff Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.staff_managment', ['language' => $defaultLang->code]) }}">{{ __('Staffs') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      @if (count($staff->StaffContent) == 0)
        {{ '-' }}
      @else
        @foreach ($staff->StaffContent as $content)
          <li class="nav-item">
            <a href="#">
              {{ $content->name }}
            </a>
          </li>
        @endforeach
      @endif
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>

      <li class="nav-item">
        <a href="
        #">{{ __('Edit Staff') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Edit Staff') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('admin.staff_managment', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              @php
                $iconSize = '12px';
              @endphp
              <i class="fas fa-backward" style="font-size: {{ $iconSize }};"></i>
            </span>
            {{ __('Back') }}
          </a>
        </div>

        <div class="card-body pt-5 pb-5">
          <div class="alert alert-danger pb-1 dis-none" id="service_erros">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul></ul>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <form id="serviceForm" action="{{ route('admin.staff_managment.update', ['id' => $staff->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $staff->id }}" name="staffId">
                <input type="hidden" value="{{ $staff->vendor_id }}" name="vendorId">
                <div class="version border-0">
                  <div class="version-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">{{ __('Staff Image') . '*' }}</label>
                          <br>
                          <div class="thumb-preview">
                            <img src="{{ asset('assets/img/staff/' . $staff->image) }}" alt="..."
                              class="uploaded-img">
                          </div>

                          <div class="mt-3">
                            <div role="button" class="btn btn-primary btn-sm upload-btn">
                              {{ __('Choose Image') }}
                              <input type="file" class="img-input" name="staff_image">
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Email') . '*' }}</label>
                          <input type="email" class="form-control" name="email" value="{{ $staff->email }}"
                            placeholder="{{ __('Enter Email') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Phone') . '*' }}</label>
                          <input type="text" class="form-control" name="phone" value="{{ $staff->phone }}"
                            placeholder="{{ __('Enter Phone') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Status') . '*' }}</label>
                          <select name="status" class="form-control">
                            <option selected="" disabled="">{{ __('Select a Status') }}</option>
                            <option value="1" @if ($staff->status == 1) selected @endif>{{ __('Active') }}
                            </option>
                            <option value="0" @if ($staff->status == 0) selected @endif>{{ __('Deactive') }}
                            </option>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" {{ $staff->email_status == 1 ? 'checked' : '' }}
                              name="show_email_addresss" class="custom-control-input" id="show_email_addresss">
                            <label class="custom-control-label"
                              for="show_email_addresss">{{ __('Show Email Address') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" {{ $staff->phone_status == 1 ? 'checked' : '' }}
                              name="show_phone" class="custom-control-input" id="show_phone">
                            <label class="custom-control-label" for="show_phone">{{ __('Show Phone Number') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" {{ $staff->info_status == 1 ? 'checked' : '' }}
                              name="show_information" class="custom-control-input" id="show_information">
                            <label class="custom-control-label"
                              for="show_information">{{ __('Show Information') }}</label>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Order Number') . '*' }}</label>
                          <input type="number" class="form-control" name="order_number"
                            value="{{ $staff->order_number }}" placeholder="Enter Order Number">
                          <p class="text-warning mt-2 mb-0">
                            <small>{{ __('The higher the order number is, the later the staff will be shown.') }}</small>
                          </p>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Allow Login ') }}</label>
                          <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                              <input type="radio" name="login_allow_toggle" value="1" class="selectgroup-input"
                                {{ $staff->allow_login == 1 ? 'checked' : '' }}>
                              <span class="selectgroup-button">{{ __('YES') }}</span>
                            </label>

                            <label class="selectgroup-item">
                              <input type="radio" name="login_allow_toggle" value="0" class="selectgroup-input"
                                {{ $staff->allow_login == 0 ? 'checked' : '' }}>
                              <span class="selectgroup-button">{{ __('NO') }}</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="allowLoginShowOff {{ $staff->allow_login == 0 ? 'd-none' : '' }}">
                          <div class="form-group">
                            <label>{{ __('Username') . '*' }}</label>
                            <div class="input-group">
                              <input type="text" class="form-control" name="username"
                                value="{{ $staff->username }}" placeholder="{{ __('Enter Username') }}">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="accordion" class="mt-5">
                      @foreach ($languages as $language)
                        @php
                          $staffContent = App\Models\Staff\StaffContent::where('staff_id', $staff->id)
                              ->where('language_id', $language->id)
                              ->first();
                        @endphp
                        <div class="version">
                          <div class="version-header" id="heading{{ $language->id }}">
                            <h5 class="mb-0">
                              <button type="button"
                                class="btn btn-link {{ $language->direction == 1 ? 'rtl text-right' : '' }}"
                                data-toggle="collapse" data-target="#collapse{{ $language->id }}"
                                aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $language->id }}">
                                {{ $language->name . __(' Language') }}
                                {{ $language->is_default == 1 ? '(Default)' : '' }}
                              </button>
                            </h5>
                          </div>

                          <div id="collapse{{ $language->id }}"
                            class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                            <div class="version-body">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                    <label>{{ __('Name') . '*' }}</label>
                                    <input type="text" class="form-control" value="{{ @$staffContent->name }}"
                                      name="{{ $language->code }}_name" placeholder="{{ __('Enter Name') }}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                    <label>{{ __('Address') }}</label>
                                    <input type="text" class="form-control" value="{{ @$staffContent->location }}"
                                      name="{{ $language->code }}_location" placeholder="{{ __('Enter Address') }}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                    <label>{{ __('Information') }}</label>
                                    <textarea class="form-control" name="{{ $language->code }}_information"
                                      placeholder="{{ __('Enter Short Description') }}" rows="4">{{ @$staffContent->information }}</textarea>

                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  @php $currLang = $language; @endphp
                                  @foreach ($languages as $language)
                                    @continue($language->id == $currLang->id)
                                    <div class="form-check py-0">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                          onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $language->id }}', event)">
                                        <span class="form-check-sign">{{ __('Clone for') }} <strong
                                            class="text-capitalize text-secondary">{{ $language->name }}</strong>
                                          {{ __('language') }}</span>
                                      </label>
                                    </div>
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>

                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="ServiceSubmit" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/js/services.js') }}"></script>
  <script src="{{ asset('assets/js/staff.js') }}"></script>
@endsection
