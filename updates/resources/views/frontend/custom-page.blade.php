@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@section('pageHeading')
  {{ $title }}
@endsection

@section('metaKeywords')
  {{ $meta_keywords }}
@endsection

@section('metaDescription')
  {{ $meta_description }}
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => $title,
  ])

  <!--====== Start FAQ Section ======-->
  <section class="blog-area blog-1 ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="tinymce-content">
            {!! $pageInfo->content !!}
          </div>
        </div>
        @if (!empty(showAd(3)))
          <div class="text-center mt-5">
            {!! showAd(3) !!}
          </div>
        @endif
      </div>
    </div>
  </section>

  <!--====== End FAQ Section ======-->
@endsection
