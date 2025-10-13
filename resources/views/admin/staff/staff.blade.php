@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Staff') }}</h4>
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
        <a href="#">{{ __('Staff') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-1 col-md-12 mb-2 mb-lg-0">
              <div class="card-title d-inline-block">{{ __('Staff') }}</div>
            </div>
            <div class="col-lg-3 col-md-4">
              @includeIf('admin.partials.languages')
            </div>
            <div class="col-lg-6 col-md-8 mt-2 mt-lg-0 mt-md-0">
              <form action="{{ route('admin.staff_managment') }}" method="GET" id="staffSearchForm">
                <input type="hidden" name="language" value="{{ request()->language }}">
                <div class="row">
                  <div class="col-sm-6 col-lg-6">
                    <select name="vendor_id" class="select2"
                      onchange="document.getElementById('staffSearchForm').submit()">
                      <option value="" selected>{{ __('All') }}</option>
                      <option value="admin" @selected(request()->input('vendor_id') == 'admin')>{{ __('Admin') }}</option>
                      @foreach ($vendors as $vendor)
                        <option @selected($vendor->id == request()->input('vendor_id')) value="{{ $vendor->id }}">{{ $vendor->username }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-lg-6 mt-2 mt-lg-0 mt-md-0">
                    <input type="text" name="name" value="{{ request()->input('name') }}" class="form-control"
                      placeholder="{{ __('Name') }}">
                  </div>
                </div>
              </form>
            </div>
            <div class="col-lg-2 mt-3 mt-lg-0">
              <div class="btn-groups justify-content-lg-end gap-10">
                <a href="{{ route('admin.staff_managment.create') }}" class="btn btn-primary btn-sm float-right"><i
                    class="fas fa-plus"></i>
                  {{ __('Add Staff') }}
                </a>
                <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                  data-href="{{ route('admin.staff_managment.bulkDestroy') }}"><i class="flaticon-interface-5"></i>
                  {{ __('Delete') }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($staffs) == 0)
                <h3 class="text-center mt-3">{{ __('NO STAFF FOUND!') }}</h3>
              @else
                <div class="row">
                  <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center gap-10">
                      <label for="inputField" class="flex-auto">{{ __('Staff Login Url') }}</label>
                      <input type="text" readonly value="{{ route('staff.login') }}" id="inputField"
                        class="form-control">
                      <span id="alert" class="text-bold">{{ __('Copied') }}</span>
                      <button class="btn-sm btn-warning" id="cpyBtn"><i class="fa fa-clipboard"></i></button>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped mt-2">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Image') }}</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Username') }}</th>
                        <th scope="col">{{ __('Email') }}</th>
                        <th scope="col">{{ __('Vendor') }}</th>
                        <th scope="col">{{ __('Services') }}</th>
                        <th scope="col">{{ __('Schedule') }}</th>
                        <th scope="col">{{ __('Account Status') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($staffs as $staff)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $staff->id }}">
                          </td>
                          <td>
                            <img src="{{ asset('assets/img/staff/' . $staff->image) }}" alt="Staff Image" width="50">
                          </td>
                          <td>
                            @if ($staff->StaffContent->isNotEmpty())
                              @foreach ($staff->StaffContent as $content)
                                {{ strlen($content->name) > 50 ? mb_substr($content->name, 0, 50, 'utf-8') . '...' : $content->name }}
                              @endforeach
                            @else
                              {{ '-' }}
                            @endif
                          </td>
                          <td> {{ $staff->username ?? '-' }}</td>
                          <td>
                            {{ $staff->email }}
                          </td>
                          <td>
                            @if ($staff->vendor_id != 0)
                              <a
                                href="{{ route('admin.vendor_management.vendor_details', ['slug' => $staff->vendor->username, 'id' => $staff->vendor->id]) }}">{{ $staff->vendor->username }}</a>
                            @else
                              <span class="badge badge-success">{{ __('Admin') }}</span>
                            @endif
                          </td>
                          <td>
                            <a href="{{ route('admin.staff_service_assign', ['id' => $staff->id, 'vendor_id' => $staff->vendor_id]) }}"
                              class="btn btn-sm btn-primary">{{ __('Assign') }}</a>
                          </td>
                          <td>
                            <div class="drop down">
                              <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Manage') }}
                              </button>
                              @php
                                $position = 'absolute';
                                $willChange = 'transform';
                                $top = '0px';
                                $left = '0px';
                                $transform = 'translate3d(0px, 33px, 0px)';
                              @endphp
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                x-placement="bottom-start"
                                style="position: {{ $position }}; will-change: {{ $willChange }}; top: {{ $top }}; left: {{ $left }}; transform: {{ $transform }}">
                                @if ($staff->vendor_id != 0)
                                  <a class=" dropdown-item btn btn-sm mr-1 editBtn "
                                    href="{{ route('admin.service.day', ['staff_id' => $staff->id, 'vendor_id' => $staff->vendor_id]) }}">
                                    {{ __('Time Slots') }}
                                  </a>
                                @else
                                  <a class=" dropdown-item btn btn-sm mr-1 editBtn "
                                    href="{{ route('admin.service.day', ['staff_id' => $staff->id, 'vendor_id' => 'admin']) }}">
                                    {{ __('Time Slots') }}
                                  </a>
                                @endif
                                @if ($staff->vendor_id != 0)
                                  <a class=" dropdown-item btn btn-sm mr-1 editBtn "
                                    href="{{ route('admin.staff.holiday.index', ['id' => $staff->id, 'vendor_id' => $staff->vendor->id]) }}">
                                    {{ __('Holidays') }}
                                  </a>
                                @else
                                  <a class=" dropdown-item btn btn-sm mr-1 editBtn "
                                    href="{{ route('admin.staff.holiday.index', ['id' => $staff->id, 'vendor_id' => 0]) }}">
                                    {{ __('Holidays') }}
                                  </a>
                                @endif
                              </div>
                            </div>
                          </td>
                          <td>
                            <form id="staffStatus{{ $staff->id }}" class="d-inline-block"
                              action="{{ route('admin.status.change') }}" method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $staff->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="status"
                                onchange="document.getElementById('staffStatus{{ $staff->id }}').submit();">
                                <option value="1" {{ $staff->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                </option>
                                <option value="0" {{ $staff->status == 0 ? 'selected' : '' }}>{{ __('Deactive') }}
                                </option>
                              </select>
                              <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                            </form>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-info btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                {{ __('Actions') }}
                              </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                  href="{{ route('admin.staff_managment.edit', ['id' => $staff->id]) }}">
                                  <span class="btn-label">
                                    <i class="fas fa-edit"></i>
                                  </span>
                                  {{ __(' Edit') }}
                                </a>
                                @if ($staff->allow_login == 1)
                                  <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                    href="{{ route('admin.staff.permission', ['id' => $staff->id]) }}">
                                    <span class="btn-label">
                                      <i class="fal fa-users-cog"></i>
                                    </span>
                                    {{ __('Permission') }}
                                  </a>
                                @endif
                                @if ($staff->allow_login == 1)
                                  <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                    href="{{ route('admin.staff.change_password', ['id' => $staff->id]) }}"
                                    target="_self">
                                    <span class="btn-label">
                                      <i class="fal fa-key"></i>
                                    </span>
                                    {{ __('Change Password') }}
                                  </a>
                                @endif
                                <form class="deleteForm"
                                  action="{{ route('admin.staff_managment.delete', $staff->id) }}" method="post">
                                  @csrf
                                  <button type="submit" class="btn btn-sm px-3 deleteBtn">
                                    <span class="btn-label">
                                      <i class="fas fa-trash"></i>
                                    </span>
                                    {{ __('Delete') }}
                                  </button>
                                </form>
                                @if ($staff->allow_login == 1)
                                  <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                    href="{{ route('admin.staff.secret-login', ['id' => $staff->id]) }}"
                                    target="_blank">
                                    <span class="btn-label">
                                      <i class="fas fa-lock"></i>
                                    </span>
                                    {{ __('Secret Login') }}
                                  </a>
                                @endif
                              </div>
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
        </div>

        <div class="card-footer">
          <div class="mt-3 text-center">
            <div class="d-inline-block mx-auto">
              {{ $staffs->appends([
                      'vendor_id' => request()->input('vendor_id'),
                      'name' => request()->input('name'),
                      'language' => request()->input('language'),
                  ])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
<script src="{{ asset('assets/js/staff.js') }}"></script>
@endsection
