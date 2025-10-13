@extends('frontend.layout')

@section('pageHeading')
  {{ !empty($pageHeading) && $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Sign up') }}
@endsection

@section('metaKeywords')
  {{ !empty($seoInfo) ? $seoInfo->meta_keywords_vendor_signup : '' }}
@endsection

@section('metaDescription')
  {{ !empty($seoInfo) ? $seoInfo->meta_description_vendor_signup : '' }}
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Sign up'),
  ])
  <!-- Authentication-area start -->
  <div class="authentication-area bg-light ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="main-form">
            <div class="main-form-wrapper">
              <h3 class="title mb-30 text-center">
                {{ !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Sign up') }}
              </h3>
              @if (Session::has('success'))
                <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
              @endif
              <form action="{{ route('vendor.signup_submit') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <label for="userName" class="form-label color-dark">{{ __('Full Name') }}<span
                          class="color-red">*</span></label>
                      <input type="text" name="username" value="{{ old('username') }}" id="userName"
                        class="form-control" placeholder="{{ __('Full Name') }}">
                      @error('username')
                        <p class="text-danger mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <label for="email" class="form-label color-dark">{{ __('Email') }}<span
                          class="color-red">*</span></label>
                      <input type="email" value="{{ old('email') }}" name="email" id="email"
                        class="form-control" placeholder="{{ __('Email') }}">
                      @error('email')
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
                  <div class="col-12">
                    <div class="form-group mb-20">
                      <label for="confirmPassword" class="form-label color-dark">{{ __('Confirm Password') }}<span
                          class="color-red">*</span></label>
                      <div class="position-relative">
                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control"
                          placeholder="{{ __('Confirm Password') }}">
                        <span class="show-password-field">
                          <i class="show-icon"></i>
                        </span>
                      </div>
                      @error('password_confirmation')
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
                  <button class="btn btn-lg btn-primary btn-gradient w-100" type="submit"
                    aria-label="Signup">{{ __('Signup') }}</button>
                </div>
              </form>
            </div>
            <div class="text-center mt-20">
              <div class="link font-sm">
                {{ __('Already a member') . '?' }} <a href="{{ route('vendor.login') }}" target="_self"
                  title="Login Now">{{ __('Login Now') }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
@endsection
