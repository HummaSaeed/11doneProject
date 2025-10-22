<div class="sidebar sidebar-style-2"
  data-background-color="{{ $settings->admin_theme_version == 'light' ? 'white' : 'dark2' }}">
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          @if (Auth::guard('admin')->user()->image != null)
            <img src="{{ asset('assets/img/admins/' . Auth::guard('admin')->user()->image) }}" alt="Admin Image"
              class="avatar-img rounded-circle">
          @else
            <img src="{{ asset('assets/img/blank_user.jpg') }}" alt="" class="avatar-img rounded-circle">
          @endif
        </div>

        <div class="info">
          <a data-toggle="collapse" href="#adminProfileMenu" aria-expanded="true">
            <span>
              {{ Auth::guard('admin')->user()->first_name }}

              @if (is_null($roleInfo))
                <span class="user-level">Super Admin</span>
              @else
                <span class="user-level">{{ $roleInfo->name }}</span>
              @endif

              <span class="caret"></span>
            </span>
          </a>

          <div class="clearfix"></div>

          <div class="collapse in" id="adminProfileMenu">
            <ul class="nav">
              <li>
                <a href="{{ route('admin.edit_profile') }}">
                  <span class="link-collapse">Edit Profile</span>
                </a>
              </li>

              <li>
                <a href="{{ route('admin.change_password') }}">
                  <span class="link-collapse">Change Password</span>
                </a>
              </li>

              <li>
                <a href="{{ route('admin.logout') }}">
                  <span class="link-collapse">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      @php
        if (!is_null($roleInfo)) {
            $rolePermissions = json_decode($roleInfo->permissions);
        }
      @endphp

      <ul class="nav nav-primary">
        {{-- search --}}
        <div class="row mb-3">
          <div class="col-12">
            <form action="">
              <div class="form-group py-0">
                <input name="term" type="text" class="form-control sidebar-search ltr"
                  placeholder="Search Menu Here...">
              </div>
            </form>
          </div>
        </div>

        {{-- dashboard --}}
        <li class="nav-item @if (request()->routeIs('admin.dashboard')) active @endif">
          <a href="{{ route('admin.dashboard') }}">
            <i class="la flaticon-paint-palette"></i>
            <p>Dashboard</p>
          </a>
        </li>
        {{-- menu builder --}}
        @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Menu Builder', $rolePermissions)))
          <li class="nav-item @if (request()->routeIs('admin.menu_builder')) active @endif">
            <a href="{{ route('admin.menu_builder', ['language' => $defaultLang->code]) }}">
              <i class="fal fa-bars"></i>
              <p>Menu Builder</p>
            </a>
          </li>
        @endif

        {{-- package management --}}
        @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Package Management', $rolePermissions)))
          <li
            class="nav-item @if (request()->routeIs('admin.package.settings')) active
            @elseif (request()->routeIs('admin.package.index')) active
            @elseif (request()->routeIs('admin.package.edit')) active @endif">
            <a data-toggle="collapse" href="#packageManagement">
              <i class="fal fa-receipt"></i>
              <p>Package Management</p>
              <span class="caret"></span>
            </a>

            <div id="packageManagement"
              class="collapse
              @if (request()->routeIs('admin.package.settings')) show
              @elseif (request()->routeIs('admin.package.index')) show
              @elseif (request()->routeIs('admin.package.edit')) show @endif">
              <ul class="nav nav-collapse">

                <li class="{{ request()->routeIs('admin.package.settings') ? 'active' : '' }}">
                  <a href="{{ route('admin.package.settings') }}">
                    <span class="sub-item">Settings</span>
                  </a>
                </li>

                <li
                  class="@if (request()->routeIs('admin.package.index')) active
            @elseif (request()->routeIs('admin.package.edit')) active @endif">
                  <a href="{{ route('admin.package.index') }}">
                    <span class="sub-item">Packages</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        @endif

        {{-- subscription log --}}
        @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Subscription Log', $rolePermissions)))
          <li class="nav-item @if (request()->routeIs('admin.subscription-log.index')) active @endif">
            <a href="{{ route('admin.subscription-log.index') }}">
              <i class="fas fa-file-invoice-dollar"></i>
              <p>Subscription Log</p>
            </a>
          </li>
        @endif

        {{-- service managment --}}
        @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Service Managment', $rolePermissions)))
          <li
            class="nav-item
            @if (request()->routeIs('admin.service_managment')) active @endif
            @if (request()->routeIs('admin.service_managment.vendor_select')) active @endif
            @if (request()->routeIs('admin.service_managment.edit')) active @endif
            @if (request()->routeIs('admin.service_managment.create')) active @endif
            @if (request()->routeIs('admin.service_managment.category')) active @endif
            @if (request()->routeIs('admin.service_managment.create')) active @endif
            @if (request()->routeIs('admin.booking.inquiry')) active @endif
            @if (request()->routeIs('admin.charge.index')) active @endif
            @if (request()->routeIs('admin.all-featured.service')) active @endif
            @if (request()->routeIs('admin.approved-featured.service')) active @endif
            @if (request()->routeIs('admin.rejected-featured.service')) active @endif
            @if (request()->routeIs('admin.pending-featured.service')) active @endif" ">
            <a data-toggle="collapse" href="#service">
              <i class="fas fa-wrench"></i>
              <p>Service Managment</p>
              <span class="caret"></span>
            </a>

            <div id="service"
              class="collapse
              @if (request()->routeIs('admin.service_managment')) show
              @elseif (request()->routeIs('admin.service_managment.edit')) show
              @elseif (request()->routeIs('admin.service_managment.create')) show
              @elseif (request()->routeIs('admin.service_managment.vendor_select')) show
              @elseif (request()->routeIs('admin.service_managment.category')) show
              @elseif (request()->routeIs('admin.booking.inquiry')) show
              @elseif (request()->routeIs('admin.charge.index')) show
            @elseif (request()->routeIs('admin.all-featured.service')) show
            @elseif (request()->routeIs('admin.approved-featured.service')) show
            @elseif (request()->routeIs('admin.rejected-featured.service')) show
            @elseif (request()->routeIs('admin.pending-featured.service')) show
              @elseif (request()->routeIs('admin.service_managment.create')) show @endif">
              <ul class="nav nav-collapse">
                <li class="{{ request()->routeIs('admin.service_managment.category') ? 'active' : '' }}">
                  <a href="{{ route('admin.service_managment.category', ['language' => $defaultLang->code]) }}">
                    <span class="sub-item">Categories</span>
                  </a>
                </li>

                <li
                  class="
                @if (request()->routeIs('admin.service_managment')) active @endif
                @if (request()->routeIs('admin.service_managment.edit')) active @endif
                ">
                  <a href="{{ route('admin.service_managment', ['language' => $defaultLang->code]) }}">
                    <span class="sub-item">Services</span>
                  </a>
                </li>
                <li
                  class="
                @if (request()->routeIs('admin.service_managment.vendor_select')) active @endif
                    @if (request()->routeIs('admin.service_managment.create')) active @endif
                ">
                  <a href="{{ route('admin.service_managment.vendor_select') }}">
                    <span class="sub-item">Add Service</span>
                  </a>
                </li>
                {{-- service featured --}}
                <li class="submenu">
                  <a data-toggle="collapse" href="#featured-service-page"
                    aria-expanded="{{ request()->routeIs('admin.charge.index') ||
                    request()->routeIs('admin.all-featured.service') ||
                    request()->routeIs('admin.approved-featured.service') ||
                    request()->routeIs('admin.rejected-featured.service') ||
                    request()->routeIs('admin.pending-featured.service')
                        ? 'true'
                        : 'false' }}">
                    <span class="sub-item">Featured Services</span>
                    <span class="caret"></span>
                  </a>
                  <div id="featured-service-page"
                    class="collapse
                    @if (request()->routeIs('admin.charge.index')) show @endif
            @if (request()->routeIs('admin.all-featured.service')) show @endif
            @if (request()->routeIs('admin.approved-featured.service')) show @endif
            @if (request()->routeIs('admin.rejected-featured.service')) show @endif
            @if (request()->routeIs('admin.pending-featured.service')) show @endif"">
            <ul class="nav nav-collapse subnav">
              <li class="{{ request()->routeIs('admin.charge.index') ? 'active' : '' }}">
                <a href="{{ route('admin.charge.index') }}">
                  <span class="sub-item">Charges</span>
                </a>
              </li>

              <li class="{{ request()->routeIs('admin.all-featured.service') ? 'active' : '' }}">
                <a href="{{ route('admin.all-featured.service', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">All Requests</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('admin.pending-featured.service') ? 'active' : '' }}">
                <a href="{{ route('admin.pending-featured.service', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Pending Requests</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('admin.approved-featured.service') ? 'active' : '' }}">
                <a href="{{ route('admin.approved-featured.service', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Approved Requests</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('admin.rejected-featured.service') ? 'active' : '' }}">
                <a href="{{ route('admin.rejected-featured.service', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Rejected Requests</span>
                </a>
              </li>
            </ul>
    </div>
    </li>
    {{-- service inquiry --}}
    <li class=" @if (request()->routeIs('admin.booking.inquiry')) active @endif">
      <a href="{{ route('admin.booking.inquiry', ['language' => $defaultLang->code]) }}">
        <span class="sub-item">Service Inquiry</span>
      </a>
    </li>

    </ul>
  </div>
  </li>
  @endif
  {{-- staff managment --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Staff Managment', $rolePermissions)))
    <li
      class="nav-item
          @if (request()->routeIs('admin.staff_managment')) active @endif
          @if (request()->routeIs('admin.staff_managment.create')) active @endif
          @if (request()->routeIs('admin.staff_managment.edit')) active @endif
          @if (request()->routeIs('admin.staff_service_assign')) active @endif
          @if (request()->routeIs('admin.staff.change_password')) active @endif
          @if (request()->routeIs('admin.service.day')) active @endif
          @if (request()->routeIs('admin.time-slot.manage')) active @endif
          @if (request()->routeIs('admin.staff.holiday.index')) active @endif
          @if (request()->routeIs('admin.staff.permission')) active @endif
          ">
      <a data-toggle="collapse" href="#staff">
        <i class="fas fa-user"></i>
        <p>Staff Managment</p>
        <span class="caret"></span>
      </a>

      <div id="staff"
        class="collapse
               @if (request()->routeIs('admin.staff_managment')) show @endif
               @if (request()->routeIs('admin.staff_managment.create')) show @endif
              @if (request()->routeIs('admin.staff_managment.edit')) show @endif
              @if (request()->routeIs('admin.staff.change_password')) show @endif
              @if (request()->routeIs('admin.staff_service_assign')) show @endif
              @if (request()->routeIs('admin.service.day')) show @endif
              @if (request()->routeIs('admin.staff.permission')) show @endif
              @if (request()->routeIs('admin.time-slot.manage')) show @endif>
              @if (request()->routeIs('admin.staff.holiday.index'))
show
@endif">
        <ul class="nav nav-collapse">
          <li
            class="
              @if (request()->routeIs('admin.staff_managment')) active @endif
                @if (request()->routeIs('admin.staff_managment.edit')) active @endif
                @if (request()->routeIs('admin.staff_service_assign')) active @endif
                @if (request()->routeIs('admin.service.day')) active @endif
                @if (request()->routeIs('admin.staff.change_password')) active @endif
                @if (request()->routeIs('admin.time-slot.manage')) active @endif
                @if (request()->routeIs('admin.staff.permission')) active @endif
                @if (request()->routeIs('admin.staff.holiday.index')) active @endif">
            <a href="{{ route('admin.staff_managment', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Staff</span>
            </a>
          </li>
          <li class="
                @if (request()->routeIs('admin.staff_managment.create')) active @endif
                ">
            <a href="{{ route('admin.staff_managment.create') }}">
              <span class="sub-item">Add Staff</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif
  {{-- Global Schedule --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Schedule', $rolePermissions)))
    <li
      class="nav-item
        @if (request()->routeIs('admin.staff.global.day')) active @endif
        @if (request()->routeIs('admin.global.holiday')) active @endif
        @if (request()->routeIs('admin.time-formate')) active @endif
        @if (request()->routeIs('admin.global.time-slot.manage')) active @endif">
      <a data-toggle="collapse" href="#time">
        <i class="fas fa-clock"></i>
        <p>Schedule</p>
        <span class="caret"></span>
      </a>

      <div id="time"
        class="collapse
          @if (request()->routeIs('admin.staff.global.day')) show @endif
          @if (request()->routeIs('admin.global.holiday')) show @endif
          @if (request()->routeIs('admin.time-formate')) show @endif
          @if (request()->routeIs('admin.global.time-slot.manage')) show @endif">
        <ul class="nav nav-collapse">
          <li class="@if (request()->routeIs('admin.time-formate')) active @endif">
            <a href="{{ route('admin.time-formate') }}">
              <span class="sub-item">Settings</span>
            </a>
          </li>
          <li
            class="@if (request()->routeIs('admin.staff.global.day')) active @endif
                @if (request()->routeIs('admin.global.time-slot.manage')) active @endif">
            <a href="{{ route('admin.staff.global.day', ['vendor_id' => 'admin']) }}">
              <span class="sub-item">Days</span>
            </a>
          </li>
          <li class="@if (request()->routeIs('admin.global.holiday')) active @endif">
            <a href="{{ route('admin.global.holiday', ['vendor_id' => 'admin']) }}">
              <span class="sub-item">Holidays</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif

  {{-- Booking --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Appointments', $rolePermissions)))
    <li
      class="nav-item
           @if (request()->routeIs('admin.pending_appointment')) active @endif
           @if (request()->routeIs('admin.accepted_appointment')) active @endif
           @if (request()->routeIs('admin.rejected_appointment')) active @endif
           @if (request()->routeIs('admin.appointment.details')) active @endif
           @if (request()->routeIs('admin.all_appointment')) active @endif">
      <a data-toggle="collapse" href="#appointment">
        <i class="fal fa-calendar"></i>
        <p>Appointments </p>
        <span class="caret"></span>
      </a>

      <div id="appointment"
        class="collapse
              @if (request()->routeIs('admin.pending_appointment')) show @endif
           @if (request()->routeIs('admin.accepted_appointment')) show @endif
           @if (request()->routeIs('admin.appointment.details')) show @endif
           @if (request()->routeIs('admin.rejected_appointment')) show @endif
              @if (request()->routeIs('admin.all_appointment')) show @endif">
        <ul class="nav nav-collapse">
          <li
            class="
                @if (request()->routeIs('admin.all_appointment')) active @endif
                @if (request()->routeIs('admin.appointment.details')) active @endif
                ">
            <a href="{{ route('admin.all_appointment', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">All Appointments</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.pending_appointment') ? 'active' : '' }}">
            <a href="{{ route('admin.pending_appointment', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Pending Appointments</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.accepted_appointment') ? 'active' : '' }}">
            <a href="{{ route('admin.accepted_appointment', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Accepted Appointments</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.rejected_appointment') ? 'active' : '' }}">
            <a href="{{ route('admin.rejected_appointment', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Rejected Appointments</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif
  {{-- shop --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Shop Management', $rolePermissions)))
    <li
      class="nav-item @if (request()->routeIs('admin.shop_management.tax_amount')) active
            @elseif (request()->routeIs('admin.shop_management.shipping_charges')) active
            @elseif (request()->routeIs('admin.shop_management.coupons')) active
            @elseif (request()->routeIs('admin.shop_management.product.categories')) active
            @elseif (request()->routeIs('admin.shop_management.products')) active
            @elseif (request()->routeIs('admin.shop_management.select_product_type')) active
            @elseif (request()->routeIs('admin.shop_management.create_product')) active
            @elseif (request()->routeIs('admin.shop_management.edit_product')) active
            @elseif (request()->routeIs('admin.shop_management.orders')) active
            @elseif (request()->routeIs('admin.shop_management.order.details')) active
            @elseif (request()->routeIs('admin.shop_management.settings')) active
            @elseif (request()->routeIs('admin.shop_management.report')) active @endif">
      <a data-toggle="collapse" href="#shop">
        <i class="fal fa-store-alt"></i>
        <p>Shop Management</p>
        <span class="caret"></span>
      </a>

      <div id="shop"
        class="collapse
              @if (request()->routeIs('admin.shop_management.tax_amount')) show
              @elseif (request()->routeIs('admin.shop_management.shipping_charges')) show
              @elseif (request()->routeIs('admin.shop_management.coupons')) show
              @elseif (request()->routeIs('admin.shop_management.product.categories')) show
              @elseif (request()->routeIs('admin.shop_management.products')) show
              @elseif (request()->routeIs('admin.shop_management.select_product_type')) show
              @elseif (request()->routeIs('admin.shop_management.create_product')) show
              @elseif (request()->routeIs('admin.shop_management.edit_product')) show
              @elseif (request()->routeIs('admin.shop_management.orders')) show
              @elseif (request()->routeIs('admin.shop_management.order.details')) show
              @elseif (request()->routeIs('admin.shop_management.settings')) show
              @elseif (request()->routeIs('admin.shop_management.report')) show @endif">
        <ul class="nav nav-collapse">
          <li class="{{ request()->routeIs('admin.shop_management.settings') ? 'active' : '' }}">
            <a href="{{ route('admin.shop_management.settings') }}">
              <span class="sub-item">Settings</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.shop_management.tax_amount') ? 'active' : '' }}">
            <a href="{{ route('admin.shop_management.tax_amount') }}">
              <span class="sub-item">Tax Amount</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.shop_management.shipping_charges') ? 'active' : '' }}">
            <a href="{{ route('admin.shop_management.shipping_charges', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Shipping Charges</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.shop_management.coupons') ? 'active' : '' }}">
            <a href="{{ route('admin.shop_management.coupons') }}">
              <span class="sub-item">Coupons</span>
            </a>
          </li>

          <li class="submenu">
            <a data-toggle="collapse" href="#product"
              aria-expanded="{{ request()->routeIs('admin.shop_management.product.categories') || request()->routeIs('admin.shop_management.products') || request()->routeIs('admin.shop_management.select_product_type') || request()->routeIs('admin.shop_management.create_product') || request()->routeIs('admin.shop_management.edit_product') ? 'true' : 'false' }}">
              <span class="sub-item">Manage Products</span>
              <span class="caret"></span>
            </a>

            <div id="product"
              class="collapse
                    @if (request()->routeIs('admin.shop_management.product.categories')) show
                    @elseif (request()->routeIs('admin.shop_management.products')) show
                    @elseif (request()->routeIs('admin.shop_management.select_product_type')) show
                    @elseif (request()->routeIs('admin.shop_management.create_product')) show
                    @elseif (request()->routeIs('admin.shop_management.edit_product')) show @endif">
              <ul class="nav nav-collapse subnav">
                <li class="{{ request()->routeIs('admin.shop_management.product.categories') ? 'active' : '' }}">
                  <a
                    href="{{ route('admin.shop_management.product.categories', ['language' => $defaultLang->code]) }}">
                    <span class="sub-item">Categories</span>
                  </a>
                </li>

                <li
                  class="@if (request()->routeIs('admin.shop_management.products')) active
                        @elseif (request()->routeIs('admin.shop_management.select_product_type')) active
                        @elseif (request()->routeIs('admin.shop_management.create_product')) active
                        @elseif (request()->routeIs('admin.shop_management.edit_product')) active @endif">
                  <a href="{{ route('admin.shop_management.products', ['language' => $defaultLang->code]) }}">
                    <span class="sub-item">Products</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          <li
            class="@if (request()->routeIs('admin.shop_management.orders')) active
                  @elseif (request()->routeIs('admin.shop_management.order.details')) active @endif">
            <a href="{{ route('admin.shop_management.orders') }}">
              <span class="sub-item">Orders</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.shop_management.report') ? 'active' : '' }}">
            <a href="{{ route('admin.shop_management.report') }}">
              <span class="sub-item">Report</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif
  {{-- withdrawals managment --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Withdraw Method', $rolePermissions)))
    <li
      class="nav-item
          @if (request()->routeIs('admin.withdrawal.index')) active @endif
          @if (request()->routeIs('admin.withdraw_payment_method.mange_input')) active @endif
          @if (request()->routeIs('admin.withdraw_payment_method.edit_input')) active @endif
          @if (request()->routeIs('admin.withdraw.withdraw_request')) active @endif
          ">
      <a data-toggle="collapse" href="#withdrew">
        <i class="fal fa-credit-card"></i>
        <p>Withdraws</p>
        <span class="caret"></span>
      </a>

      <div id="withdrew"
        class="collapse
            @if (request()->routeIs('admin.withdrawal.index')) show @endif
            @if (request()->routeIs('admin.withdraw_payment_method.mange_input')) show @endif
            @if (request()->routeIs('admin.withdraw_payment_method.edit_input')) show @endif
            @if (request()->routeIs('admin.withdraw.withdraw_request')) show @endif
            ">
        <ul class="nav nav-collapse">
          <li
            class="
                @if (request()->routeIs('admin.withdrawal.index')) active @endif
                @if (request()->routeIs('admin.withdraw_payment_method.mange_input')) active @endif
                @if (request()->routeIs('admin.withdraw_payment_method.edit_input')) active @endif
                ">
            <a href="{{ route('admin.withdrawal.index') }}">
              <span class="sub-item">Payment Methods</span>
            </a>
          </li>
          <li class="@if (request()->routeIs('admin.withdraw.withdraw_request')) active @endif">
            <a href="{{ route('admin.withdraw.withdraw_request') }}">
              <span class="sub-item">Withdraw Requests</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif
  {{-- transation --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Transactions', $rolePermissions)))
    <li class="nav-item @if (request()->routeIs('admin.transaction')) active @endif">
      <a href="{{ route('admin.transaction') }}">
        <i class="fal fa-exchange-alt"></i>
        <p>Transactions</p>
      </a>
    </li>
  @endif

  {{-- user --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('User Management', $rolePermissions)))
    <li
      class="nav-item @if (request()->routeIs('admin.user_management.registered_users')) active
            @elseif (request()->routeIs('admin.user_management.registered_user.create')) active
            @elseif (request()->routeIs('admin.user_management.registered_user.edit')) active
            @elseif (request()->routeIs('admin.user_management.user.change_password')) active
            @elseif (request()->routeIs('admin.user_management.subscribers')) active
            @elseif (request()->routeIs('admin.user_management.mail_for_subscribers')) active
            @elseif (request()->routeIs('admin.user_management.push_notification.notification_for_visitors')) active @endif">
      <a data-toggle="collapse" href="#user">
        <i class="fas fa-users"></i>
        <p>Users Management</p>
        <span class="caret"></span>
      </a>

      <div id="user"
        class="collapse
              @if (request()->routeIs('admin.user_management.registered_users')) show
              @elseif (request()->routeIs('admin.user_management.registered_user.create')) show
              @elseif (request()->routeIs('admin.user_management.registered_user.edit')) show
              @elseif (request()->routeIs('admin.user_management.user.change_password')) show
              @elseif (request()->routeIs('admin.user_management.subscribers')) show
              @elseif (request()->routeIs('admin.user_management.mail_for_subscribers')) show
              @elseif (request()->routeIs('admin.user_management.push_notification.notification_for_visitors')) show @endif">
        <ul class="nav nav-collapse">
          <li
            class="@if (request()->routeIs('admin.user_management.registered_users')) active
                  @elseif (request()->routeIs('admin.user_management.user.change_password')) active
@elseif (request()->routeIs('admin.user_management.registered_user.edit'))
active @endif
                  ">
            <a href="{{ route('admin.user_management.registered_users') }}">
              <span class="sub-item">Registered Users</span>
            </a>
          </li>

          <li class="@if (request()->routeIs('admin.user_management.registered_user.create')) active @endif
                  ">
            <a href="{{ route('admin.user_management.registered_user.create') }}">
              <span class="sub-item">Add User</span>
            </a>
          </li>

          <li
            class="@if (request()->routeIs('admin.user_management.subscribers')) active
                  @elseif (request()->routeIs('admin.user_management.mail_for_subscribers')) active @endif">
            <a href="{{ route('admin.user_management.subscribers') }}">
              <span class="sub-item">Subscribers</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif

  {{-- vendor --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Vendors Management', $rolePermissions)))
    <li
      class="nav-item @if (request()->routeIs('admin.vendor_management.registered_vendor')) active
            @elseif (request()->routeIs('admin.vendor_management.add_vendor')) active
            @elseif (request()->routeIs('admin.vendor_management.vendor_details')) active
            @elseif (request()->routeIs('admin.edit_management.vendor_edit')) active
            @elseif (request()->routeIs('admin.edit_management.balance')) active
            @elseif (request()->routeIs('admin.vendor_management.settings')) active
            @elseif (request()->routeIs('admin.vendor_management.vendor.change_password')) active @endif">
      <a data-toggle="collapse" href="#vendor">
        <i class="la flaticon-users"></i>
        <p>Vendors Management</p>
        <span class="caret"></span>
      </a>

      <div id="vendor"
        class="collapse
              @if (request()->routeIs('admin.vendor_management.registered_vendor')) show
              @elseif (request()->routeIs('admin.vendor_management.vendor_details')) show
              @elseif (request()->routeIs('admin.edit_management.vendor_edit')) show
              @elseif (request()->routeIs('admin.vendor_management.add_vendor')) show
              @elseif (request()->routeIs('admin.edit_management.balance')) show
              @elseif (request()->routeIs('admin.vendor_management.settings')) show
              @elseif (request()->routeIs('admin.vendor_management.vendor.change_password')) show @endif">
        <ul class="nav nav-collapse">
          <li class="@if (request()->routeIs('admin.vendor_management.settings')) active @endif">
            <a href="{{ route('admin.vendor_management.settings') }}">
              <span class="sub-item">Settings</span>
            </a>
          </li>
          <li
            class="@if (request()->routeIs('admin.vendor_management.registered_vendor')) active
                  @elseif (request()->routeIs('admin.vendor_management.vendor_details')) active
                  @elseif (request()->routeIs('admin.edit_management.vendor_edit')) active
                  @elseif (request()->routeIs('admin.edit_management.balance')) active
                  @elseif (request()->routeIs('admin.vendor_management.vendor.change_password')) active @endif">
            <a href="{{ route('admin.vendor_management.registered_vendor') }}">
              <span class="sub-item">Registered vendors</span>
            </a>
          </li>
          <li class="@if (request()->routeIs('admin.vendor_management.add_vendor')) active @endif">
            <a href="{{ route('admin.vendor_management.add_vendor') }}">
              <span class="sub-item">Add vendor</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif


  {{-- website Pages --}}
  @if (is_null($roleInfo) ||
          (!empty($rolePermissions) &&
              array_intersect(
                  [
                      'Home Page',
                      'About Us',
                      'FAQs',
                      'Blog',
                      'Contact Page',
                      'Additional Pages',
                      'Footer',
                      'Breadcrumbs',
                      'SEO Informations',
                  ],
                  $rolePermissions)))
    <li
      class="nav-item
            @if (request()->routeIs('admin.home_page.section_content')) active
            @elseif (request()->routeIs('admin.home_page.about_section')) active
            @elseif (request()->routeIs('admin.home_page.banners')) active
            @elseif (request()->routeIs('admin.home_page.work_process_section')) active
            @elseif (request()->routeIs('admin.home_page.counter_section')) active
            @elseif (request()->routeIs('admin.home_page.testimonial_section')) active
            @elseif (request()->routeIs('admin.home_page.product_section')) active
            @elseif (request()->routeIs('admin.home_page.section_customization')) active
            @elseif (request()->routeIs('admin.home_page.partners')) active
            @elseif (request()->routeIs('admin.faq_management')) active
            @elseif (request()->routeIs('admin.about_us.index')) active
            @elseif (request()->routeIs('admin.blog_management.categories')) active
            @elseif (request()->routeIs('admin.blog_management.blogs')) active
            @elseif (request()->routeIs('admin.blog_management.create_blog')) active
            @elseif (request()->routeIs('admin.blog_management.edit_blog')) active
            @elseif (request()->routeIs('admin.footer.logo_and_image')) active
            @elseif (request()->routeIs('admin.footer.content')) active
            @elseif (request()->routeIs('admin.footer.quick_links')) active
            @elseif (request()->routeIs('admin.basic_settings.seo')) active
            @elseif (request()->routeIs('admin.basic_settings.breadcrumb')) active
            @elseif (request()->routeIs('admin.basic_settings.page_headings')) active
            @elseif (request()->routeIs('admin.custom_pages')) active
            @elseif (request()->routeIs('admin.custom_pages.create_page')) active
            @elseif (request()->routeIs('admin.custom_pages.edit_page')) active
            @elseif (request()->routeIs('admin.about_us.testimonial_section')) active
            @elseif (request()->routeIs('admin.about_us.customize')) active
            @elseif (request()->routeIs('admin.additional_sections')) active
            @elseif (request()->routeIs('admin.additional_section.create')) active
            @elseif (request()->routeIs('admin.additional_section.edit')) active
            @elseif (request()->routeIs('admin.home.additional_sections')) active
            @elseif (request()->routeIs('admin.home.additional_section.create')) active
            @elseif (request()->routeIs('admin.home.additional_section.edit')) active
            @elseif (request()->routeIs('admin.basic_settings.contact_page')) active @endif">
      <a data-toggle="collapse" href="#pages">
        <i class="la flaticon-file"></i>
        <p>Pages</p>
        <span class="caret"></span>
      </a>

      <div id="pages"
        class="collapse

            @if (request()->routeIs('admin.home_page.section_content')) show
            @elseif (request()->routeIs('admin.home_page.about_section')) show
            @elseif (request()->routeIs('admin.home_page.banners')) show
            @elseif (request()->routeIs('admin.home_page.work_process_section')) show
            @elseif (request()->routeIs('admin.home_page.counter_section')) show
            @elseif (request()->routeIs('admin.home_page.testimonial_section')) show
            @elseif (request()->routeIs('admin.home_page.product_section')) show
            @elseif (request()->routeIs('admin.home_page.section_customization')) show
            @elseif (request()->routeIs('admin.home_page.partners')) show
            @elseif (request()->routeIs('admin.faq_management')) show
            @elseif (request()->routeIs('admin.about_us.index')) show
            @elseif (request()->routeIs('admin.blog_management.categories')) show
            @elseif (request()->routeIs('admin.blog_management.blogs')) show
            @elseif (request()->routeIs('admin.blog_management.create_blog')) show
            @elseif (request()->routeIs('admin.blog_management.edit_blog')) show
            @elseif (request()->routeIs('admin.footer.logo_and_image')) show
            @elseif (request()->routeIs('admin.footer.content')) show
            @elseif (request()->routeIs('admin.footer.quick_links')) show
            @elseif (request()->routeIs('admin.basic_settings.seo')) show
            @elseif (request()->routeIs('admin.basic_settings.breadcrumb')) show
            @elseif (request()->routeIs('admin.basic_settings.page_headings')) show
            @elseif (request()->routeIs('admin.custom_pages')) show
            @elseif (request()->routeIs('admin.custom_pages.create_page')) show
            @elseif (request()->routeIs('admin.custom_pages.edit_page')) show
            @elseif (request()->routeIs('admin.about_us.testimonial_section')) show
            @elseif (request()->routeIs('admin.about_us.customize')) show
            @elseif (request()->routeIs('admin.additional_sections')) show
            @elseif (request()->routeIs('admin.additional_section.create')) show
            @elseif (request()->routeIs('admin.additional_section.edit')) show
            @elseif (request()->routeIs('admin.home.additional_sections')) show
            @elseif (request()->routeIs('admin.home.additional_section.create')) show
            @elseif (request()->routeIs('admin.home.additional_section.edit')) show
            @elseif (request()->routeIs('admin.basic_settings.contact_page')) show @endif">
        <ul class="nav nav-collapse">
          {{-- Home page --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Home Page', $rolePermissions)))
            <li class="submenu">
              <a data-toggle="collapse" href="#home-page"
                aria-expanded="{{ request()->routeIs('admin.home_page.section_content') ||
                request()->routeIs('admin.home_page.about_section') ||
                request()->routeIs('admin.home_page.banners') ||
                request()->routeIs('admin.home_page.counter_section') ||
                request()->routeIs('admin.home_page.product_section') ||
                request()->routeIs('admin.home.additional_sections') ||
                request()->routeIs('admin.home.additional_section.edit') ||
                request()->routeIs('admin.home.additional_section.create') ||
                request()->routeIs('admin.home_page.section_customization') ||
                request()->routeIs('admin.home_page.partners')
                    ? 'true'
                    : 'false' }}">
                <span class="sub-item">Home Page</span>
                <span class="caret"></span>
              </a>
              <div id="home-page"
                class="collapse
                    @if (request()->routeIs('admin.home_page.section_content') ||
                            request()->routeIs('admin.home_page.about_section') ||
                            request()->routeIs('admin.home_page.banners') ||
                            request()->routeIs('admin.home_page.counter_section') ||
                            request()->routeIs('admin.home_page.product_section') ||
                            request()->routeIs('admin.home_page.section_customization') ||
                            request()->routeIs('admin.home_page.partners') ||
                            request()->routeIs('admin.shop_management.create_product') ||
                            request()->routeIs('admin.home.additional_sections') ||
                            request()->routeIs('admin.home.additional_section.edit') ||
                            request()->routeIs('admin.home.additional_section.create') ||
                            request()->routeIs('admin.shop_management.edit_product')) show @endif">
                <ul class="nav nav-collapse subnav">
                  <li class="{{ request()->routeIs('admin.home_page.section_content') ? 'active' : '' }}">
                    <a href="{{ route('admin.home_page.section_content', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">Images & Texts</span>
                    </a>
                  </li>
                  <!-- additional sections -->
                  <li class="submenu">
                    <a data-toggle="collapse" href="#hoem-addi-section"
                      aria-expanded="{{ request()->routeIs('admin.home.additional_sections') ||
                      request()->routeIs('admin.home.additional_section.create') ||
                      request()->routeIs('admin.home.additional_section.edit')
                          ? 'true'
                          : 'false' }}">
                      <span class="sub-item">Additional Sections</span>
                      <span class="caret"></span>
                    </a>
                    <div id="hoem-addi-section"
                      class="collapse
                    @if (request()->routeIs('admin.home.additional_sections') ||
                            request()->routeIs('admin.home.additional_section.create') ||
                            request()->routeIs('admin.home.additional_section.edit')) show @endif pl-3">
                      <ul class="nav nav-collapse subnav">
                        <li class="{{ request()->routeIs('admin.home.additional_section.create') ? 'active' : '' }}">
                          <a href="{{ route('admin.home.additional_section.create') }}">
                            <span class="sub-item">Add Section</span>
                          </a>
                        </li>
                        <li
                          class="{{ request()->routeIs('admin.home.additional_sections') || request()->routeIs('admin.home.additional_section.edit') ? 'active' : '' }}">
                          <a href="{{ route('admin.home.additional_sections', ['language' => $defaultLang->code]) }}">
                            <span class="sub-item">Sections
                            </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>
                  @if ($settings->theme_version == 2 || $settings->theme_version == 3)
                    <li class="{{ request()->routeIs('admin.home_page.banners') ? 'active' : '' }}">
                      <a href="{{ route('admin.home_page.banners', ['language' => $defaultLang->code]) }}">
                        <span class="sub-item">Banner Section</span>
                      </a>
                    </li>
                  @endif

                  <li class="{{ request()->routeIs('admin.home_page.section_customization') ? 'active' : '' }}">
                    <a href="{{ route('admin.home_page.section_customization') }}">
                      <span class="sub-item">Section Show/Hide</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          {{-- About page --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('About Us', $rolePermissions)))
            <li class="submenu">
              <a data-toggle="collapse" href="#about-page"
                aria-expanded="{{ request()->routeIs('admin.about_us.index') ||
                request()->routeIs('admin.about_us.customize') ||
                request()->routeIs('admin.additional_sections') ||
                request()->routeIs('admin.additional_section.create') ||
                request()->routeIs('admin.additional_section.edit') ||
                request()->routeIs('admin.about_us.testimonial_section')
                    ? 'true'
                    : 'false' }}">
                <span class="sub-item">About Us</span>
                <span class="caret"></span>
              </a>
              <div id="about-page"
                class="collapse
                    @if (request()->routeIs('admin.about_us.index') ||
                            request()->routeIs('admin.about_us.customize') ||
                            request()->routeIs('admin.additional_sections') ||
                            request()->routeIs('admin.additional_section.create') ||
                            request()->routeIs('admin.additional_section.edit') ||
                            request()->routeIs('admin.about_us.testimonial_section')) show @endif">
                <ul class="nav nav-collapse subnav">
                  <li class="{{ request()->routeIs('admin.about_us.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.about_us.index', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">About</span>
                    </a>
                  </li>
                  @if ($settings->theme_version != 1)
                    <li class="{{ request()->routeIs('admin.about_us.testimonial_section') ? 'active' : '' }}">
                      <a href="{{ route('admin.about_us.testimonial_section', ['language' => $defaultLang->code]) }}">
                        <span class="sub-item">Testimonial Section</span>
                      </a>
                    </li>
                  @endif
                  <!-- additional sections -->
                  <li class="submenu">
                    <a data-toggle="collapse" href="#addi-section"
                      aria-expanded="{{ request()->routeIs('admin.additional_sections') ||
                      request()->routeIs('admin.additional_section.create') ||
                      request()->routeIs('admin.additional_section.edit')
                          ? 'true'
                          : 'false' }}">
                      <span class="sub-item">Additional Sections</span>
                      <span class="caret"></span>
                    </a>
                    <div id="addi-section"
                      class="collapse
                    @if (request()->routeIs('admin.additional_sections') ||
                            request()->routeIs('admin.additional_section.create') ||
                            request()->routeIs('admin.additional_section.edit')) show @endif pl-3">
                      <ul class="nav nav-collapse subnav">
                        <li class="{{ request()->routeIs('admin.additional_section.create') ? 'active' : '' }}">
                          <a href="{{ route('admin.additional_section.create') }}">
                            <span class="sub-item">Add Section</span>
                          </a>
                        </li>
                        <li
                          class="{{ request()->routeIs('admin.additional_sections') || request()->routeIs('admin.additional_section.edit') ? 'active' : '' }}">
                          <a href="{{ route('admin.additional_sections', ['language' => $defaultLang->code]) }}">
                            <span class="sub-item">Sections
                            </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </li>

                  <li class="{{ request()->routeIs('admin.about_us.customize') ? 'active' : '' }}">
                    <a href="{{ route('admin.about_us.customize') }}">
                      <span class="sub-item">Hide / Show Section
                      </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          <li class="{{ request()->routeIs('admin.home_page.work_process_section') ? 'active' : '' }}">
            <a href="{{ route('admin.home_page.work_process_section', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Work Process</span>
            </a>
          </li>
          @if ($settings->theme_version == 1)
            <li class="{{ request()->routeIs('admin.home_page.testimonial_section') ? 'active' : '' }}">
              <a href="{{ route('admin.home_page.testimonial_section', ['language' => $defaultLang->code]) }}">
                <span class="sub-item">Testimonials</span>
              </a>
            </li>
          @endif
          {{-- faq --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('FAQs', $rolePermissions)))
            <li class="{{ request()->routeIs('admin.faq_management') ? 'active' : '' }}">
              <a href="{{ route('admin.faq_management', ['language' => $defaultLang->code]) }}">
                <span class="sub-item">FAQs</span>
              </a>
            </li>
          @endif
          {{-- Blog page --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Blog', $rolePermissions)))
            <li class="submenu">
              <a data-toggle="collapse" href="#blog-page"
                aria-expanded="{{ request()->routeIs('admin.blog_management.categories') ||
                request()->routeIs('admin.blog_management.blogs') ||
                request()->routeIs('admin.blog_management.create_blog') ||
                request()->routeIs('admin.blog_management.edit_blog')
                    ? 'true'
                    : 'false' }}">
                <span class="sub-item">Blog</span>
                <span class="caret"></span>
              </a>
              <div id="blog-page"
                class="collapse
                    @if (request()->routeIs('admin.blog_management.categories') ||
                            request()->routeIs('admin.blog_management.create_blog') ||
                            request()->routeIs('admin.blog_management.edit_blog') ||
                            request()->routeIs('admin.blog_management.blogs')) show @endif">
                <ul class="nav nav-collapse subnav">
                  <li class="{{ request()->routeIs('admin.blog_management.categories') ? 'active' : '' }}">
                    <a href="{{ route('admin.blog_management.categories', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">Categories</span>
                    </a>
                  </li>

                  <li
                    class="{{ request()->routeIs('admin.blog_management.blogs') || request()->routeIs('admin.blog_management.create_blog') || request()->routeIs('admin.blog_management.edit_blog') ? 'active' : '' }}">
                    <a href="{{ route('admin.blog_management.blogs', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">Posts</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          {{-- contact us page --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Contact Page', $rolePermissions)))
            <li class="{{ request()->routeIs('admin.basic_settings.contact_page') ? 'active' : '' }}">
              <a href="{{ route('admin.basic_settings.contact_page') }}">
                <span class="sub-item">Contact Page</span>
              </a>
            </li>
          @endif
          {{-- Additional Pages --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Additional Pages', $rolePermissions)))
            <li class="submenu">
              <a data-toggle="collapse" href="#Additional-page"
                aria-expanded="{{ request()->routeIs('admin.custom_pages') ||
                request()->routeIs('admin.custom_pages.create_page') ||
                request()->routeIs('admin.custom_pages.edit_page')
                    ? 'true'
                    : 'false' }}">
                <span class="sub-item">Additional Pages</span>
                <span class="caret"></span>
              </a>
              <div id="Additional-page"
                class="collapse
                    @if (request()->routeIs('admin.custom_pages') ||
                            request()->routeIs('admin.custom_pages.create_page') ||
                            request()->routeIs('admin.custom_pages.edit_page')) show @endif">
                <ul class="nav nav-collapse subnav">
                  <li
                    class="{{ request()->routeIs('admin.custom_pages') || request()->routeIs('admin.custom_pages.edit_page') ? 'active' : '' }}">
                    <a href="{{ route('admin.custom_pages', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">All Pages</span>
                    </a>
                  </li>

                  <li class="{{ request()->routeIs('admin.custom_pages.create_page') ? 'active' : '' }}">
                    <a href="{{ route('admin.custom_pages.create_page') }}">
                      <span class="sub-item">Add Page</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          {{-- Footer page --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Footer', $rolePermissions)))
            <li class="submenu">
              <a data-toggle="collapse" href="#footer-page"
                aria-expanded="{{ request()->routeIs('admin.footer.logo_and_image') ||
                request()->routeIs('admin.footer.content') ||
                request()->routeIs('admin.footer.quick_links')
                    ? 'true'
                    : 'false' }}">
                <span class="sub-item">Footer</span>
                <span class="caret"></span>
              </a>
              <div id="footer-page"
                class="collapse
                    @if (request()->routeIs('admin.footer.logo_and_image')) show
                    @elseif (request()->routeIs('admin.footer.content')) show
                    @elseif (request()->routeIs('admin.footer.quick_links')) show @endif">
                <ul class="nav nav-collapse subnav">
                  <li class="{{ request()->routeIs('admin.footer.logo_and_image') ? 'active' : '' }}">
                    <a href="{{ route('admin.footer.logo_and_image') }}">
                      <span class="sub-item">Logo</span>
                    </a>
                  </li>

                  <li class="{{ request()->routeIs('admin.footer.content') ? 'active' : '' }}">
                    <a href="{{ route('admin.footer.content', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">Content</span>
                    </a>
                  </li>
                  <li class="{{ request()->routeIs('admin.footer.quick_links') ? 'active' : '' }}">
                    <a href="{{ route('admin.footer.quick_links', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">Quick Links</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          {{-- Breadcrumb --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Breadcrumbs', $rolePermissions)))
            <li class="submenu">
              <a data-toggle="collapse" href="#breadcrumb"
                aria-expanded="{{ request()->routeIs('admin.basic_settings.breadcrumb') ||
                request()->routeIs('admin.basic_settings.page_headings')
                    ? 'true'
                    : 'false' }}">
                <span class="sub-item">Breadcrumbs</span>
                <span class="caret"></span>
              </a>
              <div id="breadcrumb"
                class="collapse
                    @if (request()->routeIs('admin.basic_settings.breadcrumb') || request()->routeIs('admin.basic_settings.page_headings')) show @endif">
                <ul class="nav nav-collapse subnav">
                  <li class="{{ request()->routeIs('admin.basic_settings.breadcrumb') ? 'active' : '' }}">
                    <a href="{{ route('admin.basic_settings.breadcrumb') }}">
                      <span class="sub-item">Image</span>
                    </a>
                  </li>

                  <li class="{{ request()->routeIs('admin.basic_settings.page_headings') ? 'active' : '' }}">
                    <a href="{{ route('admin.basic_settings.page_headings', ['language' => $defaultLang->code]) }}">
                      <span class="sub-item">Headings</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          @endif
          {{-- seo --}}
          @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('SEO Informations', $rolePermissions)))
            <li class="{{ request()->routeIs('admin.basic_settings.seo') ? 'active' : '' }}">
              <a href="{{ route('admin.basic_settings.seo', ['language' => $defaultLang->code]) }}">
                <span class="sub-item">SEO Informations</span>
              </a>
            </li>
          @endif
        </ul>

      </div>
    </li>
  @endif

  {{-- Support Tickets --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Support Tickets', $rolePermissions)))
    <li
      class="nav-item
              @if (request()->routeIs('admin.support_ticket.setting')) active
            @elseif (request()->routeIs('admin.support_tickets')) active
            @elseif (request()->routeIs('admin.support_tickets.message')) active active
            @elseif (request()->routeIs('admin.user_management.push_notification.notification_for_visitors')) active @endif">
      <a data-toggle="collapse" href="#support_ticket">
        <i class="la flaticon-web-1"></i>
        <p>Support Tickets</p>
        <span class="caret"></span>
      </a>

      <div id="support_ticket"
        class="collapse
              @if (request()->routeIs('admin.support_ticket.setting')) show
              @elseif (request()->routeIs('admin.support_tickets')) show
              @elseif (request()->routeIs('admin.support_tickets.message')) show
              @elseif (request()->routeIs('admin.support_tickets.message')) show @endif">
        <ul class="nav nav-collapse">
          <li class="@if (request()->routeIs('admin.support_ticket.setting')) active @endif">
            <a href="{{ route('admin.support_ticket.setting') }}">
              <span class="sub-item">Setting</span>
            </a>
          </li>
          <li
            class="@if (request()->routeIs('admin.support_tickets') && empty(request()->input('status'))) active
                  @elseif(request()->routeIs('admin.support_tickets.message')) active @endif">
            <a href="{{ route('admin.support_tickets') }}">
              <span class="sub-item">All Tickets</span>
            </a>
          </li>
          <li
            class="{{ request()->routeIs('admin.support_tickets') && request()->input('status') == 1 ? 'active' : '' }}">
            <a href="{{ route('admin.support_tickets', ['status' => 1]) }}">
              <span class="sub-item">Pending Tickets</span>
            </a>
          </li>
          <li
            class="{{ request()->routeIs('admin.support_tickets') && request()->input('status') == 2 ? 'active' : '' }}">
            <a href="{{ route('admin.support_tickets', ['status' => 2]) }}">
              <span class="sub-item">Open Tickets</span>
            </a>
          </li>
          <li
            class="{{ request()->routeIs('admin.support_tickets') && request()->input('status') == 3 ? 'active' : '' }}">
            <a href="{{ route('admin.support_tickets', ['status' => 3]) }}">
              <span class="sub-item">Closed Tickets</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif

  {{-- advertise --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Advertise', $rolePermissions)))
    <li
      class="nav-item @if (request()->routeIs('admin.advertise.settings')) active
            @elseif (request()->routeIs('admin.advertise.all_advertisement')) active @endif">
      <a data-toggle="collapse" href="#customid">
        <i class="fab fa-buysellads"></i>
        <p>Advertisements</p>
        <span class="caret"></span>
      </a>

      <div id="customid"
        class="collapse @if (request()->routeIs('admin.advertise.settings')) show
              @elseif (request()->routeIs('admin.advertise.all_advertisement')) show @endif">
        <ul class="nav nav-collapse">
          <li class="{{ request()->routeIs('admin.advertise.settings') ? 'active' : '' }}">
            <a href="{{ route('admin.advertise.settings') }}">
              <span class="sub-item">Settings</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.advertise.all_advertisement') ? 'active' : '' }}">
            <a href="{{ route('admin.advertise.all_advertisement') }}">
              <span class="sub-item">All Advertisements</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif

  {{-- announcement popup --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Announcement Popups', $rolePermissions)))
    <li
      class="nav-item @if (request()->routeIs('admin.announcement_popups')) active
            @elseif (request()->routeIs('admin.announcement_popups.select_popup_type')) active
            @elseif (request()->routeIs('admin.announcement_popups.create_popup')) active
            @elseif (request()->routeIs('admin.announcement_popups.edit_popup')) active @endif">
      <a href="{{ route('admin.announcement_popups', ['language' => $defaultLang->code]) }}">
        <i class="fal fa-bullhorn"></i>
        <p>Announcement Popups</p>
      </a>
    </li>
  @endif


  {{-- basic settings --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Basic Settings', $rolePermissions)))
    <li
      class="nav-item
            @if (request()->routeIs('admin.basic_settings.mail_from_admin')) active
            @elseif (request()->routeIs('admin.basic_settings.mail_to_admin')) active
            @elseif (request()->routeIs('admin.basic_settings.mail_templates')) active
            @elseif (request()->routeIs('admin.basic_settings.edit_mail_template')) active
            @elseif (request()->routeIs('admin.basic_settings.plugins')) active
            @elseif (request()->routeIs('admin.basic_settings.maintenance_mode')) active
            @elseif (request()->routeIs('admin.basic_settings.general_settings')) active
            @elseif (request()->routeIs('admin.basic_settings.cookie_alert')) active
              @elseif (request()->routeIs('admin.language_management')) active
              @elseif (request()->routeIs('admin.language_management.edit_keyword')) active
                  @elseif (request()->routeIs('admin.payment_gateways.online_gateways')) active
              @elseif (request()->routeIs('admin.payment_gateways.offline_gateways')) active
            @elseif (request()->routeIs('admin.basic_settings.social_medias')) active @endif
            ">
      <a data-toggle="collapse" href="#basic_settings">
        <i class="la flaticon-settings"></i>
        <p>Settings</p>
        <span class="caret"></span>
      </a>

      <div id="basic_settings"
        class="collapse
              @if (request()->routeIs('admin.basic_settings.mail_from_admin')) show
              @elseif (request()->routeIs('admin.basic_settings.mail_to_admin')) show
              @elseif (request()->routeIs('admin.basic_settings.mail_templates')) show
              @elseif (request()->routeIs('admin.basic_settings.edit_mail_template')) show
              @elseif (request()->routeIs('admin.basic_settings.plugins')) show
              @elseif (request()->routeIs('admin.basic_settings.maintenance_mode')) show
              @elseif (request()->routeIs('admin.basic_settings.cookie_alert')) show
              @elseif (request()->routeIs('admin.basic_settings.general_settings')) show
              @elseif (request()->routeIs('admin.language_management')) show
              @elseif (request()->routeIs('admin.language_management.edit_keyword')) show
              @elseif (request()->routeIs('admin.payment_gateways.online_gateways')) show
              @elseif (request()->routeIs('admin.payment_gateways.offline_gateways')) show
              @elseif (request()->routeIs('admin.basic_settings.social_medias')) show @endif
              ">
        <ul class="nav nav-collapse">
          <li class="{{ request()->routeIs('admin.basic_settings.general_settings') ? 'active' : '' }}">
            <a href="{{ route('admin.basic_settings.general_settings') }}">
              <span class="sub-item">General Settings</span>
            </a>
          </li>

          <li class="submenu">
            <a data-toggle="collapse" href="#mail-settings"
              aria-expanded="{{ request()->routeIs('admin.basic_settings.mail_to_admin') || request()->routeIs('admin.basic_settings.mail_from_admin') || request()->routeIs('admin.basic_settings.mail_templates') || request()->routeIs('admin.basic_settings.edit_mail_template') ? 'true' : 'false' }}">
              <span class="sub-item">Email Settings</span>
              <span class="caret"></span>
            </a>

            <div id="mail-settings"
              class="collapse
                    @if (request()->routeIs('admin.basic_settings.mail_from_admin')) show
                    @elseif (request()->routeIs('admin.basic_settings.mail_to_admin')) show
                    @elseif (request()->routeIs('admin.basic_settings.mail_templates')) show
                    @elseif (request()->routeIs('admin.basic_settings.edit_mail_template')) show @endif">
              <ul class="nav nav-collapse subnav">
                <li class="{{ request()->routeIs('admin.basic_settings.mail_from_admin') ? 'active' : '' }}">
                  <a href="{{ route('admin.basic_settings.mail_from_admin') }}">
                    <span class="sub-item">Mail From Admin</span>
                  </a>
                </li>

                <li class="{{ request()->routeIs('admin.basic_settings.mail_to_admin') ? 'active' : '' }}">
                  <a href="{{ route('admin.basic_settings.mail_to_admin') }}">
                    <span class="sub-item">Mail To Admin</span>
                  </a>
                </li>

                <li
                  class="@if (request()->routeIs('admin.basic_settings.mail_templates')) active
                        @elseif (request()->routeIs('admin.basic_settings.edit_mail_template')) active @endif">
                  <a href="{{ route('admin.basic_settings.mail_templates') }}">
                    <span class="sub-item">Mail Templates</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          {{-- payment method --}}
          <li class="submenu">
            <a data-toggle="collapse" href="#payment-gateway"
              aria-expanded="{{ request()->routeIs('admin.payment_gateways.online_gateways') || request()->routeIs('admin.payment_gateways.offline_gateways') ? 'true' : 'false' }}">
              <span class="sub-item">Payment Gateways</span>
              <span class="caret"></span>
            </a>

            <div id="payment-gateway"
              class="collapse
                    @if (request()->routeIs('admin.payment_gateways.online_gateways')) show
                    @elseif (request()->routeIs('admin.payment_gateways.offline_gateways')) show @endif">
              <ul class="nav nav-collapse subnav">
                <li class="{{ request()->routeIs('admin.payment_gateways.online_gateways') ? 'active' : '' }}">
                  <a href="{{ route('admin.payment_gateways.online_gateways') }}">
                    <span class="sub-item">Online Gateways</span>
                  </a>
                </li>

                <li class="{{ request()->routeIs('admin.payment_gateways.offline_gateways') ? 'active' : '' }}">
                  <a href="{{ route('admin.payment_gateways.offline_gateways') }}">
                    <span class="sub-item">Offline Gateways</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          {{-- languages --}}
          <li
            class="@if (request()->routeIs('admin.language_management')) active
            @elseif (request()->routeIs('admin.language_management.edit_keyword')) active @endif">
            <a href="{{ route('admin.language_management') }}">
              <span class="sub-item">Languages</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.basic_settings.plugins') ? 'active' : '' }}">
            <a href="{{ route('admin.basic_settings.plugins') }}">
              <span class="sub-item">Plugins</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.basic_settings.maintenance_mode') ? 'active' : '' }}">
            <a href="{{ route('admin.basic_settings.maintenance_mode') }}">
              <span class="sub-item">Maintenance Mode</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.basic_settings.cookie_alert') ? 'active' : '' }}">
            <a href="{{ route('admin.basic_settings.cookie_alert', ['language' => $defaultLang->code]) }}">
              <span class="sub-item">Cookie Alert</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.basic_settings.social_medias') ? 'active' : '' }}">
            <a href="{{ route('admin.basic_settings.social_medias') }}">
              <span class="sub-item">Social Medias</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif

  {{-- admin --}}
  @if (is_null($roleInfo) || (!empty($rolePermissions) && in_array('Admin Management', $rolePermissions)))
    <li
      class="nav-item @if (request()->routeIs('admin.admin_management.role_permissions')) active
            @elseif (request()->routeIs('admin.admin_management.role.permissions')) active
            @elseif (request()->routeIs('admin.admin_management.registered_admins')) active @endif">
      <a data-toggle="collapse" href="#admin">
        <i class="fal fa-users-cog"></i>
        <p>Admin Management</p>
        <span class="caret"></span>
      </a>

      <div id="admin"
        class="collapse
              @if (request()->routeIs('admin.admin_management.role_permissions')) show
              @elseif (request()->routeIs('admin.admin_management.role.permissions')) show
              @elseif (request()->routeIs('admin.admin_management.registered_admins')) show @endif">
        <ul class="nav nav-collapse">
          <li
            class="@if (request()->routeIs('admin.admin_management.role_permissions')) active
                  @elseif (request()->routeIs('admin.admin_management.role.permissions')) active @endif">
            <a href="{{ route('admin.admin_management.role_permissions') }}">
              <span class="sub-item">Role & Permissions</span>
            </a>
          </li>

          <li class="{{ request()->routeIs('admin.admin_management.registered_admins') ? 'active' : '' }}">
            <a href="{{ route('admin.admin_management.registered_admins') }}">
              <span class="sub-item">Registered Admins</span>
            </a>
          </li>
        </ul>
      </div>
    </li>
  @endif
  </ul>
</div>
</div>
</div>
