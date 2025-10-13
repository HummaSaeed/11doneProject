@extends('staffs.layout')
@section('style')
  <link rel="stylesheet" href="{{ asset('assets/css/jquery.timepicker.min.css') }}">
@endsection
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Time Slots') }}</h4>
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
        <a href="#">{{ __('Schedule') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('staff.time-slot') }}">{{ __('Days') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ $currentDay->day }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Time Slots') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Time Slots') }}</div>
          <a href="#" data-toggle="modal" data-target="#createModal"
            class="btn btn-primary btn-sm float-lg-right float-left"><i class="fas fa-plus"></i>
            {{ __('Add Time Slot') }}</a>
          <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
            data-href="{{ route('staff.hour.bulk_delete') }}">
            <i class="flaticon-interface-5"></i> {{ __('Delete') }}
        </div>
        <div class="card-body">
          <div class="col-lg-12">
            @if (count($service_hours) == 0)
              <h3 class="text-center mt-2">{{ __('NO TIME SLOT FOUND') . '!' }}</h3>
            @else
              <div class="table-responsive">
                <table class="table table-striped mt-3" id="basic-datatables">
                  <thead>
                    <tr>
                      <th scope="col">
                        <input type="checkbox" class="bulk-check" data-val="all">
                      </th>
                      <th scope="col">{{ __('Day') }}</th>
                      <th scope="col">{{ __('Start Time') }}</th>
                      <th scope="col">{{ __('End Time') }}</th>
                      <th scope="col">{{ __('Max Booking') }}</th>
                      <th scope="col">{{ __('Actions') }}</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($service_hours as $hour)
                      <tr>
                        <td>
                          <input type="checkbox" class="bulk-check" data-val="{{ $hour->id }}">
                        </td>
                        <td>{{ $hour->staffday->day }}</td>
                        <td>{{ $hour->start_time }}</td>
                        <td>{{ $hour->end_time }}</td>
                        <td>
                          @if ($hour->max_booking == null)
                            <span class="badge badge-success">{{ __('Unlimited') }}</span>
                          @else
                            {{ $hour->max_booking }}
                          @endif
                        </td>
                        <td>
                          <div>
                            <a class="btn btn-secondary btn-sm mr-1 editBtn" href="#" data-toggle="modal"
                              data-target="#editModal" data-id="{{ $hour->id }}"
                              data-staff_start_time="{{ $hour->start_time }}"
                              data-user_max_booking="{{ $hour->max_booking }}"
                              data-staff_end_time="{{ $hour->end_time }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                              {{ __('Edit') }}
                            </a>
                            <form class="deleteForm d-inline-block" action="{{ route('staff.hour.destroy', $hour->id) }}"
                              method="post">
                              @csrf
                              <button type="submit" class=" btn-danger btn  btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                                {{ __('Delete') }}
                              </button>
                            </form>
                          </div>
                        </td>

                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @endif
          </div>

        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
  @include('staffs.time.servicehour.create')
  @include('staffs.time.servicehour.edit')
@endsection
@section('script')
  <script src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>
@endsection
