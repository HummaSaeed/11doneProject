@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Balance Information') }}</h4>
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
        <a href="#">{{ __('Vendor Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.vendor_management.registered_vendor') }}">{{ __('Registered Vendors') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ $vendor->username }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Balance Information') }}</a>
      </li>
    </ul>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h2 class="mt-3 text-warning">{{ __('Vendor Balance') . ' : ' }}
            {{ $vendor->amount == null ? 0.0 : symbolPrice($vendor->amount) }}</h2>
          <hr>
          <form id="ajaxForm"
            action="{{ route('admin.vendor_management.vendor.update_vendor_balance', ['id' => $vendor->id]) }}"
            method="post">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ __('Vendor Balance') }}</label>
                  <div class="selectgroup w-100">
                    <label class="selectgroup-item">
                      <input type="radio" name="amount_status" value="1" class="selectgroup-input">
                      <span class="selectgroup-button">{{ __('Add') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="radio" name="amount_status" value="0" class="selectgroup-input">
                      <span class="selectgroup-button">{{ __('Subtract') }}</span>
                    </label>
                  </div>
                  <p id="err_amount_status" class="mt-2 mb-0 text-danger em"></p>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label>{{ __('Amount') }} {{ $settings->base_currency_symbol }}</label>
                  <input type="number" name="amount" class="form-control">
                  <p id="err_amount" class="mt-2 mb-0 text-danger em"></p>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <div class="row">
        <div class="col-12 text-center">
          <button type="submit" id="submitBtn" class="btn btn-success">
            {{ __('Update') }}
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection
