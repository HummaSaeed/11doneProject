@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Make a Withdrawal Request') }}</h4>
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
        <a href="{{ route('vendor.withdraw') }}">{{ __('Withdraw') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Make a Withdrawal Request') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-8">
              <div class="card-title">{{ __('Make a Withdrawal Request') }}</div>
            </div>
            <div class="col-lg-4">
              <div class="card-title float-right">{{ __('Your Balance') }} :
                {{ $settings->base_currency_symbol_position == 'left' ? $settings->base_currency_symbol : '' }}
                {{ Auth::guard('vendor')->user()->amount }}
                {{ $settings->base_currency_symbol_position == 'right' ? $settings->base_currency_symbol : '' }}</div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <form id="ajaxForm" action="{{ route('vendor.withdraw.send-request') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                  <div class="alert alert-danger">
                    <p><strong>{{ __('Opps Something went wrong') }}</strong></p>
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <input type="hidden" id="total_charge_input" name="total_charge_input">
                <div class="form-group">
                  <label for="">{{ __('Withdraw Method') . '*' }}</label>
                  <select name="withdraw_method" id="withdraw_method" class="form-control" required>
                    <option selected disabled>{{ __('Select Withdraw Method') }}</option>
                    @foreach ($methods as $item)
                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>
                  <p id="err_withdraw_method" class="mt-2 mb-0 text-danger em"></p>
                </div>

                <div class="form-group">
                  <label>{{ __('Withdraw  Amount') . '*' }}</label>
                  <input type="number" class="form-control" id="withdraw_amount" name="withdraw_amount"
                    placeholder="{{ __('Enter Withdraw Amount') }}" min="" required>
                  <p id="err_withdraw_amount" class="mt-2 mb-0 text-danger em"></p>

                  @if (Session::has('error'))
                    <p class="mt-2 mb-0 text-danger">{{ Session::get('error') }}</p>
                  @endif
                  <p class="mt-2 mb-0 text-warning d-none calculate">
                    {{ __('You will receive') . ' : ' }}<span
                      id="receive_amount">0</span>,

                    {{ __('Total Charge') . ' : ' }}<span
                      id="total_charge">0</span>,

                    {{ __('Your Balance will be') . ' : ' }}<span
                      id="your_balance">0</span>
                  </p>
                </div>
                <div id="appned_input">
                  <div class="all-inputs"></div>
                </div>
                <div class="form-group">
                  <label>{{ __('Additional Reference (Optional)') }}</label>
                  <input type="text" class="form-control" name="additional_reference"
                    placeholder="{{ __('Enter Additional Reference') }}">
                  @if ($errors->has('additional_reference'))
                    <p class="mt-2 mb-0 text-danger">{{ $errors->first('additional_reference') }}</p>
                  @endif
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="submitBtn" class="btn btn-success">
                {{ __('Send Request') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script>
    let symbol = "{{ $settings->base_currency_symbol }}";
    let symbolPosition = "{{ $settings->base_currency_symbol_position }}";
  </script>
  <script src="{{ asset('assets/js/vendor-withdraw.js') }}"></script>
@endsection
