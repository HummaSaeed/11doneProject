@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Service Inquiry') }}</h4>
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
        <a href="#">{{ __('Service Inquiry') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Inquiry Messages') }}</div>
            </div>

            <div class="col-lg-3">
              @includeIf('vendors.partials.languages')
            </div>

            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="{{ route('vendor.booking.inquiry.bulk_delete') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($messages) == 0)
                <h3 class="text-center mt-2">{{ __('NO MESSAGE FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="basic-datatables">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Service Title') }}</th>
                        <th scope="col">{{ __('Message') }}</th>
                        <th scope="col">{{ __('Customer Mail') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($messages as $message)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $message->id }}">
                          </td>
                          <td>
                            @if ($message->serviceContent->isNotEmpty())
                              @foreach ($message->serviceContent as $content)
                                <a href="{{ route('frontend.service.details', ['slug' => $content->slug, 'id' => $message->service_id]) }}"
                                  target="_blank">
                                  {{ truncateString($content->name, 50) }}
                                </a>
                              @endforeach
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td>
                            {{ strlen($message->message) > 50 ? mb_substr($message->message, 0, 50, 'utf-8') . '...' : $message->message }}
                          </td>
                          <td><a href="mailTo:{{ $message->email }}">{{ $message->email }}</a></td>
                          <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-info" data-toggle="modal"
                              data-target="#message-{{ $message->id }}">
                              {{ __('Show') }}
                            </a>
                            <form class="deleteForm d-inline-block"
                              action="{{ route('vendor.booking.inquiry.destory', ['id' => $message->id]) }}"
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
                        @includeIf('vendors.email.message-details')
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
@endsection
