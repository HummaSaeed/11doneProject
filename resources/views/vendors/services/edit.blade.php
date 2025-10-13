@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Edit Service') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('vendor.dashboard') }}">
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
        <a href="{{ route('vendor.service_managment', ['language' => $defaultLang->code]) }}">{{ __('Services') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        @php
          $content = $service->content->where('language_id', $defaultLang->id)->first();
        @endphp
        <a href="#">
          @if ($content)
            {{ strlen($content->name) > 50 ? mb_substr($content->name, 0, 50, 'utf-8') . '...' : $content->name }}
          @else
            {{ '-' }}
          @endif
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Edit Service') }}</a>
      </li>
    </ul>
  </div>

  @php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
  @endphp
  @if ($current_package != '[]')
    @php
      $serviceImage = vendorTotalSliderImage($service->id);
      $pack_image = $current_package->number_of_service_image;
      $sliderImage = $pack_image - $serviceImage;
    @endphp
  @else
    @php
      $sliderImage = 0;
    @endphp
  @endif
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <div class="card-title d-inline-block">{{ __('Edit Service') }}</div>
            </div>
            <div class="col-md-6 mt-2 mt-md-0">
              <div class="btn-groups justify-content-md-end gap-10">
                <a class="btn btn-info btn-sm float-right d-inline-block"
                  href="{{ route('vendor.service_managment', ['language' => $defaultLang->code]) }}">
                  <span class="btn-label">
                    @php
                      $fontSize = '12px';
                    @endphp
                    <i class="fas fa-backward" style="font-size: {{ $fontSize }}"></i>
                  </span>
                  {{ __('Back') }}
                </a>
                @php
                  $dContent = App\Models\Services\ServiceContent::where('service_id', $service->id)
                      ->where('language_id', $defaultLang->id)
                      ->first();
                  $slug = !empty($dContent) ? $dContent->slug : '';
                @endphp
                @if ($dContent)
                  <a class="btn btn-success btn-sm d-inline-block"
                    href="{{ route('frontend.service.details', ['slug' => $slug, 'id' => $service->id]) }}"
                    target="_blank">
                    <span class="btn-label">
                      <i class="fas fa-eye"></i>
                    </span>
                    {{ __('Preview') }}
                  </a>
                @endif
              </div>
            </div>
          </div>
        </div>

        <div class="card-body pt-5 pb-5">

          <div class="alert alert-danger pb-1 dis-none" id="service_erros">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul></ul>
          </div>
          <div class="col-lg-12">
            <label for="" class="mb-2"><strong>{{ __('Gallery Images') . '*' }}</strong></label>
            <div class="row">
              <div class="col-12">
                <table class="table table-striped" id="imgtable">
                  @foreach ($service->sliderImage as $item)
                    <tr class="trdb table-row" id="trdb{{ $item->id }}">
                      <td>
                        <div class="">
                          <img class="thumb-preview wf-150"
                            src="{{ asset('assets/img/services/service-gallery/' . $item->image) }}" alt="Ad Image">
                        </div>
                      </td>
                      <td>
                        <i class="fa fa-times rmvbtndb" data-indb="{{ $item->id }}"></i>
                      </td>
                    </tr>
                  @endforeach
                </table>
              </div>
            </div>
            <form action="{{ route('vendor.service.imagesstore') }}" id="my-dropzone" enctype="multipart/formdata"
              class="dropzone create">
              @csrf
              <div class="fallback">
                <input name="file" type="file" multiple />
              </div>
            </form>
            <p class="text-warning mt-2 mb-0">
              <small>{{ __('Please note that you can upload a maximum of') }} {{ $sliderImage }}
                {{ __('images') }}.</small>
            </p>
            <p class="em text-danger mb-0" id="errslider_images"></p>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <form id="serviceForm" action="{{ route('vendor.service_managment.update', ['id' => $service->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div id="sliders"></div>
                <input type="hidden" name="service_id" value="{{ $service->id }}">
                <input type="hidden" name="vendor_id" value="{{ Auth::guard('vendor')->user()->id }}">
                <div class="version border-0">
                  <div class="version-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">{{ __('Featured Image') . '*' }}</label>
                          <br>
                          <div class="thumb-preview">
                            <img src="{{ asset('assets/img/services/' . $service->service_image) }}" alt="..."
                              class="uploaded-img">
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
                          <input type="number" class="form-control" name="price" value="{{ $service->price }}"
                            placeholder="{{ __('Enter Price') }}">
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Previous Price') . ' (' . $currencyText . ')' }}</label>
                          <input type="number" class="form-control" name="prev_price"
                            value="{{ $service->prev_price ? $service->prev_price : '' }}"
                            placeholder="{{ __('Enter Price') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Status') . '*' }}</label>
                          <select name="status" class="form-control">
                            <option selected="" disabled="">{{ __('Select a Status') }}</option>
                            <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                            </option>
                            <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>{{ __('Deactive') }}
                            </option>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Person') . '*' }}</label>
                          <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                              <input type="radio" name="person_type" value="1" class="selectgroup-input"
                                {{ $service->max_person == null ? 'checked' : '' }}>
                              <span class="selectgroup-button">{{ __('Single') }}</span>
                            </label>

                            <label class="selectgroup-item">
                              <input type="radio" name="person_type" value="0" class="selectgroup-input"
                                {{ $service->max_person > 1 ? 'checked' : '' }}>
                              <span class="selectgroup-button">{{ __('Group') }}</span>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4 groupPersons">
                        <div class="form-group">
                          <label>{{ __('Max Person') . '*' }}</label>
                          <input type="number" class="form-control personInput" name="person"
                            placeholder="{{ __('Enter person number') }}"
                            value="{{ $service->max_person > 1 ? $service->max_person : '' }}">
                        </div>
                      </div>
                      @if ($current_package != '[]')
                        @if ($current_package->zoom_meeting_status == 1)
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>{{ __('Zoom') }}</label>
                              <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                  <input type="radio" name="zoom_meeting"
                                    {{ $service->zoom_meeting == 1 ? 'checked' : '' }} value="1"
                                    class="selectgroup-input">
                                  <span class="selectgroup-button">{{ __('Enable') }}</span>
                                </label>

                                <label class="selectgroup-item">
                                  <input type="radio" name="zoom_meeting" value="0" class="selectgroup-input"
                                    {{ $service->zoom_meeting == 0 ? 'checked' : '' }}>
                                  <span class="selectgroup-button">{{ __('Disable') }}</span>
                                </label>
                              </div>
                              <p class=" m-0 mb-0">
                                <small class="text-warning">
                                  {{ __('If you enable zoom, then you have to set your zoom credentials.') }}
                                </small>
                                <a target="_blank" class="link-primary "
                                  href="{{ route('vendor.plugins.index') }}">{{ __('Click to proceed') }}
                                </a>

                              </p>
                            </div>
                          </div>
                        @endif
                        @if ($current_package->calendar_status == 1)
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>{{ __('Google Calendar') }}</label>
                              <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                  <input type="radio" name="calender_status"
                                    {{ $service->calendar_status == 1 ? 'checked' : '' }} value="1"
                                    class="selectgroup-input">
                                  <span class="selectgroup-button">{{ __('Enable') }}</span>
                                </label>

                                <label class="selectgroup-item">
                                  <input type="radio" name="calender_status" value="0"
                                    class="selectgroup-input" {{ $service->calendar_status == 0 ? 'checked' : '' }}>
                                  <span class="selectgroup-button">{{ __('Disable') }}</span>
                                </label>
                              </div>
                              <p class=" m-0 mb-0">
                                <small class="text-warning">
                                  {{ 'If you enable calendar, then you have to set your calendar credentials' }}
                                </small>
                                <a target="_blank" class="link-primary " href="{{ route('vendor.plugins.index') }}">
                                  {{ __(' Click to proceed') }}
                                </a>
                              </p>
                            </div>
                          </div>
                        @endif
                      @endif

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Latitude') }}</label>
                          <input type="number" class="form-control" name="latitude"
                            placeholder="{{ __('Enter Latitude') }}" value="{{ $service->latitude }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Longitude') }}</label>
                          <input type="number" class="form-control" name="longitude"
                            placeholder="{{ __('Enter Longitude') }}" value="{{ $service->longitude }}">
                        </div>
                      </div>

                    </div>
                  </div>

                  <div id="accordion" class="mt-5">
                    @foreach ($languages as $language)
                      @php
                        $serviceContent = App\Models\Services\ServiceContent::where('service_id', $service->id)
                            ->where('language_id', $language->id)
                            ->first();
                      @endphp
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
                                  <input type="text" class="form-control" value="{{ @$serviceContent->name }}"
                                    name="{{ $language->code }}_name" placeholder="{{ __('Enter Service Title') }}">
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label>{{ __('Address') }}</label>
                                  <input type="text" class="form-control" value="{{ @$serviceContent->address }}"
                                    name="{{ $language->code }}_address" placeholder="{{ __('Enter Address') }}">
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
                                      <option {{ $category->id == @$serviceContent->category_id ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>{{ __('Features') }} </label>
                                  <textarea name="{{ $language->code }}_features" class="form-control">{{ $serviceContent ? $serviceContent->features : '' }}</textarea>
                                  <p class="text-warning">
                                    {{ __('Each new line will be shown as a new feature in this service') }}</p>
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>{{ __('Description') }} *</label>
                                  <textarea id="{{ $language->code }}_description" class="form-control summernote"
                                    name="{{ $language->code }}_description" data-height="300">{{ @$serviceContent->description }}</textarea>
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>{{ __('Meta Keywords') }}</label>
                                  <input class="form-control" name="{{ $language->code }}_meta_keyword"
                                    placeholder="{{ __('Enter Meta Keywords') }}" data-role="tagsinput"
                                    value="{{ @$serviceContent->meta_keyword }}">
                                </div>
                              </div>
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>{{ __('Meta Description') }}</label>
                                  <textarea class="form-control" name="{{ $language->code }}_meta_description" rows="5"
                                    placeholder="{{ __('Enter Meta Description') }}">{!! @$serviceContent->meta_description !!}</textarea>
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
                <button type="submit" id="ServiceSubmit" class="btn btn-success">
                  {{ __('Update') }}
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
  <script src="{{ asset('assets/js/services.js') }}"></script>
  <script src="{{ asset('assets/js/vendor-dropzone.js') }}"></script>
@endsection
@section('variables')
  <script>
    "use strict";
    var storeUrl = "{{ route('vendor.service.imagesstore') }}";
    var removeUrl = "{{ route('vendor.service.imagermv') }}";
    var rmvdbUrl = "{{ route('vendor.service.imgdbrmv') }}";
    let galleryImages = "{{ $sliderImage }}";
  </script>
@endsection
