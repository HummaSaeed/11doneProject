@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Plugins') }}</h4>
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
        <a href="#">{{ __('Settings') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Plugins') }}</a>
      </li>
    </ul>
  </div>
  <div class="alert alert-warning text-dark">
    {{ __('If you want to enable zoom & calendar credentials for vendors. At first select vendor.') }}
  </div>
  <div class="row">
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_zoom') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Zoom') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Account ID') . '*' }}</label>
                  <input type="text" id="zoom_account_id" class="form-control" name="zoom_account_id"
                    value="{{ !empty($data) ? $data->zoom_account_id : '' }}">

                  @if ($errors->has('zoom_account_id'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('zoom_account_id') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Client ID') . '*' }}</label>
                  <input type="text" id="zoom_client_id" class="form-control" name="zoom_client_id"
                    value="{{ !empty($data) ? $data->zoom_client_id : '' }}">

                  @if ($errors->has('zoom_client_id'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('zoom_client_id') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Client Secret') . '*' }}</label>
                  <input type="text" id="zoom_client_secret" class="form-control" name="zoom_client_secret"
                    value="{{ !empty($data) ? $data->zoom_client_secret : '' }}">

                  @if ($errors->has('zoom_client_secret'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('zoom_client_secret') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label for="">{{ __('Vendor') }}</label>
                  <select name="vendor_id" id="zoom" class="form-control select2">
                    <option value="0" selected>{{ __('Please Select') }}</option>
                    @foreach ($vendors as $vendor)
                      @php
                        $permission = App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor->id);
                      @endphp
                      @if ($permission->zoom_meeting_status == 1)
                        <option value="{{ $vendor->id }}">{{ $vendor->username }}</option>
                      @endif
                    @endforeach
                  </select>
                  <p class="text-warning">
                    {{ __('if you do not select any vendor, then this credentials will be applied for Admin') }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_calender') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Google Calendar') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Upload Your File ') . '*' }}</label>
                  <input type="file" class="form-control" name="google_calendar"
                    value="{{ !empty($data) ? $data->google_calendar : '' }}">

                  @if ($errors->has('google_calendar'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_calendar') }}</p>
                  @endif
                  <span class="d-none"
                    id="calendar_file">{{ __('You have a file, and you can change it by re-uploading it.') }}<br>
                  </span>
                  @if ($data && $data->google_calendar)
                    {{ __('You have a file, and you can change it by re-uploading it.') }}
                  @endif
                  <br>
                  <span class="text-warning">{{ __('Only json file allowed.') }}
                  </span>
                </div>
                <div class="form-group">
                  <label>{{ __('Calender ID') . '*' }}</label>
                  <input type="text" class="form-control" id="calender_id" name="calender_id"
                    value="{{ !empty($data) ? $data->calender_id : '' }}">

                  @if ($errors->has('calender_id'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('calender_id') }}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label for="">{{ __('Vendor') }}</label>
                  <select name="vendor_id" id="calendar" class="form-control select2">
                    <option value="0" selected>{{ __('Please Select') }}</option>
                    @foreach ($vendors as $vendor)
                      @php
                        $permission = App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor->id);
                      @endphp
                      @if ($permission->zoom_meeting_status == 1)
                        <option value="{{ $vendor->id }}">{{ $vendor->username }}</option>
                      @endif
                    @endforeach
                  </select>
                  <p class="text-warning">
                    {{ __('if you do not select any vendor, then this credentials will be applied for Admin') }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_disqus') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Disqus') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Disqus Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="disqus_status" value="1" class="selectgroup-input"
                        {{ $data->disqus_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="disqus_status" value="0" class="selectgroup-input"
                        {{ $data->disqus_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('disqus_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('disqus_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Disqus Short Name') . '*' }}</label>
                  <input type="text" class="form-control" name="disqus_short_name"
                    value="{{ $data->disqus_short_name }}">

                  @if ($errors->has('disqus_short_name'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('disqus_short_name') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_tawkto') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Tawk.To') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Tawk.To Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="tawkto_status" value="1" class="selectgroup-input"
                        {{ $data->tawkto_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="tawkto_status" value="0" class="selectgroup-input"
                        {{ $data->tawkto_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('tawkto_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('tawkto_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Tawk.To Direct Chat Link') . '*' }}</label>
                  <input type="text" class="form-control" name="tawkto_direct_chat_link"
                    value="{{ $data->tawkto_direct_chat_link }}">

                  @if ($errors->has('tawkto_direct_chat_link'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('tawkto_direct_chat_link') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_recaptcha') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Google Recaptcha') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Recaptcha Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="google_recaptcha_status" value="1" class="selectgroup-input"
                        {{ $data->google_recaptcha_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="google_recaptcha_status" value="0" class="selectgroup-input"
                        {{ $data->google_recaptcha_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('google_recaptcha_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_recaptcha_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Recaptcha Site Key') . '*' }}</label>
                  <input type="text" class="form-control" name="google_recaptcha_site_key"
                    value="{{ $data->google_recaptcha_site_key }}">

                  @if ($errors->has('google_recaptcha_site_key'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_recaptcha_site_key') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Recaptcha Secret Key') . '*' }}</label>
                  <input type="text" class="form-control" name="google_recaptcha_secret_key"
                    value="{{ $data->google_recaptcha_secret_key }}">

                  @if ($errors->has('google_recaptcha_secret_key'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_recaptcha_secret_key') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_facebook') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Login via Facebook') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Login Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="facebook_login_status" value="1" class="selectgroup-input"
                        {{ !empty($data) && $data->facebook_login_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Enable') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="facebook_login_status" value="0" class="selectgroup-input"
                        {{ !empty($data) && $data->facebook_login_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Disable') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('facebook_login_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('facebook_login_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('App ID') . '*' }}</label>
                  <input type="text" class="form-control" name="facebook_app_id"
                    value="{{ !empty($data) ? $data->facebook_app_id : '' }}">

                  @if ($errors->has('facebook_app_id'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('facebook_app_id') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('App Secret') . '*' }}</label>
                  <input type="text" class="form-control" name="facebook_app_secret"
                    value="{{ !empty($data) ? $data->facebook_app_secret : '' }}">

                  @if ($errors->has('facebook_app_secret'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('facebook_app_secret') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_google') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('Login via Google') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('Login Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="google_login_status" value="1" class="selectgroup-input"
                        {{ !empty($data) && $data->google_login_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Enable') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="google_login_status" value="0" class="selectgroup-input"
                        {{ !empty($data) && $data->google_login_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Disable') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('google_login_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_login_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Client ID') . '*' }}</label>
                  <input type="text" class="form-control" name="google_client_id"
                    value="{{ !empty($data) ? $data->google_client_id : '' }}">

                  @if ($errors->has('google_client_id'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_client_id') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('Client Secret') . '*' }}</label>
                  <input type="text" class="form-control" name="google_client_secret"
                    value="{{ !empty($data) ? $data->google_client_secret : '' }}">

                  @if ($errors->has('google_client_secret'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_client_secret') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <form action="{{ route('admin.basic_settings.update_whatsapp') }}" method="post">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-12">
                <div class="card-title">{{ __('WhatsApp') }}</div>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label>{{ __('WhatsApp Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_status" value="1" class="selectgroup-input"
                        {{ $data->whatsapp_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_status" value="0" class="selectgroup-input"
                        {{ $data->whatsapp_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('whatsapp_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Number') . '*' }}</label>
                  <input type="text" class="form-control" name="whatsapp_number"
                    value="{{ $data->whatsapp_number }}">

                  @if ($errors->has('whatsapp_number'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_number') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Header Title') . '*' }}</label>
                  <input type="text" class="form-control" name="whatsapp_header_title"
                    value="{{ $data->whatsapp_header_title }}">

                  @if ($errors->has('whatsapp_header_title'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_header_title') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Popup Status') . '*' }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_popup_status" value="1" class="selectgroup-input"
                        {{ $data->whatsapp_popup_status == 1 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Active') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="radio" name="whatsapp_popup_status" value="0" class="selectgroup-input"
                        {{ $data->whatsapp_popup_status == 0 ? 'checked' : '' }}>
                      <span class="selectgroup-button">{{ __('Deactive') }}</span>
                    </label>
                  </div>

                  @if ($errors->has('whatsapp_popup_status'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_popup_status') }}</p>
                  @endif
                </div>

                <div class="form-group">
                  <label>{{ __('WhatsApp Popup Message') . '*' }}</label>
                  <textarea class="form-control" name="whatsapp_popup_message" rows="2">{{ $data->whatsapp_popup_message }}</textarea>

                  @if ($errors->has('whatsapp_popup_message'))
                    <p class="mt-1 mb-0 text-danger">{{ $errors->first('whatsapp_popup_message') }}</p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/js/plugin.js') }}"></script>
@endsection
