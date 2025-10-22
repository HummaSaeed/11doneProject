@php
    $version = $settings->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
    {{ !empty($pageHeading) ? $pageHeading->vendor_forget_password_page_title : __('Forget Password') }}
@endsection
@section('metaKeywords')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_keywords_vendor_forget_password }}
    @endif
@endsection

@section('metaDescription')
    @if (!empty($seoInfo))
        {{ $seoInfo->meta_descriptions_vendor_forget_password }}
    @endif
@endsection

@section('content')
    @includeIf('frontend.partials.breadcrumb', [
        'breadcrumb' => $bgImg->breadcrumb,
        'title' => !empty($pageHeading) ? $pageHeading->vendor_forget_password_page_title : __('Forget Password'),
    ])
    <!-- Authentication-area start -->
    <div class="authentication-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="main-form">
                        <div class="title">
                            <h4 class="mb-20">{{ !empty($pageHeading) ? $pageHeading->vendor_forget_password_page_title : __('Forget Password') }}</h4>
                        </div>
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ __(Session::get('success')) }}</div>
                        @endif
                        @if (Session::has('warning'))
                            <div class="alert alert-success">{{ __(Session::get('warning')) }}</div>
                        @endif
                        <form action="{{ route('vendor.forget.mail') }}" method="POST">
                            @csrf
                            <div class="form-group mb-20">
                                <input type="text" class="form-control" name="email"
                                    placeholder="{{ __('Email Address') }}">
                                @error('email')
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
                            <div class="text-center mt-10">
                                <button type="submit"
                                    class="btn btn-lg btn-primary btn-gradient w-100">{{ __('Send me a recovery link') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Authentication-area end -->
@endsection
