@extends('admin.layout')
{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('admin.partials.rtl-style')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Work Process') }}</h4>
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
        <a href="#">{{ __('Work Process') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title">{{ __('Wrok Processes') }}</div>
            </div>

            <div class="col-lg-3">
              @includeIf('admin.partials.languages')
            </div>

            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              <a href="#" data-toggle="modal" data-target="#createModal"
                class="btn btn-primary btn-sm float-lg-right float-left"><i class="fas fa-plus"></i>
                {{ __('Add') }}</a>

              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="{{ route('admin.home_page.bulk_delete_work_process') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col">
              @if (count($processes) == 0)
                <h3 class="text-center mt-2">{{ __('NO WORK PROCESS FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        @if ($settings->theme_version == 1 || $settings->theme_version == 3)
                          <th scope="col">{{ __('Icon') }}</th>
                        @endif
                        @if ($settings->theme_version == 2)
                          <th scope="col">{{ __('Image') }}</th>
                        @endif
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Serial Number') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($processes as $process)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $process->id }}">
                          </td>
                          @if ($settings->theme_version == 1 || $settings->theme_version == 3)
                            <td><i class="{{ $process->icon }}"></i></td>
                          @endif
                          @if ($settings->theme_version == 2)
                            @php
                              $ImageWidth = '50px';
                            @endphp
                            <td>
                              <img src="{{ asset('assets/img/workprocess/' . $process->image) }}" alt=""
                                style="width:{{ $ImageWidth }}">
                            </td>
                          @endif
                          <td>
                            {{ strlen($process->title) > 30 ? mb_substr($process->title, 0, 30, 'UTF-8') . '...' : $process->title }}
                          </td>
                          <td>{{ $process->serial_number }}</td>
                          <td>
                            <a class="btn btn-secondary btn-sm mr-1  mt-1 editBtn" href="#" data-toggle="modal"
                              data-target="#editModal" data-id="{{ $process->id }}" data-icon="{{ $process->icon }}"
                              data-image="{{ is_null($process->image) ? asset('assets/img/noimage.jpg') : asset('assets/img/workprocess/' . $process->image) }}"
                              data-title="{{ $process->title }}" data-serial_number="{{ $process->serial_number }}"
                              data-background_color="{{ $process->background_color }}" data-text="{{ $process->text }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>

                            <form class="deleteForm d-inline-block"
                              action="{{ route('admin.home_page.delete_work_process', ['id' => $process->id]) }}"
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
  @include('admin.home-page.work-process-section.create')

  {{-- edit modal --}}
  @include('admin.home-page.work-process-section.edit')
@endsection
@section('script')
  <script src="{{ asset('assets/js/work-process.js') }}"></script>
@endsection
