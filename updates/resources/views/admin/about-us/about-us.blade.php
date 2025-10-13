@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('About') }}</h4>
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
        <a href="#">{{ __('About Us') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('About') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-8">
              <div class="card-title">{{ __('Update About') }}</div>
            </div>
            <div class="col-lg-4">
              @includeIf('admin.partials.languages')
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="about"
                action="{{ route('admin.about_us.update', ['language' => request()->input('language')]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12">
                  <div class="form-group">
                    <label for="">{{ __('Image') . '*' }}</label>
                    <br>
                    <div class="thumb-preview">
                      @if (@$data->about_section_image != null)
                        <img src="{{ asset('assets/img/about-us/' . $data->about_section_image) }}" alt="..."
                          class="uploaded-img">
                      @else
                        <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                      @endif
                    </div>

                    <div class="mt-3">
                      <div role="button" class="btn btn-primary btn-sm upload-btn">
                        {{ __('Choose Image') }}
                        <input type="file" class="img-input" name="about_section_image">
                      </div>
                    </div>
                    @error('about_section_image')
                      <div class="text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="title">{{ __('Title') }}</label>
                      <input type="text" value="{{ @$data->title }}" class="form-control" name="title"
                        placeholder="{{ __('Enter title') }}">
                      @error('title')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="subtitle">{{ __('Subtitle') }}</label>
                      <input type="text" value="{{ @$data->subtitle }}" class="form-control" name="subtitle"
                        placeholder="{{ __('Enter subtitle') }}">
                      @error('subtitle')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="button_text">{{ __('Button Text') }}</label>
                      <input type="text" value="{{ @$data->button_text }}" class="form-control" name="button_text"
                        placeholder="{{ __('Enter button text') }}">
                      @error('button_text')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="button_url">{{ __('Button Url') }}</label>
                      <input type="text" value="{{ @$data->button_url }}" class="form-control" name="button_url"
                        placeholder="{{ __('Enter button url') }}">
                      @error('button_url')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">{{ __('Features Title') . '*' }}</label>
                      <input type="text" class="form-control" name="features_title"
                        value="{{ empty($data->features_title) ? '' : $data->features_title }}"
                        placeholder="{{ __('Enter features title') }}">
                      @error('features_title')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="text">{{ __('Text') }}</label>
                  <textarea class="form-control summernote" name="text" data-height="300">{{ @$data->text }}</textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-success" form="about">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title">{{ __('Features') }}</div>
            </div>

            <div class="col-lg-3">
              @includeIf('admin.partials.languages')
            </div>

            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              <a href="#" data-toggle="modal" data-target="#createModal"
                class="btn btn-primary btn-sm float-lg-right float-left"><i class="fas fa-plus"></i>
                {{ __('Add') }}</a>

              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="{{ route('admin.about_us.bulk_delete_features') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col">
              @if (count($features) == 0)
                <h3 class="text-center mt-2">{{ __('NO FEATURES FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Icon') }}</th>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Serial Number') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($features as $feature)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $feature->id }}">
                          </td>
                          <td><i class="{{ $feature->icon }}"></i></td>
                          <td>
                            {{ strlen($feature->title) > 30 ? mb_substr($feature->title, 0, 30, 'UTF-8') . '...' : $feature->title }}
                          </td>
                          <td>{{ $feature->serial_number }}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm mr-1  mt-1 editBtn" href="#" data-toggle="modal"
                              data-target="#editModal" data-id="{{ $feature->id }}" data-icon="{{ $feature->icon }}"
                              data-title="{{ $feature->title }}" data-serial_number="{{ $feature->serial_number }}"
                              data-text="{{ $feature->text }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>

                            <form class="deleteForm d-inline-block"
                              action="{{ route('admin.about_us.delete_features', ['id' => $feature->id]) }}"
                              method="post">
                              @csrf
                              <button type="submit" class="btn btn-danger mt-1 btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>
  {{-- create modal --}}
  @include('admin.about-us.features.create')

  {{-- edit modal --}}
  @include('admin.about-us.features.edit')
@endsection
@section('script')
<script src="{{ asset('assets/js/features.js') }}"></script>
@endsection
