@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@php
  $title = strlen($details->title) > 40 ? mb_substr($details->title, 0, 40, 'UTF-8') . '...' : $details->title;
@endphp
@section('pageHeading')
  @if (!empty($title))
    {{ $title ? $title : $pageHeading->blog_page_title }}
  @endif
@endsection

@section('metaKeywords')
  {{ $details->meta_keywords }}
@endsection

@section('metaDescription')
  {{ $details->meta_description }}
@endsection

@section('content')
  <!-- Page title start-->
  <div
    class="page-title-area bg-img bg-cover {{ $basicInfo->theme_version == 2 || $basicInfo->theme_version == 3 ? 'has_header_2' : '' }}"
    @if (!empty($bgImg->breadcrumb)) data-bg-image="{{ asset('assets/img/' . $bgImg->breadcrumb) }}" @endif>
    <div class="container">
      <div class="content">
        <h2>{{ !empty($title) ? $title : '' }}</h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">
              {{ !empty($pageHeading) ? $pageHeading->blog_page_title : __('Blog') }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- Page title end-->

  <div class="blog-details-area pt-100 pb-60">
    <div class="container">
      <div class="row justify-content-center gx-xl-5">
        <div class="col-lg-8">
          <div class="blog-description mb-40">
            <article class="item-single">
              <div class="image radius-md">
                <div class="lazy-container ratio ratio-16-9">
                  <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                    data-src="{{ asset('assets/img/blogs/' . $details->image) }}" alt="Blog Image">
                </div>
                <a href="javaScript:void(0)" class="btn btn-md btn-primary btn-gradient icon-start" data-bs-toggle="modal"
                  data-bs-target="#socialMediaModal"><i class="fas fa-share-alt"></i>{{ __('Share Now') }}</a>
              </div>
              <div class="content">
                <ul class="info-list">
                  <li><i class="fal fa-user"></i>{{ $details->author }}</li>
                  <li><i class="fal fa-calendar"></i> {{ \Carbon\Carbon::parse($details->created_at)->format('F d, Y') }}
                  </li>

                  <li><i class="fal fa-tag"></i>
                    <a href="{{ route('blog', ['category' => $details->categorySlug]) }}">
                      {{ $details->categoryName }}
                    </a>
                  </li>
                </ul>
                <h4 class="title">
                  {{ $title }}
                </h4>
                <p class="m-0">{!! replaceBaseUrl($details->content, 'summernote') !!}</p>
              </div>
            </article>
          </div>
          <div class="comments">
            <h4 class="mb-20">{{ __('Comments') }}</h4>
            @if ($disqusInfo->disqus_status == 1)
              <div id="disqus_thread"></div>
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <aside class="widget-area mb-10">
            <div class="widget widget-search mb-30 p-30 border radius-md">
              <h4 class="title mb-15">{{ __('Search Posts') }}</h4>
              <form class="search-form radius-md" action="{{ route('blog') }}" method="GET">
                <input type="search" class="search-input" placeholder="{{ __('Search By Title') }}" name="title"
                  value="{{ !empty(request()->input('title')) ? request()->input('title') : '' }}">
                @if (!empty(request()->input('category')))
                  <input type="hidden" name="category" value="{{ request()->input('category') }}">
                @endif
                <button class="btn-search" type="submit">
                  <i class="far fa-search"></i>
                </button>
              </form>
            </div>
            <div class="widget widget-blog-categories mb-30 p-30 border radius-md">
              <h4 class="title mb-15">{{ __('Categories') }}</h4>
              <ul class="list-unstyled m-0">
                @foreach ($categories as $category)
                  <li class="d-flex align-items-center justify-content-between">
                    <a href="{{ route('blog', ['category' => $category->slug]) }}" target="_self" title="Blogs"><i
                        class="fal fa-folder"></i>{{ $category->name }}</a>
                    <span class="tqy">({{ $category->blogCount }})</span>
                  </li>
                @endforeach
              </ul>
            </div>
            <div class="widget widget-post mb-30 p-30 border radius-md">
              <h4 class="title mb-15">{{ __('Recent Posts') }}</h4>
              @foreach ($recent_blogs as $blog)
                <article class="article-item mb-30">
                  <div class="image">
                    <a href="blog-details.html" class="lazy-container ratio ratio-5-4" target="_self" title="Blog">
                      <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                        data-src="{{ asset('assets/img/blogs/' . $blog->image) }}" alt="Blog Image">
                    </a>
                  </div>
                  <div class="content">
                    <h6 class="lc-2">
                      <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}" target="_self" title="Blog">
                        {{ strlen($blog->title) > 40 ? mb_substr($blog->title, 0, 40, 'UTF-8') . '...' : $blog->title }}</a>
                    </h6>
                    <ul class="info-list">
                      <li><i class="fal fa-user"></i>{{ __('Admin') }}</li>
                      <li><i class="fal fa-calendar"></i>{{ date_format($details->created_at, 'M d, Y') }}</li>
                    </ul>
                  </div>
                </article>
              @endforeach
            </div>
            @if (!empty(showAd(1)))
              <div class="text-center mb-40">
                {!! showAd(1) !!}
              </div>
            @endif
            @if (!empty(showAd(2)))
              <div class="text-center mb-40">
                {!! showAd(2) !!}
              </div>
            @endif
          </aside>
        </div>
      </div>
    </div>
  </div>
  @php
      $display = 'none';
  @endphp
  <div class="modal social-media-modal fade" id="socialMediaModal" tabindex="-1" aria-labelledby="socialMediaModalTitle"
    style="display: {{ $display }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Share on') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="actions">
            <div class="action-btn">
              <a href="//www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="facebook"
                target="_blank">
                <i class="fab fa-facebook-f"></i>{{ __('Facebook') }}
              </a>
            </div>
            <div class="action-btn">
              <a href="//twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"
                class="twitter" target="_blank">
                <i class="fab fa-twitter"></i>{{ __('Tweet') }}
              </a>
            </div>

            <div class="action-btn">
              <a href="//www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}&amp;title={{ $details->title }}"
                class="linkedin" target="_blank">
                <i class="fab fa-linkedin-in"></i>{{ __('Linkedin') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  @if ($disqusInfo->disqus_status == 1)
    <script>
      'use strict';
      const shortName = '{{ $disqusInfo->disqus_short_name }}';
      const slug = '{{ $details->blogSlug }}';
      const blogId = '{{ $details->id }}';
    </script>
    <!-- disqus plugin -->
    <script id="dsq-count-scr" src="//bookapp.disqus.com/count.js" async></script>
    <script src="{{ asset('assets/frontend/js/disqus.js') }}"></script>
  @endif
@endsection
