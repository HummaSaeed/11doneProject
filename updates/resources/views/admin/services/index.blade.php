@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Services') }}</h4>
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
        <a href="#">{{ __('Service Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Services') }}</a>
      </li>
    </ul>

  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-1 col-md-12 mb-2 mb-lg-0">
              <div class="card-title d-inline-block">{{ __('Services') }}</div>
            </div>
            <div class="col-lg-3 col-md-4">
              @includeIf('admin.partials.languages')
            </div>
            <div class="col-lg-6 col-md-8 mt-2 mt-lg-0 mt-md-0">
              <form action="{{ route('admin.service_managment') }}" method="get" id="serviceSearchForm">
                <input type="hidden" name="language" value="{{ request()->language }}">
                <div class="row">
                  <div class="col-sm-6">
                    <select name="vendor_id" id="" class="select2"
                      onchange="document.getElementById('serviceSearchForm').submit()">
                      <option value="" selected>{{ __('All') }}</option>
                      <option value="admin" @selected(request()->input('vendor_id') == 'admin')>{{ __('Admin') }}</option>
                      @foreach ($vendors as $vendor)
                        <option @selected($vendor->id == request()->input('vendor_id')) value="{{ $vendor->id }}">{{ $vendor->username }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-6 mt-3 mt-lg-0">
                    <input type="text" name="name" value="{{ request()->input('name') }}" class="form-control"
                      placeholder="{{ __('Name') }}">
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-2 mt-3 mt-lg-0">
              <div class="btn-groups justify-content-lg-end gap-10">
                <a href="{{ route('admin.service_managment.vendor_select') }}" class="btn btn-primary btn-sm"><i
                    class="fas fa-plus"></i>
                  {{ __('Add Service') }}</a>

                <button class="btn btn-danger btn-sm d-none bulk-delete"
                  data-href="{{ route('admin.service_managment.bulk_delete') }}"><i class="flaticon-interface-5"></i>
                  {{ __('Delete') }}</button>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($services) == 0)
                <h3 class="text-center mt-3">{{ __('NO SERVICE FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-2">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Service Image') }}</th>
                        <th scope="col">{{ __('Service Title') }}</th>
                        <th scope="col">{{ __('Vendor') }}</th>
                        <th scope="col">{{ __('Featured Status') }}</th>
                        <th scope="col">
                          @php $currencyText = $currencyInfo->base_currency_text; @endphp
                          {{ __('Price') . ' (' . $currencyText . ')' }}
                        </th>
                        <th>{{ __('Status') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($services as $service)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $service->id }}">
                          </td>
                          <td>
                            <img src="{{ asset('assets/img/services/' . $service->service_image) }}" alt="Service Image"
                              width="80">
                          </td>
                          <td>
                            @if ($service->content->isNotEmpty())
                              @foreach ($service->content as $content)
                                <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $service->id]) }}"
                                  target="_blank">
                                  {{ truncateString($content->name, 50) }}
                                </a>
                              @endforeach
                            @else
                              {{ '-' }}
                            @endif

                          </td>
                          <td>
                            @if ($service->vendor)
                              <a
                                href="{{ route('admin.vendor_management.vendor_details', ['slug' => $service->vendor->username, 'id' => $service->vendor->id]) }}">{{ $service->vendor->username }}</a>
                            @else
                              <span class="badge badge-success">{{ __('Admin') }}</span>
                            @endif

                          </td>
                          <td>
                            @php
                              $featuredService = \App\Models\FeaturedService\ServicePromotion::where(
                                  'service_id',
                                  $service->id,
                              )
                                  ->latest()
                                  ->first();
                            @endphp
                            @if ($featuredService)
                              @if ($featuredService->order_status == 'pending' || $featuredService->payment_status == 'pending')
                                <h2 class="d-inline-block"><span class="badge badge-warning">{{ __('Pending') }}</span>
                                </h2>
                              @elseif(
                                  $featuredService->order_status == 'approved' &&
                                      $featuredService->payment_status == 'completed' &&
                                      $featuredService->end_date >= \Carbon\Carbon::now()->format('Y-m-d'))
                                <h2 class="d-inline-block"><span class="badge badge-success">{{ __('Active') }}</span>
                                </h2>
                              @elseif ($featuredService->end_date <= \Carbon\Carbon::now()->format('Y-m-d'))
                                <a href="javascript:void()" class="featured btn btn-sm btn-primary" data-toggle="modal"
                                  data-target="#featureModal_{{ $service->id }}" data-id="{{ $service->id }}">
                                  {{ __('Add to Feature') }}
                                </a>
                              @endif
                            @else
                              <a href="javascript:void()" class="featured btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#featureModal_{{ $service->id }}">
                                {{ __('Add to Feature') }}
                              </a>
                            @endif
                          </td>
                          <td>{{ symbolPrice($service->price) }}</td>
                          <td>
                            <form id="serviceStatus{{ $service->id }}" class="d-inline-block"
                              action="{{ route('admin.service.status.change') }}" method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $service->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="status"
                                onchange="document.getElementById('serviceStatus{{ $service->id }}').submit();">
                                <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                </option>
                                <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>
                                  {{ __('Deactive') }}
                                </option>
                              </select>
                              <input type="hidden" name="service_id" value="{{ $service->id }}">
                            </form>
                          </td>

                          <td>
                            <a class="btn btn-secondary mt-1 btn-sm mr-1"
                              href="{{ route('admin.service_managment.edit', ['id' => $service->id]) }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>

                            <form class="deleteForm d-inline-block"
                              action="{{ route('admin.service_managment.delete', ['id' => $service->id]) }}"
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
                        @include('admin.services.featured')
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="mt-3 text-center">
            <div class="d-inline-block mx-auto">
              {{ $services->appends([
                      'vendor_id' => request()->input('vendor_id'),
                      'name' => request()->input('name'),
                      'language' => request()->input('language'),
                  ])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
