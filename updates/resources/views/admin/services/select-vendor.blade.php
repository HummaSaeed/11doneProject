@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Select Vendor') }}</h4>
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
        <a href="#">{{ __('Services Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Select Vendor') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Select Vendor') }}</div>
        </div>
        <form action="{{ route('admin.service_managment.create') }}" method="get">
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="form-group">
                  <label for="">{{ __('Vendor') }}</label>
                  <select name="vendor_id" class="form-control select2">
                    <option value="admin" selected>{{ __('Please Select') }}</option>
                    @foreach ($vendors as $vendor)
                      <option value="{{ $vendor->id }}">{{ $vendor->username }}</option>
                    @endforeach
                  </select>
                  <p class="text-warning">
                    {{ __('if you do not select any vendor, then this service will be listed for Admin') }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-12 text-center">
                  <button type="submit" id="submitButton" class="btn btn-success">{{ __('Proceed') }}</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
