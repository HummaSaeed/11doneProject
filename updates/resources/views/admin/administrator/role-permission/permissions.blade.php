@extends('admin.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Permissions') }}</h4>
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
        <a href="#">{{ __('Admin Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="{{ route('admin.admin_management.role_permissions') }}">{{ __('Role & Permissions') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ $role->name }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Permissions') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form action="{{ route('admin.admin_management.role.update_permissions', ['id' => $role->id]) }}" method="post">
          @csrf
          <div class="card-header">
            <div class="card-title d-inline-block">{{ __('Permissions of') . ' ' . $role->name }}</div>
            <a class="btn btn-info btn-sm float-right d-inline-block"
              href="{{ route('admin.admin_management.role_permissions') }}">
              <span class="btn-label">
                <i class="fas fa-backward"></i>
              </span>
              {{ __('Back') }}
            </a>
          </div>

          <div class="card-body py-5">
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <div class="alert alert-warning text-center" role="alert">
                  <strong class="text-dark">{{ __('Select from this below options.') }}</strong>
                </div>
              </div>
            </div>

            @php $rolePermissions = json_decode($role->permissions); @endphp

            <div class="row mt-3 justify-content-center">
              <div class="col-lg-8">
                <div class="form-group">
                  <div class="selectgroup selectgroup-pills">
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Menu Builder"
                        @if (is_array($rolePermissions) && in_array('Menu Builder', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Menu Builder') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Package Management"
                        @if (is_array($rolePermissions) && in_array('Package Management', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Package Management') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Subscription Log"
                        @if (is_array($rolePermissions) && in_array('Subscription Log', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Subscription Log') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Service Managment"
                        @if (is_array($rolePermissions) && in_array('Service Managment', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Service Managment') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Featured Services"
                        @if (is_array($rolePermissions) && in_array('Featured Services', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Featured Services') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Service Inquiry"
                        @if (is_array($rolePermissions) && in_array('Service Inquiry', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Service Inquiry') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Staff Managment"
                        @if (is_array($rolePermissions) && in_array('Staff Managment', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Staff Managment') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Schedule"
                        @if (is_array($rolePermissions) && in_array('Schedule', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Schedule') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Appointments"
                        @if (is_array($rolePermissions) && in_array('Appointments', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Appointments') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Shop Management"
                        @if (is_array($rolePermissions) && in_array('Shop Management', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Shop Management') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Withdraws"
                        @if (is_array($rolePermissions) && in_array('Withdraws', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Withdraws') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Transactions"
                        @if (is_array($rolePermissions) && in_array('Transactions', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Transactions') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="User Management"
                        @if (is_array($rolePermissions) && in_array('User Management', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('User Management') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Vendors Management"
                        @if (is_array($rolePermissions) && in_array('Vendors Management', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Vendors Management') }}</span>
                    </label>


                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Home Page"
                        @if (is_array($rolePermissions) && in_array('Home Page', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Home Page') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="About Us"
                        @if (is_array($rolePermissions) && in_array('About Us', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('About Us') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="FAQs"
                        @if (is_array($rolePermissions) && in_array('FAQs', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('FAQs') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Blog"
                        @if (is_array($rolePermissions) && in_array('Blog', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Blog') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Contact Page"
                        @if (is_array($rolePermissions) && in_array('Contact Page', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Contact Page') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Additional Pages"
                        @if (is_array($rolePermissions) && in_array('Additional Pages', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Additional Pages') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Footer"
                        @if (is_array($rolePermissions) && in_array('Footer', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Footer') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Breadcrumbs"
                        @if (is_array($rolePermissions) && in_array('Breadcrumbs', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Breadcrumbs') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="SEO Informations"
                        @if (is_array($rolePermissions) && in_array('SEO Informations', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('SEO Informations') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Support Tickets"
                        @if (is_array($rolePermissions) && in_array('Support Tickets', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Support Tickets') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Advertise"
                        @if (is_array($rolePermissions) && in_array('Advertise', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Advertise') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]"
                        value="Announcement Popups" @if (is_array($rolePermissions) && in_array('Announcement Popups', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Announcement Popups') }}</span>
                    </label>

                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Settings"
                        @if (is_array($rolePermissions) && in_array('Settings', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Settings') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Payment Gateways"
                        @if (is_array($rolePermissions) && in_array('Payment Gateways', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Payment Gateways') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Languages"
                        @if (is_array($rolePermissions) && in_array('Languages', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Languages') }}</span>
                    </label>
                    <label class="selectgroup-item">
                      <input type="checkbox" class="selectgroup-input" name="permissions[]" value="Admin Management"
                        @if (is_array($rolePermissions) && in_array('Admin Management', $rolePermissions)) checked @endif>
                      <span class="selectgroup-button">{{ __('Admin Management') }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <div class="row">
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-success">
                  {{ __('Update') }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
