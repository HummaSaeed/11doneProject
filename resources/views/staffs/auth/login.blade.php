@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->staff_login_page_title : __('Staff Login') }}
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_staff_login_page }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_staff_login_page }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->staff_login_page_title : __('Staff Login'),
  ])
  <!-- Authentication-area start -->
  <div class="authentication-area bg-light ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="main-form">
            <div class="main-form-wrapper">
              <h3 class="title mb-30 text-center">
                {{ !empty($pageHeading) ? $pageHeading->staff_login_page_title : __('Login') }}
              </h3>
              @if (Session::has('success'))
                <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
              @endif
              @if (Session::has('error'))
                <div class="alert alert-danger">{{ __(Session::get('error')) }}</div>
              @endif
              <form id="#authForm" action="{{ route('staff.login_submit') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <label for="userName" class="form-label color-dark">{{ __('Username') }}<span
                          class="color-red">*</span></label>
                      <input type="text" value="{{ old('username') }}" name="username" id="userName"
                        class="form-control" placeholder="{{ __('Username') }}">
                      @error('username')
                        <p class="text-danger mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <label for="password" class="form-label color-dark">{{ __('Password') }}<span
                          class="color-red">*</span></label>
                      <div class="position-relative">
                        <input type="password" name="password" id="password" class="form-control"
                          placeholder="{{ __('Password') }}">
                        <span class="show-password-field">
                          <i class="show-icon"></i>
                        </span>
                      </div>
                      @error('password')
                        <p class="text-danger mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  @if ($bs->google_recaptcha_status == 1)
                    <div class="form-group mb-20">
                      {!! NoCaptcha::renderJs() !!}
                      {!! NoCaptcha::display() !!}

                      @error('g-recaptcha-response')
                        <p class="mt-1 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  @endif
                </div>
                <div class="text-center pt-10">
                  <button class="btn btn-lg btn-primary btn-gradient w-100" type="submit" aria-label="Login">
                    {{ __('Login') }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
@endsection
