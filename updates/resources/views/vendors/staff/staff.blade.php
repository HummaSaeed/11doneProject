@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Staff') }}</h4>
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

  @php
    $vendor_id = Auth::guard('vendor')->user()->id;
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);
  @endphp

  <div class="col-md-12">
    @if ($current_package != '[]')
      @if (vendorTotalAddedStaff($vendor_id) >= $current_package->staff_limit)
        <div class="alert alert-danger text-dark">
          {{ __("You can't add more staffs. Please buy/extend a plan to add staff") }}
        </div>
        @php
          $can_staff_add = 2;
        @endphp
      @else
        @php
          $can_staff_add = 1;
        @endphp
      @endif
    @else
      @php
        $pendingMemb = \App\Models\Membership::query()
            ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
            ->whereYear('start_date', '<>', '9999')
            ->orderBy('id', 'DESC')
            ->first();
        $pendingPackage = isset($pendingMemb)
            ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id)
            : null;
      @endphp
      @if ($pendingPackage)
        <div class="alert alert-warning text-dark">
          {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
        </div>
        <div class="alert alert-warning text-dark">
          <strong>{{ __('Pending Package') . ':' }} </strong> {{ $pendingPackage->title }}
          <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
          <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
        </div>
      @else
        <div class="alert alert-warning text-dark">
          {{ __('Please purchase a new package / extend the current package.') }}
        </div>
      @endif
      @php
        $can_staff_add = 0;
      @endphp
    @endif

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-4 col-md-4">
                <div class="card-title d-inline-block">{{ __('Staff') }}</div>
              </div>
              <div class="col-lg-4 col-md-4">
                @includeIf('vendors.partials.languages')
              </div>
              <div class="col-lg-4 col-md-4">
                <a href="{{ route('vendor.staff_managment.create') }}" class="btn btn-primary btn-sm float-right"><i
                    class="fas fa-plus"></i> {{ __('Add Staff') }}</a>
                <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                  data-href="{{ route('vendor.staff_managment.bulkDestroy') }}">
                  <i class="flaticon-interface-5"></i> {{ __('Delete') }}
                </button>
              </div>
            </div>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                @if (count($staffs) == 0)
                  <h3 class="text-center mt-2">{{ __('NO STAFF FOUND') . '!' }}</h3>
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
                    <table class="table table-striped mt-3" id="basic-datatables">
                      <thead>
                        <tr>
                          <th scope="col">
                            <input type="checkbox" class="bulk-check" data-val="all">
                          </th>
                          <th scope="col">{{ __('Image') }}</th>
                          <th scope="col">{{ __('Name') }}</th>
                          <th scope="col">{{ __('Username') }}</th>
                          <th scope="col">{{ __('Email') }}</th>
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
                              <img src="{{ asset('assets/img/staff/' . $staff->image) }}" alt="Staff Image"
                                width="50">
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
                            <td>
                              {{ $staff->username ?? '-' }}
                            </td>
                            <td>
                              {{ $staff->email }}
                            </td>

                            <td>
                              <a href="{{ route('vendor.staff_service_assign', ['id' => $staff->id, 'language' => request()->language]) }}"
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
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                  style="position: {{ $position }}; will-change: {{ $willChange }}; top: {{ $top }}; left: {{ $left }}; transform: {{ $transform }}">
                                  <a class=" dropdown-item btn btn-sm mr-1 editBtn "
                                    href="{{ route('vendor.service.day', ['staff_id' => $staff->id]) }}">
                                    {{ __('Time Slots') }}
                                  </a>
                                  <a class=" dropdown-item btn btn-sm mr-1 editBtn "
                                    href="{{ route('vendor.staff.holiday.index', ['id' => $staff->id]) }}">
                                    {{ __('Holidays') }}
                                  </a>
                                </div>
                              </div>
                            </td>
                            <td>
                              <form id="staffStatus{{ $staff->id }}" class="d-inline-block"
                                action="{{ route('vendor.status.change') }}" method="post">
                                @csrf
                                <select
                                  class="form-control form-control-sm {{ $staff->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                  name="status"
                                  onchange="document.getElementById('staffStatus{{ $staff->id }}').submit();">
                                  <option value="1" {{ $staff->status == 1 ? 'selected' : '' }}>{{ __('Active') }}
                                  </option>
                                  <option value="0" {{ $staff->status == 0 ? 'selected' : '' }}>
                                    {{ __('Deactive') }}
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
                                  @if ($current_package != '[]')
                                    <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                      href="{{ route('vendor.staff_managment.edit', ['id' => $staff->id]) }}">
                                      <span class="btn-label">
                                        <i class="fas fa-edit"></i>
                                      </span>
                                      {{ __('Edit') }}
                                    </a>
                                    @if ($staff->allow_login == 1)
                                      <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                        href="{{ route('vendor.staff.permission', ['id' => $staff->id]) }}">
                                        <span class="btn-label">
                                          <i class="fal fa-users-cog"></i>
                                        </span>
                                        {{ __('Permission') }}
                                      </a>
                                    @endif
                                    @if ($staff->allow_login == 1)
                                      <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                        href="{{ route('vendor.staff.change_password', ['id' => $staff->id]) }}"
                                        target="_self">
                                        <span class="btn-label">
                                          <i class="fal fa-key"></i>
                                        </span>
                                        {{ __('Change Password') }}
                                      </a>
                                    @endif
                                  @endif
                                  <form class="staffDeleteForm"
                                    action="{{ route('vendor.staff_managment.delete', $staff->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm px-3 deleteStaff">
                                      <span class="btn-label">
                                        <i class="fas fa-trash"></i>
                                      </span>
                                      {{ __('Delete') }}
                                    </button>
                                  </form>
                                  @if ($current_package != '[]')
                                    @if ($staff->allow_login == 1)
                                      <a class="dropdown-item btn btn-sm mr-1 editBtn"
                                        href="{{ route('vendor.staff.secret-login', ['id' => $staff->id]) }}"
                                        target="_blank">
                                        <span class="btn-label">
                                          <i class="fas fa-lock"></i>
                                        </span>
                                        {{ __('Secret Login') }}
                                      </a>
                                    @endif
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

          <div class="card-footer"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/js/staff.js') }}"></script>
@endsection
