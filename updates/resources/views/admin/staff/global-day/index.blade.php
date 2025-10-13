@extends('admin.layout')
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __(' Days') }}</h4>
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
        <a href="#">{{ __('Schedule') }}</a>
      </li>

      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Days') }}</a>
      </li>
    </ul>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="card-title d-inline-block">{{ __('Days') }}</div>
            </div>
            <div class="col-lg-6 col-md-6 mt-2 mt-lg-0">
              <form action="{{ route('admin.staff.global.day') }}" method="get" id="daySearch">
                  <div class="col-lg-6 float-right">
                    <select name="vendor_id" id="" class="select2"
                      onchange="document.getElementById('daySearch').submit()">
                      <option value="admin" @selected(request()->input('vendor_id') == 'admin')>{{ __('Admin') }}</option>
                      @foreach ($vendors as $vendor)
                        <option @selected($vendor->id == request()->input('vendor_id')) value="{{ $vendor->id }}">{{ $vendor->username }}
                        </option>
                      @endforeach
                    </select>
                  </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="table-responsive">
                <table class="table table-striped mt-3" id="basic-datatables">
                  <thead>
                    <tr>
                      <th scope="col">{{ __('Day') }}</th>
                      <th scope="col">{{ __('Time Slots') }}</th>
                      <th scope="col">{{ __('Weekend') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($days as $day)
                      <tr>
                        <td>{{ $day->day }}</td>
                        <td>
                          @if ($day->is_weekend == 1)
                            {{ '-' }}
                          @else
                            <a href="{{ route('admin.global.time-slot.manage', ['vendor_id' => request()->vendor_id, 'day_id' => $day->id]) }}"
                              class="btn btn-sm btn-primary">{{ __('Manage') }}</a>
                          @endif
                        </td>
                        <td>
                          <form id="staffDay{{ $day->id }}" class="d-inline-block"
                            action="{{ route('admin.weekend.change', ['id' => $day->id]) }}" method="post">
                            @csrf
                            <input type="hidden" value="{{ request()->vendor_id }}" name="vendor_id">
                            <select
                              class="form-control form-control-sm {{ $day->is_weekend == 1 ? 'bg-success' : 'bg-danger' }}"
                              name="is_weekend"
                              onchange="document.getElementById('staffDay{{ $day->id }}').submit();">
                              <option value="1" {{ $day->is_weekend == 1 ? 'selected' : '' }}>{{ __('Yes') }}
                              </option>
                              <option value="0" {{ $day->is_weekend == 0 ? 'selected' : '' }}>{{ __('No') }}
                              </option>
                            </select>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>
@endsection
