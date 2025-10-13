@extends('admin.layout')
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Charges') }}</h4>
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
        <a href="#">{{ __('Service Managment') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Featured Services') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Charge') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="card-title d-inline-block">{{ __('Charges') }}</div>
            </div>

            <div class="col-lg-6 col-md-6 mt-3 mt-lg-0">
              <div class="btn-groups justify-content-md-end gap-10">
                <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-primary btn-sm"><i
                    class="fas fa-plus"></i>
                  {{ __('Add') }}
                </a>
                <button class="btn btn-danger btn-sm d-none bulk-delete"
                  data-href="{{ route('admin.charge.bulkdestroy') }}">
                  <i class="flaticon-interface-5"></i> {{ __('Delete') }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($charges) == 0)
                <h3 class="text-center mt-2">{{ __('NO CATEGORY FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">
                          @php $currencyText = $settings->base_currency_text; @endphp
                          {{ __('Amount') }} ({{ $currencyText }})
                        </th>
                        <th scope="col">{{ __('Day') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($charges as $charge)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $charge->id }}">
                          </td>
                          <td>
                            {{ symbolPrice($charge->amount) }}
                          </td>
                          <td>
                            {{ $charge->day }}
                          </td>
                          <td>
                            <a class="btn btn-secondary btn-sm mr-1  mt-1 editBtn" href="#" data-toggle="modal"
                              data-target="#editModal" data-id="{{ $charge->id }}" data-amount={{ $charge->amount }}
                              data-day="{{ $charge->day }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>

                            <form class="deleteForm d-inline-block"
                              action="{{ route('admin.charge.delete', ['id' => $charge->id]) }}" method="post">
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
            </div>
          </div>
        </div>

        <div class="card-footer"></div>
      </div>
    </div>
  </div>

  {{-- create modal --}}
  @include('admin.featured-service.charge.create')

  {{-- edit modal --}}
  @include('admin.featured-service.charge.edit')
@endsection
