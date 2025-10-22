@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Add Section') }}</h4>
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
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Additional Sections') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Add Section') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Add Section') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('admin.home.additional_sections', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            {{ __('Back') }}
          </a>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <div class="alert alert-danger pb-1 dis-none" id="pageErrors">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul></ul>
              </div>

              <form id="pageForm" action="{{ route('admin.home.additional_section.store') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group p-0">
                      <label for="">{{ __('Position') }}*</label>
                      <select name="order" class="form-control select2">
                        <option selected disabled>{{ __('Select a Section') }}</option>

                        <option value="hero_section">
                          {{ __('After Hero Section') }}
                        </option>
                        <option value="category_section">
                          {{ __('After Category Section') }}
                        </option>
                        <option value="work_process_section">
                          {{ __('After Work Process Section') }}
                        </option>
                        <option value="featured_service_section">
                          {{ __('After Featured Service Section') }}
                        </option>
                        <option value="testimonial_section">
                          {{ __('After Testimonial Section') }}
                        </option>
                        <option value="call_to_action_section">
                          {{ __('After Call to Action Section') }}
                        </option>
                        <option value="vendor_section">
                          {{ __('After Vendor Section') }}
                        </option>
                        <option value="latest_service_section">
                          {{ __('After Latest Service Section') }}
                        </option>
                        <option value="footer_section">
                          {{ __('After Footer Section') }}
                        </option>
                        @if ($themeVersion != 1)
                          <option value="banner_section">
                            {{ __('After Banner Section') }}
                          </option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group p-0">
                      <label for="">{{ __('Order Number') }}*</label>
                      <input type="number" name="serial_number" class="form-control">
                    </div>
                    <p class="text-warning">
                      {{ __(' The higher the order number is, the later the section will be shown. ') }}</p>
                  </div>
                </div>

                <input type="hidden" name="page_type" value="home">

                <div id="accordion" class="mt-3">
                  @foreach ($languages as $language)
                    <div class="version">
                      <div class="version-header" id="heading{{ $language->id }}">
                        <h5 class="mb-0">
                          <button type="button"
                            class="btn btn-link {{ $language->direction == 1 ? 'rtl text-right' : '' }}"
                            data-toggle="collapse" data-target="#collapse{{ $language->id }}"
                            aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $language->id }}">
                            {{ $language->name . __(' Language') }} {{ $language->is_default == 1 ? '(Default)' : '' }}
                          </button>
                        </h5>
                      </div>

                      <div id="collapse{{ $language->id }}"
                        class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                        <div class="version-body">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Name') }}*</label>
                                <input type="text" class="form-control" name="{{ $language->code }}_name"
                                  placeholder="{{ __('Enter section name') }}">
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                <label>{{ __('Content') }}*</label>
                                <textarea class="form-control summernote" name="{{ $language->code }}_content" id="content-{{ $language->id }}"
                                  data-height="300"></textarea>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              @php $currLang = $language; @endphp

                              @foreach ($languages as $language)
                                @continue($language->id == $currLang->id)

                                <div class="form-check py-0">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"
                                      onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $language->id }}', event)">
                                    <span class="form-check-sign">{{ __('Clone for') }} <strong
                                        class="text-capitalize text-secondary">{{ $language->name }}</strong>
                                      {{ __('language') }}</span>
                                  </label>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" form="pageForm" class="btn btn-success">
                {{ __('Save') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js') }}"></script>
@endsection
