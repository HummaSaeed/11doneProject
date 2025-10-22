@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Add Service') }}</h4>
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
        <a href="#">{{ __('Services Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.service_managment', ['language' => $defaultLang->code]) }}">{{ __('Services') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Add Service') }}</a>
      </li>
    </ul>
  </div>
  @if (request()->vendor_id == 'admin')
    @php
      $vendor_id = 0;
    @endphp
  @else
    @php
      $vendor_id = request()->vendor_id;
    @endphp
  @endif
  @php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);
  @endphp
  <div class="row">
    <div class="col-md-12">
      @if ($vendor_id != 0)
        @if ($current_package != '[]')
          @php
            $sliderImage = $current_package->number_of_service_image;
          @endphp
          @if (vendorTotalAddedService($vendor_id) >= $current_package->number_of_service_add)
            <div class="alert alert-danger">
              {{ __("You can't add more service for this vendor.") }}
            </div>
            @php
              $can_service_add = 2;
            @endphp
          @else
            @php
              $can_service_add = 1;
            @endphp
          @endif
        @else
          @php
            $pendingMemb = \App\Models\Membership::query()
                ->where([['vendor_id', '=', $vendor_id], ['status', 0]])
                ->whereYear('start_date', '<>', '9999')
                ->orderBy('id', 'DESC')
                ->first();
            $pendingPackage = isset($pendingMemb)
                ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id)
                : null;
          @endphp
          @if ($pendingPackage)
            <div class="alert alert-warning text-dark">
              {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
            </div>
            <div class="alert alert-warning text-dark">
              <strong>{{ __('Pending Package') . ':' }} </strong> {{ $pendingPackage->title }}
              <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
              <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
            </div>
          @else
            <div class="alert alert-warning text-dark">
              {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
            </div>
          @endif
          @php
            $can_service_add = 0;
          @endphp
        @endif
      @else
        @php
          $can_service_add = 'admin';
          $sliderImage = 99999;
        @endphp
      @endif
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Add Service') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('admin.service_managment', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              @php
                $iconSize = '12px';
              @endphp
              <i class="fas fa-backward" style="font-size: {{ $iconSize }};"></i>
            </span>
            {{ __('Back') }}
          </a>
        </div>

        <div class="card-body pt-5 pb-5">

          <div class="alert alert-danger pb-1 dis-none" id="service_erros">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul></ul>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <label for="" class="mb-2"><strong>{{ __('Gallery Images') }} *</strong></label>
              <form action="{{ route('admin.service.imagesstore') }}" id="my-dropzone" enctype="multipart/formdata"
                class="dropzone create">
                @csrf
                <div class="fallback">
                  <input name="file" type="file" multiple />
                </div>
              </form>
              <p class="em text-danger mb-0" id="errslider_images"></p>
            </div>
            <div class="col-lg-12">
              <form id="serviceForm" action="{{ route('admin.service_managment.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div id="sliders"></div>
                <input type="hidden" name="vendor_id" value="{{ $vendor_id }}">
                <div class="version border-0">
                  <div class="version-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">{{ __('Featured Image') . '*' }}</label>
                          <br>
                          <div class="thumb-preview">
                            <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                          </div>

                          <div class="mt-3">
                            <div role="button" class="btn btn-primary btn-sm upload-btn">
                              {{ __('Choose Image') }}
                              <input type="file" class="img-input" name="service_image">
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    @php $currencyText = $currencyInfo->base_currency_text; @endphp
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Price') . '* (' . $currencyText . ')' }}</label>
                          <input type="number" class="form-control" name="price" value="{{ old('price') }}"
                            placeholder="{{ __('Enter Price') }}">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Previous Price') . ' (' . $currencyText . ')' }}</label>
                          <input type="number" class="form-control" name="prev_price" value="{{ old('price') }}"
                            placeholder="{{ __('Enter Price') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Status') . '*' }}</label>
                          <select name="status" class="form-control">
                            <option selected="" disabled="">{{ __('Select a Status') }}</option>
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Deactive') }}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Person') }}</label>
                          <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                              <input type="radio" name="person_type" value="1" class="selectgroup-input"
                                checked="">
                              <span class="selectgroup-button">{{ __('Single') }}</span>
                            </label>

                            <label class="selectgroup-item">
                              <input type="radio" name="person_type" value="0" class="selectgroup-input">
                              <span class="selectgroup-button">{{ __('Group') }}</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4 groupPersons">
                        <div class="form-group">
                          <label>{{ __('Max Person') . '*' }}</label>
                          <input type="number" class="form-control personInput" name="person"
                            placeholder="{{ __('Enter person number') }}">
                        </div>
                      </div>

                      @if ($vendor_id != 0)
                        @if ($current_package != '[]')
                          @if ($current_package->zoom_meeting_status == 1)
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>{{ __('Zoom') }}</label>
                                <div class="selectgroup w-100">
                                  <label class="selectgroup-item">
                                    <input type="radio" name="zoom_meeting" value="1"
                                      class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Enable') }}</span>
                                  </label>

                                  <label class="selectgroup-item">
                                    <input type="radio" name="zoom_meeting" value="0" class="selectgroup-input"
                                      checked="">
                                    <span class="selectgroup-button">{{ __('Disable') }}</span>
                                  </label>
                                </div>
                                <p class=" m-0 mb-0">
                                  <small class="text-warning">
                                    {{ __('If you enable zoom, then you have to set your zoom credentials.') }}
                                  </small>
                                  <a target="_blank" class="link-primary "
                                    href="{{ route('admin.basic_settings.plugins') }}">
                                    {{ __('Click to proceed') }}
                                  </a>
                                </p>
                              </div>
                            </div>
                          @endif
                        @endif
                      @else
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>{{ __('Zoom') }}</label>
                            <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                                <input type="radio" name="zoom_meeting" value="1" class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('Enable') }}</span>
                              </label>

                              <label class="selectgroup-item">
                                <input type="radio" name="zoom_meeting" value="0" class="selectgroup-input"
                                  checked="">
                                <span class="selectgroup-button">{{ __('Disable') }}</span>
                              </label>
                            </div>
                            <p class=" m-0 mb-0">
                              <small class="text-warning">
                                {{ __('If you enable zoom, then you have to set your zoom credentials.') }}
                              </small>
                              <a target="_blank" class="link-primary "
                                href="{{ route('admin.basic_settings.plugins') }}">
                                {{ __('Click to proceed') }}
                              </a>
                            </p>
                          </div>
                        </div>
                      @endif

                      @if ($vendor_id != 0)
                        @if ($current_package != '[]')
                          @if ($current_package->calendar_status == 1)
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>{{ __('Google Calendar') }}</label>
                                <div class="selectgroup w-100">
                                  <label class="selectgroup-item">
                                    <input type="radio" name="calender_status" value="1"
                                      class="selectgroup-input">
                                    <span class="selectgroup-button">{{ __('Enable') }}</span>
                                  </label>

                                  <label class="selectgroup-item">
                                    <input type="radio" name="calender_status" value="0"
                                      class="selectgroup-input" checked="">
                                    <span class="selectgroup-button">{{ __('Disable') }}</span>
                                  </label>
                                </div>
                                <p>
                                  <small class="text-warning">
                                    {{ __('If you enable calendar, then you have to set your calendar credentials') }}
                                  </small>
                                  <a target="_blank" class="link-primary "
                                    href="{{ route('admin.basic_settings.plugins') }}">{{ __('Click to proceed') }}
                                  </a>
                                </p>
                              </div>
                            </div>
                          @endif
                        @endif
                      @else
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>{{ __('Google Calendar') }}</label>
                            <div class="selectgroup w-100">
                              <label class="selectgroup-item">
                                <input type="radio" name="calender_status" value="1" class="selectgroup-input">
                                <span class="selectgroup-button">{{ __('Enable') }}</span>
                              </label>

                              <label class="selectgroup-item">
                                <input type="radio" name="calender_status" value="0" class="selectgroup-input"
                                  checked="">
                                <span class="selectgroup-button">{{ __('Disable') }}</span>
                              </label>
                            </div>
                            <p>
                              <small class="text-warning">
                                {{ __('If you enable calendar, then you have to set your calendar credentials') }}
                              </small>
                              <a target="_blank" class="link-primary "
                                href="{{ route('admin.basic_settings.plugins') }}">{{ __('Click to proceed') }}
                              </a>
                            </p>
                          </div>
                        </div>
                      @endif

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Latitude') }}</label>
                          <input type="number" class="form-control" name="latitude"
                            placeholder="{{ __('Enter Latitude') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Longitude') }}</label>
                          <input type="number" class="form-control" name="longitude"
                            placeholder="{{ __('Enter Longitude') }}">
                        </div>
                      </div>


                    </div>
                  </div>

                  <div id="accordion" class="mt-5">
                    @foreach ($languages as $language)
                      <div class="version">
                        <div class="version-header" id="heading{{ $language->id }}">
                          <h5 class="mb-0">
                            <button type="button"
                              class="btn btn-link {{ $language->direction == 1 ? 'rtl text-right' : '' }}"
                              data-toggle="collapse" data-target="#collapse{{ $language->id }}"
                              aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                              aria-controls="collapse{{ $language->id }}">
                              {{ $language->name . __(' Language') }}
                              {{ $language->is_default == 1 ? '(Default)' : '' }}
                            </button>
                          </h5>
                        </div>

                        <div id="collapse{{ $language->id }}"
                          class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                          aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                          <div class="version-body {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                            <div class="row">
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label>{{ __('Title') . '*' }}</label>
                                  <input type="text" class="form-control"
                                    value="{{ old($language->code . '_name') }}" name="{{ $language->code }}_name"
                                    placeholder="{{ __('Enter Service Title') }}">
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label>{{ __('Address') }}</label>
                                  <input type="text" class="form-control"
                                    value="{{ old($language->code . '_address') }}"
                                    name="{{ $language->code }}_address" placeholder="{{ __('Enter Address') }}">
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                 <label>{{ __('Postcode') }}</label>
                                 <input type="text" class="form-control" value="{{ old($language->code . '_postcode') }}"
            name="{{ $language->code }}_postcode" placeholder="{{ __('Enter Post Code') }}">
    </div>
</div>
                              <div class="col-lg-4">
                                @php
                                  $categories = App\Models\Services\ServiceCategory::where('language_id', $language->id)
                                      ->where('status', 1)
                                      ->get();
                                @endphp
                                <div class="form-group">
                                  <label for="">{{ __('Category') . '*' }}</label>
                                  <select id="category" name="{{ $language->code }}_category_id"
                                    class="form-control select2">
                                    <option selected disabled>{{ __('Select a category') }}</option>
                                    @foreach ($categories as $category)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                  <label>{{ __('Features') }} </label>
                                  <textarea name="{{ $language->code }}_features" class="form-control"
                                    placeholder="{{ __('Enter Service Features') }}"></textarea>
                                  <p class="text-warning">
                                    {{ __('Each new line will be shown as a new feature in this service') }}</p>
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                  <label>{{ __('Description') . '*' }} </label>
                                  <textarea id="{{ $language->code }}_description" class="form-control summernote"
                                    name="{{ $language->code }}_description" data-height="300"></textarea>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                  <label>{{ __('Meta Keywords') }} </label>
                                  <input class="form-control" name="{{ $language->code }}_meta_keyword"
                                    placeholder="{{ __('Enter Meta Keywords') }}" data-role="tagsinput">
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                  <label>{{ __('Meta Description') }} </label>
                                  <textarea class="form-control" name="{{ $language->code }}_meta_description" rows="5"
                                    placeholder="{{ __('Enter Meta Description') }}"></textarea>
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

                </div>
              </form>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" id="ServiceSubmit" class="btn btn-success"
                  data-can_service_add="{{ $can_service_add }}">
                  {{ __('Save') }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script>
    'use strict';
    var storeUrl = "{{ route('admin.service.imagesstore') }}";
    var removeUrl = "{{ route('admin.service.imagermv') }}";
    var sliderDelete = "{{ route('admin.service.slider.delete') }}";
    let galleryImages = "{{ $sliderImage }}";
  </script>
  <script src="{{ asset('assets/js/vendor-dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/services.js') }}"></script>
@endsection
