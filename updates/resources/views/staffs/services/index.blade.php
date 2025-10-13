@extends('staffs.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Services') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('staff.dashboard') }}">
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
        <a href="{{ route('staff.service_managment', ['language' => $defaultLang->code]) }}">{{ __('Services') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-lg-3 col-md-6">
                  <div class="card-title d-inline-block">{{ __('Services') }}</div>
                </div>
                <div class="col-lg-3 col-md-4">
                  @includeIf('staffs.partials.languages')
                </div>
                <div class="col-lg-6 col-md-6 mt-2 mt-lg-0">
                  @if ($permission->service_add == 1)
                    <a href="{{ route('staff.service_managment.create') }}" class="btn btn-primary btn-sm float-right"><i
                        class="fas fa-plus"></i> {{ __('Add Service') }}</a>
                  @endif

                  <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                    data-href="{{ route('staff.service_managment.bulk_delete') }}">
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
                            <th scope="col">{{ __('Service Image') }}</th>
                            <th scope="col">{{ __('Service Title') }}</th>
                            <th scope="col">
                              @php $currencyText = $currencyInfo->base_currency_text; @endphp
                              {{ __('Price') . ' (' . $currencyText . ')' }}
                            </th>
                            @if ($package != '[]')
                              @if ($permission->service_edit == 1)
                                <th>{{ __('Status') }}</th>
                              @endif
                            @endif
                            @if ($permission->service_edit == 1 || $permission->service_delete == 1)
                              <th scope="col">{{ __('Actions') }}</th>
                            @endif
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($staffServices as $staffService)
                            @php
                              $services = App\Models\Services\Services::with([
                                  'content' => function ($q) use ($language_id) {
                                      $q->where('language_id', $language_id);
                                  },
                              ])
                                  ->where('id', $staffService->service_id)
                                  ->orderBy('id', 'asc')
                                  ->get();
                            @endphp
                            @foreach ($services as $service)
                              <tr>
                                <td>
                                  <input type="checkbox" class="bulk-check" data-val="{{ $service->id }}">
                                </td>
                                <td>
                                  <img src="{{ asset('assets/img/services/' . $service->service_image) }}"
                                    alt="Service Image" width="80">
                                </td>
                                <td>
                                  @if ($service->content->isNotEmpty())
                                    @foreach ($service->content as $content)
                                      <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $service->id]) }}"
                                        target="_blank">
                                        {{ strlen($content->name) > 50 ? mb_substr($content->name, 0, 50, 'utf-8') . '...' : $content->name }}
                                      </a>
                                    @endforeach
                                  @else
                                    {{ '-' }}
                                  @endif
                                </td>
                                <td>{{ symbolPrice($service->price) }}</td>
                                @if ($package != '[]')
                                  @if ($permission->service_edit == 1)
                                    <td>
                                      <form id="serviceStatus{{ $service->id }}" class="d-inline-block"
                                        action="{{ route('staff.service.status.change') }}" method="post">
                                        @csrf
                                        <select
                                          class="form-control form-control-sm {{ $service->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                          name="status"
                                          onchange="document.getElementById('serviceStatus{{ $service->id }}').submit();">
                                          <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>
                                            {{ __('Active') }}
                                          </option>
                                          <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>
                                            {{ __('Deactive') }}
                                          </option>
                                        </select>
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                      </form>
                                    </td>
                                  @endif
                                @endif
                                <td>
                                  @if ($package != '[]')
                                    @if ($permission->service_edit == 1)
                                      <a class="btn btn-secondary mt-1 btn-sm mr-1"
                                        href="{{ route('staff.service_managment.edit', ['id' => $service->id]) }}">
                                        <span class="btn-label">
                                          <i class="fas fa-edit"></i>
                                        </span>
                                      </a>
                                    @endif
                                  @endif
                                  @if ($permission->service_delete == 1)
                                    <form class="deleteForm d-inline-block"
                                      action="{{ route('staff.service_managment.delete_product', ['id' => $service->id]) }}"
                                      method="post">
                                      @csrf
                                      <button type="submit" class="btn btn-danger mt-1 btn-sm deleteBtn">
                                        <span class="btn-label">
                                          <i class="fas fa-trash"></i>
                                        </span>
                                      </button>
                                    </form>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
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

    </div>
  </div>
  <div id="razorPayForm"></div>
@endsection
