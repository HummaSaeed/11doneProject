@php
  $version = $basicInfo->theme_version;
@endphp
@extends('frontend.layout')

@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->blog_page_title }}
  @else
    {{ __('Posts') }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_blog }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_blog }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->blog_page_title : __('Blog'),
  ])

  <!-- Blog-area start -->
  <section class="blog-area ptb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          @if(count($blogs) > 0)
          <div class="row">
            @foreach ($blogs as $blog)
              <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <article class="card mb-25 shadow-md radius-md">
                  <div class="card-img">
                    <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}" target="_self"
                      title="{{ @$blog->title }}" class="lazy-container ratio ratio-5-3">
                      <img class="lazyload" src="{{ asset('assets/frontend/images/placeholder.png') }}"
                        data-src="{{ asset('assets/img/blogs/' . $blog->image) }}" alt="Blog Image">
                    </a>
                  </div>
                  <div class="card-content p-25">
                      <ul class="card-list list-unstyled d-flex justify-content-between">
                      <li class="mb-10 font-sm icon-start"><i class="fal fa-user-circle"></i>{{ @$blog->author }}
                      </li>
                      <li class="mb-10 font-sm icon-start">
                        <a href="{{ route('blog', ['category' => $blog->categorySlug]) }}" target="_self"
                          title="{{ @$blog->categoryName }}"><i class="fal fa-tag"></i>{{ @$blog->categoryName }}</a>
                      </li>
                      <li class="mb-10 font-sm icon-start"><i class="fal fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}
                      </li>
                    </ul>
                    <h4 class="card-title lc-2 mb-15">
                      <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}" target="_self"
                        title="{{ @$blog->title }}">
                        {{ @$blog->title }}
                      </a>
                    </h4>
                    <a href="{{ route('blog_details', ['slug' => $blog->slug]) }}"
                      class="btn-text icon-end color-primary" target="_self"
                      title="{{ __('Read More') }}">{{ __('CONTINUE READING') }}<i
                        class="fal fa-long-arrow-right"></i></a>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
          @else
          <h4 class="text-center">{{ __('NO BLOG FOUND') }}!</h4>
          @endif
          <nav class="pagination-nav mt-10" data-aos="fade-up">
            {{ $blogs->links() }}
          </nav>
        </div>
        <div class="col-lg-3">
          <aside class="widget-area position-static pb-10" data-aos="fade-up">
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
          </aside>
        </div>
      </div>
      @if (!empty(showAd(3)))
        <div class="text-center mt-4">
          {!! showAd(3) !!}
        </div>
      @endif
    </div>
  </section>
  <!-- Blog-area end -->
@endsection
