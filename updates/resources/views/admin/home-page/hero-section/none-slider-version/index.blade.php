@extends('admin.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('admin.partials.rtl-style')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Hero Section') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Pages') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Home Page') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Hero Section') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    @if ($settings->theme_version != 3)
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-12">
                <div class="card-title">{{ __('Update Hero Section Image') }}</div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="col-lg-12">
              <form id="actionImgForm" action="{{ route('admin.home_page.hero_section.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="form-group">
                    <label for="">{{ __('Image') . '*' }}</label>
                    <br>
                    <div class="thumb-preview">
                      @if (!empty($info->hero_section_background_img))
                        <img src="{{ asset('assets/img/hero/' . $info->hero_section_background_img) }}" alt="image"
                          class="uploaded-img">
                      @else
                        <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                      @endif
                    </div>
                    <div class="mt-3">
                      <div role="button" class="btn btn-primary btn-sm upload-btn">
                        {{ __('Choose Image') }}
                        <input type="file" class="img-input" name="hero_section_background_img">
                      </div>
                    </div>
                    @error('hero_section_background_img')
                      <p class="mt-2 mb-0 text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card-footer">
            <div class="col-12 text-center">
              <button type="submit" form="actionImgForm" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    @endif
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-8">
              <div class="card-title">{{ __('Update Hero Section') }}</div>
            </div>
            <div class="col-lg-4">
              @includeIf('admin.partials.languages')
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="actionForm"
                action="{{ route('admin.home_page.hero_section.update', ['language' => request()->input('language')]) }}"
                method="POST">
                @csrf
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="">{{ __('Title') }}</label>
                    <input type="text" class="form-control" name="title"
                      value="{{ empty($data->title) ? '' : $data->title }}" placeholder="{{ __('Enter Title') }}">
                    @error('title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                @if ($settings->theme_version != 3)
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">{{ __('Text') }}</label>
                      <textarea name="text" class="form-control" rows="1" placeholder="{{ __('Enter Text') }}">{{ empty($data->text) ? '' : $data->text }}</textarea>
                    </div>
                  </div>
                @endif
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" form="actionForm" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
