@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Services Assignment') }}</h4>
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
        <a href="#">{{ __('Staff Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('vendor.staff_managment', ['language' => $defaultLang->code]) }}">{{ __('Staffs') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        @php
          $content = $staff->staffContent->where('language_id', $defaultLang->id)->first();
        @endphp
        <a href="#">
          @if ($content)
            {{ $content->name }}
          @else
            {{ '-' }}
          @endif
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Services Assignment') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Services') }}</div>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-5 mt-2 mt-lg-0">

              <a href="#" data-toggle="modal" data-target="#createModal"
                class="btn btn-primary btn-sm float-lg-right float-left ml-1"><i class="fas fa-plus"></i>
                {{ __('Assign Service') }}</a>
              <a class="btn btn-info btn-sm float-lg-right float-left"
                href="{{ route('vendor.staff_managment', ['language' => $defaultLang->code]) }}">
                @php
                  $fontSize = '12px';
                @endphp
                <i class="fas fa-backward" style="font-size: {{ $fontSize }}"></i> {{ __('Back') }}</a>
              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="{{ route('vendor.staff_service_assign.blukDestroy') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>

            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($staffServices) == 0)
                <h3 class="text-center mt-2">{{ __('NO SERVICE FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Staff Name') }}</th>
                        <th scope="col">{{ __('Service Title') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($staffServices as $staffService)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $staffService->id }}">
                          </td>
                          <td>
                            @php
                              $staffcontent = $staffService->staffContent->first();
                            @endphp
                            {{ !empty($staffcontent) ? $staffcontent->name : '-' }}
                          </td>
                          <td>
                            @php
                              $serviceContent = $staffService->service->first();
                            @endphp
                            @if (!empty($serviceContent))
                              <a href="{{ route('frontend.service.details', ['slug' => $serviceContent->slug, 'id' => $staffService->service_id]) }}"
                                target="_blank">
                                {{ strlen($serviceContent->name) > 50 ? mb_substr($serviceContent->name, 0, 50, 'utf-8') . '...' : $serviceContent->name }}
                              </a>
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td>
                            <form class="deleteForm d-inline-block"
                              action="{{ route('vendor.staff_service_assign.delete', $staffService->id) }}"
                              method="post">

                              @csrf
                              <button type="submit" class=" btn btn-danger btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                {{ __('Unassign') }}
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

  @include('vendors.staff.staff-services.create')

@endsection
