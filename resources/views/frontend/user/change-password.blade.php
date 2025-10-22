@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->change_password_page_title : __('Change Password') }}
@endsection


@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->change_password_page_title : __('Change Password'),
  ])
  <div class="user-dashboard pt-100 pb-60">
    <div class="container">
      <div class="row gx-xl-5">
        <div class="col-lg-3">
          @includeIf('frontend.user.side-navbar')
        </div>
        <div class="col-lg-9">
          <div class="user-profile-details mb-40">
            <div class="account-info radius-md">
              <div class="title">
                <h4>{{ __('Change Password') }}</h4>
              </div>
              <div class="edit-info-area mt-30">
                @if (Session::has('success'))
                  <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <form action="{{ route('user.update_password') }}" method="POST">
                  @csrf
                  <div class="form-group mb-20">
                    <input type="password" class="form-control" placeholder="{{ __('Current Password') }}"
                      name="current_password">
                    <span toggle="#currentPass" class="show-password-field">
                      <i class="show-icon"></i>
                    </span>
                    @error('current_password')
                      <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group mb-20">
                    <input type="password" id="newPass" class="form-control" placeholder="{{ __('New Password') }}"
                      name="new_password">
                    <span toggle="#newPass" class="show-password-field">
                      <i class="show-icon"></i>
                    </span>
                     @error('new_password')
                      <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group mb-20">
                    <input type="password" id="confirmPass" class="form-control" placeholder="{{ __('Confirm Password') }}"
                      name="new_password_confirmation">
                    <span toggle="#confirmPass" class="show-password-field">
                      <i class="show-icon"></i>
                    </span>
                  </div>
                  <div class="mb-15">
                    <div class="form-button">
                      <button type="submit" class="btn btn-lg btn-primary shadow-none">{{ __('Save Changes') }}</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
