@php
    $version = $settings->theme_version;
@endphp
@extends('frontend.layout')
@section('pageHeading')
    {{ __('Reset Password') }}
@endsection


@section('content')
    @includeIf('frontend.partials.breadcrumb', [
        'breadcrumb' => $bgImg->breadcrumb,
        'title' => __('Reset Password'),
    ])
    <!-- Authentication-area start -->
    <div class="authentication-area ptb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="main-form">
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif
                        <form action="{{ route('vendor.update-forget-password') }}" method="POST">
                            @csrf

                            <input type="hidden" name="token" value="{{ request()->input('token') }}">
                            <div class="title">
                                <h4 class="mb-20">{{ __('Reset Password') }}</h4>
                            </div>
                            <div class="form-group mb-20">
                                <input type="password" class="form-control" name="new_password"
                                    placeholder="{{ __('Password') }}" required>
                                @error('new_password')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mb-20">
                                <input type="password" name="new_password_confirmation"
                                    value="{{ old('new_password_confirmation') }}" class="form-control"
                                    placeholder="{{ __('Confirm Password') }}" required>
                                @error('new_password_confirmation')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="text-center mt-10">
                                <button type="submit" class="btn btn-lg btn-primary radius-md w-100"> {{ __('Submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Authentication-area end -->
@endsection
