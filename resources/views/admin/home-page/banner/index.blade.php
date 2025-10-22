@extends('admin.layout')
{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('admin.partials.rtl-style')
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Banner Section') }}</h4>
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
        <a href="#">{{ __('Banner Section') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Banners') }}</div>
            </div>

            <div class="col-lg-4">
              @includeIf('admin.partials.languages')
            </div>

            <div class="col-lg-4 mt-2 mt-lg-0">
              <a href="#" data-toggle="modal" data-target="#createModal"
                class="btn btn-primary btn-sm float-lg-right float-left"><i class="fas fa-plus"></i>
                {{ __('Add Banner') }}</a>
              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="{{ route('admin.home_page.bulk_delete_banner') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col">
              @if (count($banners) == 0)
                <h3 class="text-center mt-2">{{ __('NO BANNER FOUND') . '!' }}</h3>
              @else
                <table class="table table-striped mt-3" id="basic-datatables">
                  <thead>
                    <tr>
                      <th scope="col">
                        <input type="checkbox" class="bulk-check" data-val="all">
                      </th>
                      <th scope="col">{{ __('Image') }}</th>
                      <th scope="col">{{ __('Title') }}</th>
                      <th scope="col">{{ __('Url') }}</th>
                      <th scope="col">{{ __('Serial Number') }}</th>
                      <th scope="col">{{ __('Actions') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $banner)
                      <tr>
                        <td>
                          <input type="checkbox" class="bulk-check" data-val="{{ $banner->id }}">
                        </td>
                        <td>
                          @php
                            $ImageWidth = '100px';
                          @endphp
                          <img src="{{ asset('assets/img/banners/' . $banner->image) }}" alt="banner"
                            style="width:{{ $ImageWidth }}">
                        </td>
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->url }}</td>
                        <td>{{ $banner->serial_number }}</td>
                        <td>
                          <a class="editBtn btn btn-secondary btn-sm mr-2 mb-1" href="#" data-toggle="modal"
                            data-target="#editModal" data-id="{{ $banner->id }}"
                            data-image="{{ asset('assets/img/banners/' . $banner->image) }}"
                            data-url="{{ $banner->url }}" data-title="{{ $banner->title }}"
                            data-serial_number="{{ $banner->serial_number }}">
                            <span class="btn-label"><i class="fas fa-edit"></i></span>
                          </a>

                          <form class="deleteForm d-inline-block"
                            action="{{ route('admin.home_page.delete_banner', ['id' => $banner->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm deleteBtn mr-2 mb-1">
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
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- create modal --}}
  @include('admin.home-page.banner.create')

  {{-- edit modal --}}
  @include('admin.home-page.banner.edit')
@endsection
