@extends('frontend.layout')
@section('pageHeading')
    {{ !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login') }}
@endsection
@section('metaKeywords')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_keywords_vendor_login }}
    @endif
@endsection

@section('metaDescription')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_description_vendor_login }}
    @endif
@endsection

@section('content')
    @includeIf('frontend.partials.breadcrumb', [
        'breadcrumb' => $bgImg->breadcrumb,
        'title' => !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login'),
    ])
    <!-- Authentication-area start -->
    <div class="authentication-area bg-light ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main-form">
                        <div class="main-form-wrapper">
                            <h3 class="title mb-30 text-center">
                                {{ !empty($pageHeading) ? $pageHeading->vendor_login_page_title : __('Login') }}
                            </h3>
                            @if (Session::has('success'))
                                <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger">{{ __(Session::get('error')) }}</div>
                            @endif
                            <form action="{{ route('vendor.login_submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ request()->buy_package }}">
                                <input type="hidden" name="redirect_path" value="{{ request()->redirectPath }}">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-20">
                                            <label for="email" class="form-label color-dark">{{ __('Email') }}<span
                                                    class="color-red">*</span></label>
                                            <input type="email" value="{{ old('email') }}" name="email" id="email"
                                                class="form-control" placeholder="{{ __('Enter Your Email Address') }}">
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
                                                    placeholder="{{ __('Password') }}" required>
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
                                    <button class="btn btn-lg btn-primary btn-gradient w-100" type="submit"
                                        aria-label="Login">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap gap-2 mt-20">
                            <div class="link font-sm">
                                <a href="{{ route('vendor.forget.password') }}">{{ __('Forgot password') . '?' }}</a>
                            </div>
                            <div class="link font-sm">
                                {{ __("Don't have an account") . '?' }} <a href="{{ route('vendor.signup') }}"
                                    title="Go Signup" target="_self">{{ __('Click Here') }}</a>
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
