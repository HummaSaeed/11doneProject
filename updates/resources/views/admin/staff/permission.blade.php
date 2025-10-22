@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Permission') }}</h4>
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
        <a href="#">{{ __('Staff Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.staff_managment', ['language' => $defaultLang->code]) }}">{{ __('Staffs') }}</a>
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
        <a href="#">{{ __('Permission') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="{{ route('admin.staff.permission_update', ['id' => $staff->id]) }}" method="post">
          @csrf
          <div class="card-header">
            <div class="card-title d-inline-block">{{ __('Permission') }}</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.staff_managment',['language' => $defaultLang->code]) }}">
              <span class="btn-label">
                <i class="fas fa-backward"></i>
              </span>
              {{ __('Back') }}
            </a>
          </div>

          <div class="card-body py-5">
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <div class="alert alert-warning text-center" role="alert">
                  <strong class="text-dark">{{ __('Select from this below options.') }}</strong>
                </div>
              </div>
            </div>

            <div class="row mt-3 justify-content-center">
              <div class="col-lg-8">
                <div class="form-group">
                  <div class="selectgroup selectgroup-pills">
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="service_add" value="1"
                        @if ($staff->service_add == 1) checked @endif>
                      <span class="selectgroup-button">{{ __('Service Add') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="service_edit" value="1"
                        @if ($staff->service_edit == 1) checked @endif>
                      <span class="selectgroup-button">{{ __('Service Edit') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="service_delete" value="1"
                        @if ($staff->service_delete == 1) checked @endif>
                      <span class="selectgroup-button">{{ __('Service Delete') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="time" value="1"
                        @if ($staff->time == 1) checked @endif>
                      <span class="selectgroup-button">{{ __(' Time Schedule') }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
