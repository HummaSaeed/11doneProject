@extends('vendors.layout')
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Days') }}</h4>
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
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Days') }}</div>
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
                            <a href="{{ route('vendor.global.time-slot.manage', ['day_id' => $day->id]) }}"
                              class="btn btn-sm btn-primary">{{ __('Manage') }}</a>
                          @endif
                        </td>
                        <td>
                          <form id="staffDay{{ $day->id }}" class="d-inline-block"
                            action="{{ route('vendor.weekend.change', ['id' => $day->id]) }}" method="post">
                            @csrf
                            <select
                              class="form-control form-control-sm {{ $day->is_weekend == 1 ? 'bg-success' : 'bg-danger' }}"
                              name="is_weekend"
                              onchange="document.getElementById('staffDay{{ $day->id }}').submit();">
                              <option value="1" {{ $day->is_weekend == 1 ? 'selected' : '' }}>{{ __('Yes') }}
                              </option>
                              <option value="0" {{ $day->is_weekend == 0 ? 'selected' : '' }}>{{ __('No') }}
                              </option>
                            </select>
                            <input type="hidden" name="staff_id" value="{{ $day->staff_id }}">
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
