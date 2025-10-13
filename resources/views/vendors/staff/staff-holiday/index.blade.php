@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Holidays') }}</h4>
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
        <a href="#">{{ __('Holidays') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-warning text-dark">
        {{ __('If no specific holiday is set for a staff member, the "Schedule" will be applied to their timetable') }}
      </div>
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Holidays') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block ml-2" href="#" data-toggle="modal"
            data-target="#createModal">
            <span class="btn-label">
              <i class="fas fa-plus"></i>
            </span>
            {{ __('Add Holiday') }}
          </a>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('vendor.staff.global.day') }}">
            <span class="btn-label">
              @php
                $fontSize = '12px';
              @endphp
              <i class="fas fa-backward" style="font-size: {{ $fontSize }}"></i>
            </span>
            {{ __('Back') }}
          </a>
          <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
            data-href="{{ route('vendor.staff.holiday.bulkdestroy') }}">
            <i class="flaticon-interface-5"></i> {{ __('Delete') }}
          </button>

        </div>
        <div class="card-body">
          <div class="col-lg-12 mb-3">
            <div class="form-group">
              <label>{{ __('Customize Holiday') }}</label>
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
              <small><a target="_blank" href="{{ route('vendor.global.holiday') }}">
                  {{ __('If you select No, then Schedule > Holidays will be applied to this staff.') }}</a></small>
            </p>
          </div>
          @if ($staff->is_day == 1)
            <div class="row">
              <div class="col-lg-12">
                @if (count($staff_holydays) == 0)
                  <h3 class="text-center mt-2">{{ __('NO HOLIDAY FOUND') . '!' }}</h3>
                @else
                  <div class="table-responsive">
                    <table class="table table-striped mt-3" id="basic-datatables">
                      <thead>
                        <tr>
                          <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                          </th>
                          <th scope="col">{{ __('Date') }}</th>
                          <th scope="col">{{ __('Staff Name') }}</th>
                          <th scope="col">{{ __('Actions') }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($staff_holydays as $holyday)
                          <tr>
                            <td>
                              <input type="checkbox" class="bulk-check" data-val="{{ $holyday->id }}">
                            </td>
                            <td>{{ $holyday->date }}</td>
                            <td>{{ $holyday->staff->name }}</td>
                            <td>
                              <form class="deleteForm d-inline-block"
                                action="{{ route('vendor.staff.holiday.destroy', ['staff_id' => $holyday->staff_id, 'id' => $holyday->id]) }}"
                                method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm deleteBtn">
                                  <span class="btn-label">
                                    <i class="fas fa-trash"></i>
                                  </span>
                                  {{ __('Delete') }}
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
          @endif
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
  @include('vendors.staff.staff-holiday.create')
@endsection
