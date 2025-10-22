@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Payment Methods') }}</h4>
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
        <a href="#">{{ __('Withdraws') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="">{{ __('Payment Methods') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <div class="card-title d-inline-block">{{ __('Payment Methods') }}</div>
            </div>

            <div class="col-md-6 mt-2 mt-md-0">
              <div class="btn-groups justify-content-md-end gap-10">
                <a href="javascript:void()" data-toggle="modal" data-target="#payment_method"
                  class="btn btn-primary btn-sm">
                  <i class="fas fa-plus"></i> {{ __('Add Payment Method') }}
                </a>

                <button class="btn btn-danger btn-sm d-none bulk-delete"
                  data-href="{{ route('vendor.service_managment.bulk_delete') }}">
                  <i class="flaticon-interface-5"></i> {{ __('Delete') }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($paymentMethods) == 0)
                <h3 class="text-center mt-2">{{ __('NO PAYMENT METHOD FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Min Limit') }}</th>
                        <th scope="col">{{ __('Max Limit') }}</th>
                        <th scope="col">{{ __('Manage Form') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($paymentMethods as $method)
                        <tr>
                          <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                          </th>
                          <td>{{ $method->name }}</td>
                          <td>{{ symbolPrice($method->min_limit) }}</td>
                          <td>{{ symbolPrice($method->max_limit) }}</td>
                          <td>
                            <a class="btn btn-info btn-sm"
                              href="{{ route('admin.withdraw_payment_method.mange_input', ['id' => $method->id]) }}">{{ __('Mange Form') }}</a>
                          </td>
                          @if ($method->status == 0)
                            <td>
                              <span class="badge badge-danger">{{ __('Deactive') }}</span>
                            </td>
                          @else
                            <td>
                              <span class="badge badge-success">{{ __('Active') }}</span>
                            </td>
                          @endif
                          <td>
                            <a class="btn btn-secondary btn-sm mr-1  mt-1 editBtn" href="#" data-toggle="modal"
                              data-target="#editModal" data-id="{{ $method->id }}" data-name="{{ $method->name }}"
                              data-min_limit="{{ $method->min_limit }}" data-max_limit="{{ $method->max_limit }}"
                              data-status="{{ $method->status }}" data-fixed_charge="{{ $method->fixed_charge }}"
                              data-percentage_charge ="{{ $method->percentage_charge }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>

                            <form class="deleteForm d-inline-block"
                              action="{{ route('admin.withdrawal.delete.payment', ['id' => $method->id]) }}"
                              method="post">
                              @csrf
                              <button type="submit" class="btn btn-danger  mt-1 btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
              @includeif('admin.withdraw.create')
              @includeif('admin.withdraw.edit')

            </div>
          </div>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/js/withdraw.js') }}"></script>
@endsection
