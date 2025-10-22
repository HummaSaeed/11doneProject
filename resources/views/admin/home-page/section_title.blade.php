@extends('admin.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('admin.partials.rtl-style')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Images & Texts') }}</h4>
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
        <a href="#">{{ __('Home Page') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Images & Texts') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="ajaxForm"
          action="{{ route('admin.home_page.section_content_update', ['language' => request()->input('language')]) }}"
          method="post" enctype="multipart/form-data">
          @csrf
          <div class="card-header">
            <div class="row">
              <div class="col-lg-10">
                <div class="card-title">{{ __('Update Images & Texts') }}</div>
              </div>

              <div class="col-lg-2">
                @includeIf('admin.partials.languages')
              </div>
            </div>
          </div>

          <div class="card-body">
            <!-- hero section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Hero Section') }}</h2>
              <hr>
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="">{{ __('Image') . '*' }}</label>
                  <br>
                  <div class="thumb-preview">
                    @if (!empty($data->hero_section_background_img))
                      <img src="{{ asset('assets/img/hero/' . $data->hero_section_background_img) }}" alt="image"
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
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Hero Section Title') }}</label>
                    <input type="text" class="form-control" name="hero_section_title"
                      value="{{ empty($data->hero_section_title) ? '' : $data->hero_section_title }}"
                      placeholder="{{ __('Enter hero section title') }}">
                    @error('hero_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                @if ($settings->theme_version != 3)
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Hero Section Subtitle') }}</label>
                      <input type="text" class="form-control" name="hero_section_subtitle"
                        value="{{ empty($data->hero_section_subtitle) ? '' : $data->hero_section_subtitle }}"
                        placeholder="{{ __('Enter hero section subtitle') }}">
                      @error('hero_section_subtitle')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                @endif
              </div>
            </div>
            <!-- category section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Category Section') }}</h2>
              <hr>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Category Section Title') }}</label>
                    <input type="text" class="form-control" name="category_section_title"
                      value="{{ empty($data->category_section_title) ? '' : $data->category_section_title }}"
                      placeholder="{{ __('Enter category section title') }}">
                    @error('category_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <!-- work process section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Work Process Section') }}</h2>
              <hr>
              <div class="row">
                @if ($settings->theme_version == 1 || $settings->theme_version == 3)
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Work Process Background Image') . '*' }}</label>
                      <br>
                      <div class="thumb-preview">
                        @if (!empty($data->work_process_background_img))
                          <img src="{{ asset('assets/img/' . $data->work_process_background_img) }}" alt="image"
                            class="uploaded-img2">
                        @else
                          <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img2">
                        @endif
                      </div>

                      <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                          {{ __('Choose Image') }}
                          <input type="file" class="img-input2" name="work_process_background_img">
                        </div>
                      </div>
                      @error('work_process_background_img')
                        <p class="mt-2 mb-0 text-danger">{{ $message }}</p>
                      @enderror
                    </div>
                  </div>
                @endif
                @if ($settings->theme_version == 1)
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Button Icon') . '*' }}</label>
                      <div class="btn-group d-block">
                        <button type="button" class="btn btn-primary iconpicker-component">
                          <i
                            class="{{ empty($data->workprocess_icon) ? 'fa fa-fw fa-heart' : $data->workprocess_icon }}"></i>
                        </button>
                        <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                          data-selected="fa-car" data-toggle="dropdown"></button>
                        <div class="dropdown-menu"></div>
                      </div>

                      <input type="hidden" id="inputIcon" name="workprocess_icon">
                      <p id="err_icon" class="mt-2 mb-0 text-danger em"></p>
                      <div class="text-warning mt-2">
                        <small>{{ __('Click on the dropdown icon to select an icon.') }}</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Work Process Section Button Name') }}</label>
                      <input type="text" class="form-control" name="workprocess_section_btn"
                        value="{{ empty($data->workprocess_section_btn) ? '' : $data->workprocess_section_btn }}"
                        placeholder="{{ __('Enter work process section Button Name') }}">
                      @error('workprocess_section_btn')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Work Process Section Button Url') }}</label>
                      <input type="text" class="form-control" name="workprocess_section_url"
                        value="{{ empty($data->workprocess_section_url) ? '' : $data->workprocess_section_url }}"
                        placeholder="{{ __('Enter work process section Button Url') }}">
                      @error('workprocess_section_url')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                @endif
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Work Process Section Title') }}</label>
                    <input type="text" class="form-control" name="workprocess_section_title"
                      value="{{ empty($data->workprocess_section_title) ? '' : $data->workprocess_section_title }}"
                      placeholder="{{ __('Enter work process section title') }}">
                    @error('workprocess_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                @if ($settings->theme_version == 1)
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Work Process Section Subtitle') }}</label>
                      <input type="text" class="form-control" name="workprocess_section_subtitle"
                        value="{{ empty($data->workprocess_section_subtitle) ? '' : $data->workprocess_section_subtitle }}"
                        placeholder="{{ __('Enter work process section subtitle') }}">
                      @error('workprocess_section_subtitle')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                @endif
              </div>
            </div>
            <!-- featured service section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Featured Service Section') }}</h2>
              <hr>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Featured Service Section Title') }}</label>
                    <input type="text" class="form-control" name="featured_service_section_title"
                      value="{{ empty($data->featured_service_section_title) ? '' : $data->featured_service_section_title }}"
                      placeholder="{{ __('Enter featured service section title') }}">
                    @error('featured_service_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <!-- latest service section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Latest Service Section') }}</h2>
              <hr>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Latest Service Section Title') }}</label>
                    <input type="text" class="form-control" name="latest_service_section_title"
                      value="{{ empty($data->latest_service_section_title) ? '' : $data->latest_service_section_title }}"
                      placeholder="{{ __('Enter latest service section title') }}">
                    @error('latest_service_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <!-- call to action section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Call To Action Section') }}</h2>
              <hr>
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">{{ __('Background Image') }}</label>
                        <br>
                        <div class="thumb-preview">
                          @if (!empty($data->call_to_action_section_image))
                            <img src="{{ asset('assets/img/' . $data->call_to_action_section_image) }}" alt="image"
                              class="uploaded-img3">
                          @else
                            <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img3">
                          @endif
                        </div>

                        <div class="mt-3">
                          <div role="button" class="btn btn-primary btn-sm upload-btn">
                            {{ __('Choose Image') }}
                            <input type="file" class="img-input3" name="call_to_action_section_image">
                          </div>
                        </div>
                        @error('call_to_action_section_image')
                          <p class="mt-2 mb-0 text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    </div>
                    @if ($settings->theme_version == 1)
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">{{ __('Inner Image') }}</label>
                          <br>
                          <div class="thumb-preview">
                            @if (!empty($data->call_to_action_section_inner_image))
                              <img src="{{ asset('assets/img/' . $data->call_to_action_section_inner_image) }}"
                                alt="image" class="uploaded-img4">
                            @else
                              <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img4">
                            @endif
                          </div>

                          <div class="mt-3">
                            <div role="button" class="btn btn-primary btn-sm upload-btn">
                              {{ __('Choose Image') }}
                              <input type="file" class="img-input4" name="call_to_action_section_inner_image">
                            </div>
                          </div>
                          @error('call_to_action_section_inner_image')
                            <div class="text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>{{ __('Button Icon') . '*' }}</label>
                    <div class="btn-group d-block">
                      <button type="button" class="btn btn-primary iconpicker-component2">
                        <i
                          class="{{ empty($data->call_to_action_icon) ? 'fa fa-fw fa-heart' : $data->call_to_action_icon }}"></i>
                      </button>
                      <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle" data-selected="fa-car"
                        data-toggle="dropdown"></button>
                      <div class="dropdown-menu"></div>
                    </div>
                    <input type="hidden" id="inputIcon2" name="call_to_action_icon">
                    <p id="err_icon" class="mt-2 mb-0 text-danger em"></p>
                    <div class="text-warning mt-2">
                      <small>{{ __('Click on the dropdown icon to select an icon.') }}</small>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Call To Action Section Button Name') }}</label>
                    <input type="text" class="form-control" name="call_to_action_section_btn"
                      value="{{ empty($data->call_to_action_section_btn) ? '' : $data->call_to_action_section_btn }}"
                      placeholder="{{ __('Enter call to action section button name') }}">
                    @error('call_to_action_section_btn')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Call To Action Button Url') }}</label>
                    <input type="text" class="form-control" name="call_to_action_url"
                      value="{{ empty($data->call_to_action_url) ? '' : $data->call_to_action_url }}"
                      placeholder="{{ __('Enter call to action section button url') }}">
                    @error('call_to_action_url')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Call To Action Section Title') }}</label>
                    <input type="text" class="form-control" name="call_to_action_section_title"
                      value="{{ empty($data->call_to_action_section_title) ? '' : $data->call_to_action_section_title }}"
                      placeholder="{{ __('Enter call to action section title') }}">
                    @error('call_to_action_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="">{{ __('Call To Action Section Text') }}</label>
                    <textarea name="action_section_text" class="form-control" rows="1"
                      placeholder="{{ __('Enter call to action section text') }}">{{ empty($data->action_section_text) ? '' : $data->action_section_text }}</textarea>
                  </div>
                </div>
              </div>
            </div>
            <!-- vendor section -->
            <div class="col-lg-10 mx-auto">
              <h2 class="mt-3 text-warning">{{ __('Vendor Section') }}</h2>
              <hr>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">{{ __('Vendor Section Title') }}</label>
                    <input type="text" class="form-control" name="vendor_section_title"
                      value="{{ empty($data->vendor_section_title) ? '' : $data->vendor_section_title }}"
                      placeholder="{{ __('Enter vendor section title') }}">
                    @error('vendor_section_title')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
            <!-- testimonial section -->
            @if ($settings->theme_version != 3)
              <div class="col-lg-10 mx-auto">
                <h2 class="mt-3 text-warning">{{ __('Testimonial Section') }}</h2>
                <hr>
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">{{ __('Image') . '*' }}</label>
                      <br>
                      <div class="thumb-preview">
                        @if (@$data->testimonial_section_image != null)
                          <img src="{{ asset('assets/img/' . $data->testimonial_section_image) }}"
                            alt="..."class="uploaded-img5">
                        @else
                          <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img5">
                        @endif
                      </div>

                      <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                          {{ __('Choose Image') }}
                          <input type="file" class="img-input5" name="testimonial_section_image">
                        </div>
                      </div>
                      @error('testimonial_section_image')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror

                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Testimonial Section Title') }}</label>
                      <input type="text" class="form-control" name="testimonial_section_title"
                        value="{{ empty($data->testimonial_section_title) ? '' : $data->testimonial_section_title }}"
                        placeholder="{{ __('Enter testimonial section title') }}">
                      @error('testimonial_section_title')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Testimonial Section Subtitle') }}</label>
                      <input type="text" class="form-control" name="testimonial_section_subtitle"
                        value="{{ empty($data->testimonial_section_subtitle) ? '' : $data->testimonial_section_subtitle }}"
                        placeholder="{{ __('Enter testimonial section subtitle') }}">
                      @error('testimonial_section_subtitle')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">{{ __('Testimonial Section Clients') }}</label>
                      <input type="text" class="form-control" name="testimonial_section_clients"
                        value="{{ empty($data->testimonial_section_clients) ? '' : $data->testimonial_section_clients }}"
                        placeholder="{{ __('Enter testimonial section clients') }}">
                      @error('testimonial_section_clients')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="button" id="submitBtn" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
