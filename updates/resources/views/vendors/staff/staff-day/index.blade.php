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
      @if (count($staff->StaffContent) == 0)
        {{ '-' }}
      @else
        @foreach ($staff->StaffContent as $content)
          <li class="nav-item">
            <a href="#">
              {{ $content->name }}
            </a>
          </li>
        @endforeach
      @endif
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
      <div class="alert alert-warning text-dark">
        {{ __('If no specific schedule is set for a staff member, the "Schedule" will be applied to their timetable') }}
      </div>
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Days') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('vendor.staff_managment', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              @php
                $fontSize = '12px';
              @endphp
              <i class="fas fa-backward" style="font-size: {{ $fontSize }}"></i>
            </span>
            {{ __('Back') }}
          </a>
        </div>

        <div class="card-body">
          <div class="col-lg-12 mb-3">
            <div class="form-group">
              <label>{{ __('Customize Service Day') }}</label>
              <form id="basicForm{{ $staff->id }}"
                action="{{ route('vendor.customize.status.change', ['id' => $staff->id]) }}" method="post">
                @csrf
                <div class="selectgroup w-100">
                  <label class="selectgroup-item">
                    <input type="radio" onclick="document.getElementById('basicForm{{ $staff->id }}').submit()"
                      name="is_day" value="1" {{ $staff->is_day == 1 ? 'checked' : '' }}
                      class="selectgroup-input ">
                    <span class="selectgroup-button">{{ __('Yes') }}</span>
                  </label>

                  <label class="selectgroup-item">
                    <input type="radio" onclick="document.getElementById('basicForm{{ $staff->id }}').submit()"
                      name="is_day" value="0" {{ $staff->is_day == 0 ? 'checked' : '' }}
                      class="selectgroup-input ">
                    <span class="selectgroup-button">{{ __('No') }}</span>
                  </label>
                </div>
              </form>
            </div>
            <p class="text-warning mt-2 mb-0">
              <small><a target="_blank" href="{{ route('vendor.staff.global.day') }}">
                  {{ __('If you select No , then Schedule > Days will be applied to this staff.') }}</a></small>
            </p>
          </div>
          @if ($staff->is_day == 1)
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
                            <a href="{{ route('vendor.time-slot.manage', ['staff_id' => request()->staff_id, 'day_id' => $day->id]) }}"
                              class="btn btn-sm btn-primary">{{ __('Manage') }}</a>
                          </td>
                          <td>
                            <form id="staffDay{{ $day->id }}" class="d-inline-block"
                              action="{{ route('vendor.staff.change.weekend', ['id' => $day->id]) }}" method="post">
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
          @endif
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>
@endsection
