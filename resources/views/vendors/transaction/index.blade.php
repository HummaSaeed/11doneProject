@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Transactions') }}</h4>
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
        <a href="#">{{ __('Transactions') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-8 col-md-6">
              <div class="card-title d-inline-block">{{ __('Transactions') }}</div>
            </div>

            <div class="col-lg-4 col-md-6 mt-2 mt-lg-0 justify-content-end">
              <form action="{{ url()->current() }}" class="d-inline-block d-flex">
                <input class="form-control" type="text" name="transaction_id"
                  placeholder="{{ __('Enter Transaction Id') }}"
                  value="{{ request()->input('transaction_id') ? request()->input('transaction_id') : '' }}">
                <button class="dis-none" type="submit"></button>
              </form>
            </div>
            <div class="col-lg-3">
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($transactions) == 0)
                <h3 class="text-center">{{ __('NO TRANSACTIONS FOUND') }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">{{ __('Transaction Id') }}</th>
                        <th scope="col">{{ __('Transaction Type') }}</th>
                        <th scope="col">{{ __('Payment Method') }}</th>
                        <th scope="col">{{ __('Pre Balance') }}</th>
                        <th scope="col">{{ __('Amount') }}</th>
                        <th scope="col">{{ __('After Balance') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($transactions as $transaction)
                        <tr>
                          <td>{{ '#' . $transaction->transaction_id }}</td>

                          <td>{{ ucwords(str_replace('_', ' ', $transaction->transaction_type)) }}</td>
                          <td>
                            @if ($transaction->transaction_type == 'withdraw' || $transaction->transaction_type == 'withdraw_declined')
                              @php
                                $method = $transaction->method()->first();
                              @endphp
                              @if ($method)
                                {{ $method->name }}
                              @else
                                {{ '-' }}
                              @endif
                            @elseif ($transaction->transaction_type == 'balance_subtrac' || $transaction->transaction_type == 'balance_added')
                              {{ '-' }}
                            @else
                              {{ $transaction->payment_method }}
                            @endif
                          </td>
                          <td>
                            @if ($transaction->pre_balance == null)
                              @if ($transaction->transaction_type == 'service_booking')
                                {{ '0.00' }}
                              @else
                                {{ '-' }}
                              @endif
                            @else
                              {{ $transaction->currency_symbol_position == 'left' ? $transaction->currency_symbol : '' }}
                              {{ $transaction->pre_balance }}
                              {{ $transaction->currency_symbol_position == 'right' ? $transaction->currency_symbol : '' }}
                            @endif
                          </td>
                          <td>
                            @if (
                                $transaction->transaction_type == 'withdraw' ||
                                    $transaction->transaction_type == 'balance_subtrac' ||
                                    $transaction->transaction_type == 'featured_service' ||
                                    $transaction->transaction_type == 'booking_refund')
                              <span class="text-danger">(-)</span>
                            @else
                              <span class="text-success">(+)</span>
                            @endif

                            {{ $transaction->currency_symbol_position == 'left' ? $transaction->currency_symbol : '' }}
                            @if ($transaction->transaction_type == 'booking_refund')
                              {{ $transaction->refund_amount }}
                            @endif
                            {{ $transaction->actual_total }}
                            {{ $transaction->currency_symbol_position == 'right' ? $transaction->currency_symbol : '' }}
                          </td>
                          <td>
                            @if ($transaction->after_balance == null)
                              {{ '-' }}
                            @else
                              {{ $transaction->currency_symbol_position == 'left' ? $transaction->currency_symbol : '' }}
                              {{ $transaction->after_balance }}
                              {{ $transaction->currency_symbol_position == 'right' ? $transaction->currency_symbol : '' }}
                            @endif

                          </td>
                          @if ($transaction->payment_status == 'completed')
                            <td>
                              <span class="badge badge-success">{{ __('Paid') }}</span>
                            </td>
                          @else
                            <td>
                              <span class="badge badge-danger">{{ __('Unpaid') }}</span>
                            </td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{ $transactions->appends(['transaction_id' => request()->input('transaction_id')])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
