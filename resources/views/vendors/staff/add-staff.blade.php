@extends('vendors.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Add Staff') }}</h4>
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
        <a href="#">{{ __('Add Staff') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      @php
        $vendor_id = Auth::guard('vendor')->user()->id;
        $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission($vendor_id);
      @endphp
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

      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Add Staff') }}</div>
          <a class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('vendor.service_managment', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              @php
                $fontSize = '12px';
              @endphp
              <i class="fas fa-backward" style="font-size: {{ $fontSize }}"></i>
            </span>
            {{ __('Back') }}
          </a>
        </div>

        <div class="card-body pt-5 pb-5">

          <div class="alert alert-danger pb-1 dis-none" id="service_erros">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul></ul>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <form id="staffForm" action="{{ route('vendor.staff_managment.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="can_car_add" value="{{ $can_staff_add }}">
                <input type="hidden" name="vendorId" value="{{ Auth::guard('vendor')->user()->id }}">
                <div class="version border-0">
                  <div class="version-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="">{{ __('Photo') . '*' }}</label>
                          <br>
                          <div class="thumb-preview">
                            <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                          </div>

                          <div class="mt-3">
                            <div role="button" class="btn btn-primary btn-sm upload-btn">
                              {{ __('Choose Image') }}
                              <input type="file" class="img-input" name="staff_image">
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Email') . '*' }}</label>
                          <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="{{ __('Enter Email') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Phone') . '*' }}</label>
                          <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                            placeholder="{{ __('Enter Phone') }}">
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Status') . '*' }}</label>
                          <select name="status" class="form-control">
                            <option selected="" disabled="">{{ __('Select a Status') }}</option>
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Deactive') }}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" name="show_email_addresss" class="custom-control-input"
                              id="show_email_addresss">
                            <label class="custom-control-label"
                              for="show_email_addresss">{{ __('Show Email Address') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" name="show_phone" class="custom-control-input"
                              id="show_phone">
                            <label class="custom-control-label" for="show_phone">{{ __('Show Phone Number') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" value="1" name="show_information" class="custom-control-input"
                              id="show_information">
                            <label class="custom-control-label"
                              for="show_information">{{ __('Show Information') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Order Number') . '*' }}</label>
                          <input type="number" class="form-control" name="order_number"
                            value="{{ old('order_number') }}" placeholder="{{ __('Enter Order Number') }}">
                          <p class="text-warning">
                            <small>{{ __('The higher the order number is, the later the staff will be shown.') }}</small>
                          </p>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>{{ __('Allow Login ') }}</label>
                          <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                              <input type="radio" name="login_allow_toggle" value="1"
                                class="selectgroup-input">
                              <span class="selectgroup-button">{{ __('YES') }}</span>
                            </label>

                            <label class="selectgroup-item">
                              <input type="radio" name="login_allow_toggle" value="0" class="selectgroup-input"
                                checked="">
                              <span class="selectgroup-button">{{ __('NO') }}</span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="d-none allowLoginShowOff">
                        <div class="row">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>{{ __('Username') . '*' }}</label>
                              <div class="input-group">
                                <input type="text" class="form-control" name="username"
                                  placeholder="{{ __('Enter Username') }}">
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>{{ __('Password') . '*' }}</label>
                              <div class="input-group">
                                <input type="password" class="form-control" name="password"
                                  placeholder="{{ __('Enter Password') }}">
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div id="accordion" class="mt-5">
                      @foreach ($languages as $language)
                        <div class="version">
                          <div class="version-header" id="heading{{ $language->id }}">
                            <h5 class="mb-0">
                              <button type="button"
                                class="btn btn-link {{ $language->direction == 1 ? 'rtl text-right' : '' }}"
                                data-toggle="collapse" data-target="#collapse{{ $language->id }}"
                                aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $language->id }}">
                                {{ $language->name . __(' Language') }}
                                {{ $language->is_default == 1 ? '(Default)' : '' }}
                              </button>
                            </h5>
                          </div>

                          <div id="collapse{{ $language->id }}"
                            class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                            <div class="version-body {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                              <div class="row">
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>{{ __('Name') . '*' }}</label>
                                    <input type="text" class="form-control"
                                      value="{{ old($language->code . '_name') }}" name="{{ $language->code }}_name"
                                      placeholder="{{ __('Enter Name') }}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>{{ __('Address') }}</label>
                                    <input type="text" class="form-control"
                                      value="{{ old($language->code . '_location') }}"
                                      name="{{ $language->code }}_location" placeholder="{{ __('Enter Address') }}">
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>{{ __('Information') }}</label>
                                    <textarea class="form-control" name="{{ $language->code }}_information"
                                      placeholder="{{ __('Enter Short Description') }}" rows="4">{{ old($language->code . '_information') }}</textarea>

                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  @php $currLang = $language; @endphp
                                  @foreach ($languages as $language)
                                    @continue($language->id == $currLang->id)
                                    <div class="form-check py-0">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox"
                                          onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $language->id }}', event)">
                                        <span class="form-check-sign">{{ __('Clone for') }} <strong
                                            class="text-capitalize text-secondary">{{ $language->name }}</strong>
                                          {{ __('language') }}</span>
                                      </label>
                                    </div>
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>

                  </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="staffSubmit" class="btn btn-success">
                {{ __('Save') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('assets/js/services.js') }}"></script>
@endsection
