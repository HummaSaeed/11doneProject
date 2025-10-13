@php
  $basicInfo = App\Models\BasicSettings\Basic::select('breadcrumb', 'theme_version')->firstOrFail();
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@section('pageHeading')
  {{ __('404') }}
@endsection
@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $basicInfo->breadcrumb,
      'title' => __('404'),
  ])

  <!--====== Start Error Section ======-->
  <section class="error-area ptb-100 text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="not-found">
            <img src="{{ asset('assets/front/img/404.svg') }}" alt="404 Not Found">
          </div>
          <div class="error-txt">
            <h2>{{ __('404 not found') }}</h2>
            <p class="mx-auto">
              {{ __('The page you are looking for might have been moved, renamed, or might never existed.') }}</p>
            <a href="{{ route('index') }}" class="btn btn-lg btn-primary">{{ __('Back to Home') }}</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--====== End Error Section ======-->
@endsection
