@extends('frontend.layout')
@section('pageHeading')
  {{ !empty($pageHeading) ? $pageHeading->login_page_title : __('Login') }}
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_login }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_login }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->login_page_title : __('Login'),
  ])
  <!-- Authentication-area start -->
  <div class="authentication-area bg-light ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="main-form">
            <div class="main-form-wrapper">
              <h3 class="title mb-30 text-center">
                {{ !empty($pageHeading) ? $pageHeading->login_page_title : __('Login') }}
              </h3>
              @if (Session::has('success'))
                <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
              @endif
              @if (Session::has('error'))
                <div class="alert alert-danger">{{ __(Session::get('error')) }}</div>
              @endif
              <form id="#authForm" action="{{ route('user.login_submit') }}" method="POST">
                @csrf
                <div class="form-group mb-20">
                  <label for="userName" class="form-label color-dark">{{ __('Username') }}<span
                      class="color-red">*</span></label>
                  <input type="text" name="username" value="{{ old('username') }}" id="userName" class="form-control"
                    placeholder="{{ __('Username') }}" required>
                  @error('username')
                    <p class="text-danger mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="form-group mb-20">
                  <label for="password" class="form-label color-dark">{{ __('Password') }}<span
                      class="color-red">*</span></label>
                  <div class="position-relative">
                    <input type="password" name="password" id="password" class="form-control"
                      placeholder="{{ __('Enter Password') }}" required>
                    <span class="show-password-field">
                      <i class="show-icon"></i>
                    </span>
                  </div>
                  @error('password')
                    <p class="text-danger mt-2">{{ $message }}</p>
                  @enderror
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
                <div class="text-center pt-10">
                  <button class="btn btn-lg btn-primary btn-gradient w-100" type="submit"
                    aria-label="Login">{{ __('Login') }}</button>
                </div>
                <div class="form-bottom mt-10">
                  <span class="or-text">
                    <span></span>
                    <span class="font-sm">{{ __('Or Login With') }}</span>
                    <span></span>
                  </span>
                  <div class="btn-groups justify-content-center mt-10">
                    @if ($bs->facebook_login_status == 1)
                      <a class="btn-icon size-md rounded-circle facebook {{ $bs->google_login_status == 0 ? 'aa' : 'bb' }}"
                        href="{{ route('user.login.facebook') }}">
                        <i class="fab fa-facebook-f"></i>
                      </a>
                    @endif

                    @if ($bs->google_login_status == 1)
                      <a class="btn-icon size-md rounded-circle google {{ $bs->facebook_login_status == 0 ? 'aa' : 'bb' }}"
                        href="{{ route('user.login.google') }}">
                        <i class="fab fa-google"></i>
                      </a>
                    @endif
                  </div>
                </div>
              </form>
            </div>
            <div class="d-flex justify-content-between flex-wrap gap-2 mt-20">
              <div class="link font-sm">
                <a href="{{ route('user.forget_password') }}">{{ __('Forgot password') . '?' }}</a>
              </div>
              <div class="link font-sm">
                {{ __("Don't have an account") . '?' }} <a href="{{ route('user.signup') }}" title="Go Signup"
                  target="_self">{{ __('Click Here') }}</a>
                {{ __('to Signup') }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Authentication-area end -->
@endsection
