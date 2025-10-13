@php
  $permission = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
@endphp
<div class="sidebar sidebar-style-2"
  data-background-color="{{ Session::get('vendor_theme_version') == 'light' ? 'white' : 'dark2' }}">
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          @if (Auth::guard('vendor')->user()->photo != null)
            <img src="{{ asset('assets/admin/img/vendor-photo/' . Auth::guard('vendor')->user()->photo) }}"
              alt="Vendor Image" class="avatar-img rounded-circle">
          @else
            <img src="{{ asset('assets/img/blank-user.jpg') }}" alt="" class="avatar-img rounded-circle">
          @endif
        </div>

        <div class="info">
          <a data-toggle="collapse" href="#vendorProfileMenu" aria-expanded="true">
            <span>
              {{ Auth::guard('vendor')->user()->username }}
              <span class="user-level">Vendor</span>
              <span class="caret"></span>
            </span>
          </a>

          <div class="clearfix"></div>

          <div class="collapse in" id="vendorProfileMenu">
            <ul class="nav">
              <li>
                <a href="{{ route('vendor.edit.profile') }}">
                  <span class="link-collapse">Edit Profile</span>
                </a>
              </li>

              <li>
                <a href="{{ route('vendor.change_password') }}">
                  <span class="link-collapse">Change Password</span>
                </a>
              </li>

              <li>
                <a href="{{ route('vendor.logout') }}">
                  <span class="link-collapse">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>


      <ul class="nav nav-primary">
        {{-- search --}}
        <div class="row mb-3">
          <div class="col-12">
            <form>
              <div class="form-group py-0">
                <input name="term" type="text" class="form-control sidebar-search ltr"
                  placeholder="Search Menu Here...">
              </div>
            </form>
          </div>
        </div>

        {{-- dashboard --}}
        <li class="nav-item @if (request()->routeIs('vendor.dashboard')) active @endif">
          <a href="{{ route('vendor.dashboard') }}">
            <i class="la flaticon-paint-palette"></i>
            <p>Dashboard</p>
          </a>
        </li>

        {{-- services & categories managment --}}
        <li
          class="nav-item
          @if (request()->routeIs('vendor.service_managment')) active @endif
          @if (request()->routeIs('vendor.service_managment.create')) active @endif
          @if (request()->routeIs('featured.service.online.success.page')) active @endif
          @if (request()->routeIs('featured.service.offline.success.page')) active @endif
          @if (request()->routeIs('vendor.service_managment.edit')) active @endif">
          <a data-toggle="collapse" href="#services">
            <i class="fas fa-wrench"></i>
            <p>Service Managment</p>
            <span class="caret"></span>
          </a>

          <div id="services"
            class="collapse
               @if (request()->routeIs('vendor.service_managment')) show @endif
               @if (request()->routeIs('vendor.service_managment.create')) show @endif
               @if (request()->routeIs('featured.service.online.success.page')) show @endif
               @if (request()->routeIs('featured.service.offline.success.page')) show @endif
               @if (request()->routeIs('vendor.service_managment.edit')) show @endif">
            <ul class="nav nav-collapse">
              <li
                class="@if (request()->routeIs('vendor.service_managment')) active
                @elseif(request()->routeIs('featured.service.online.success.page')) active
                @elseif(request()->routeIs('featured.service.offline.success.page')) active
                        @elseif (request()->routeIs('vendor.service_managment.edit')) active @endif">
                <a href="{{ route('vendor.service_managment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Services</span>
                </a>
              </li>
              {{--
              <li class="@if (request()->routeIs('vendor.service_managment.create')) active @endif">
                <a href="{{ route('vendor.service_managment.create') }}">
                  <span class="sub-item">Add Service</span>
                </a>
              </li> --}}
            </ul>
          </div>
        </li>

        {{-- Staff  managment 
        <li
          class="nav-item
          @if (request()->routeIs('vendor.staff_managment')) active @endif
          @if (request()->routeIs('vendor.staff_managment.create')) active @endif
          @if (request()->routeIs('vendor.staff_managment.edit')) active @endif
          @if (request()->routeIs('vendor.staff_service_assign')) active @endif
          @if (request()->routeIs('vendor.staff.change_password')) active @endif
          @if (request()->routeIs('vendor.service.day')) active @endif
          @if (request()->routeIs('vendor.staff.permission')) active @endif
          @if (request()->routeIs('vendor.time-slot.manage')) active @endif>
          @if (request()->routeIs('vendor.staff.holiday.index'))
active
@endif">
          <a data-toggle="collapse" href="#staff">
            <i class="fas fa-user"></i>
            <p>Staff Managment</p>
            <span class="caret"></span>
          </a>

          <div id="staff"
            class="collapse
               @if (request()->routeIs('vendor.staff_managment')) show @endif
               @if (request()->routeIs('vendor.staff_managment.create')) show @endif
              @if (request()->routeIs('vendor.staff_managment.edit')) show @endif
              @if (request()->routeIs('vendor.staff.change_password')) show @endif
              @if (request()->routeIs('vendor.staff_service_assign')) show @endif
              @if (request()->routeIs('vendor.service.day')) show @endif
              @if (request()->routeIs('vendor.staff.permission')) show @endif
              @if (request()->routeIs('vendor.time-slot.manage')) show @endif>
              @if (request()->routeIs('vendor.staff.holiday.index'))
show
@endif">
            <ul class="nav nav-collapse">
              <li
                class="
              @if (request()->routeIs('vendor.staff_managment')) active @endif
                @if (request()->routeIs('vendor.staff_managment.edit')) active @endif
                @if (request()->routeIs('vendor.staff_service_assign')) active @endif
                @if (request()->routeIs('vendor.service.day')) active @endif
                @if (request()->routeIs('vendor.staff.change_password')) active @endif
                @if (request()->routeIs('vendor.staff.permission')) active @endif
                @if (request()->routeIs('vendor.time-slot.manage')) active @endif>
                @if (request()->routeIs('vendor.staff.holiday.index'))
active
@endif">
                <a href="{{ route('vendor.staff_managment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Staff</span>
                </a>
              </li>
              <li class="@if (request()->routeIs('vendor.staff_managment.create')) active @endif">
                <a href="{{ route('vendor.staff_managment.create') }}">
                  <span class="sub-item">Add Staff</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        --}}
        {{-- Global Schedule 
        <li
          class="nav-item
        @if (request()->routeIs('vendor.staff.global.day')) active @endif
        @if (request()->routeIs('vendor.global.holiday')) active @endif
        @if (request()->routeIs('vendor.global.time-slot.manage')) active @endif">
          <a data-toggle="collapse" href="#time">
            <i class="fas fa-clock"></i>
            <p>Schedule</p>
            <span class="caret"></span>
          </a>

          <div id="time"
            class="collapse
          @if (request()->routeIs('vendor.staff.global.day')) show @endif
          @if (request()->routeIs('vendor.global.holiday')) show @endif
          @if (request()->routeIs('vendor.global.time-slot.manage')) show @endif">
            <ul class="nav nav-collapse">
              <li
                class="@if (request()->routeIs('vendor.staff.global.day')) active @endif
                @if (request()->routeIs('vendor.global.time-slot.manage')) active @endif">
                <a href="{{ route('vendor.staff.global.day') }}">
                  <span class="sub-item">Days</span>
                </a>
              </li>
              <li class="@if (request()->routeIs('vendor.global.holiday')) active @endif">
                <a href="{{ route('vendor.global.holiday') }}">
                  <span class="sub-item">Holidays</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        --}}
        {{-- appointment 
        <li
          class="nav-item
           @if (request()->routeIs('vendor.pending_appointment')) active @endif
           @if (request()->routeIs('vendor.accepted_appointment')) active @endif
           @if (request()->routeIs('vendor.appointment.details')) active @endif
           @if (request()->routeIs('vendor.rejected_appointment')) active @endif
           @if (request()->routeIs('vendor.appointment.details')) active @endif
           @if (request()->routeIs('vendor.all_appointment')) active @endif">
          <a data-toggle="collapse" href="#eventBooking">
            <i class="fal fa-calendar"></i>
            <p>Appointments</p>
            <span class="caret"></span>
          </a>

          <div id="eventBooking"
            class="collapse
                         @if (request()->routeIs('vendor.pending_appointment')) show @endif
           @if (request()->routeIs('vendor.accepted_appointment')) show @endif
           @if (request()->routeIs('vendor.rejected_appointment')) show @endif
           @if (request()->routeIs('vendor.appointment.details')) show @endif
              @if (request()->routeIs('vendor.all_appointment')) show @endif">
            <ul class="nav nav-collapse">
              <li
                class="
              @if (request()->routeIs('vendor.all_appointment')) active @endif
              @if (request()->routeIs('vendor.appointment.details')) active @endif
              ">
                <a href="{{ route('vendor.all_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">All Appointments</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('vendor.pending_appointment') ? 'active' : '' }}">
                <a href="{{ route('vendor.pending_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Pending Appointments</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('vendor.accepted_appointment') ? 'active' : '' }}">
                <a href="{{ route('vendor.accepted_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Accepted Appointments</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('vendor.rejected_appointment') ? 'active' : '' }}">
                <a href="{{ route('vendor.rejected_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Rejected Appointments</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        --}}
        {{-- service inquiry 
        <li class="nav-item @if (request()->routeIs('vendor.booking.inquiry')) active @endif">
          <a href="{{ route('vendor.booking.inquiry', ['language' => $defaultLang->code]) }}">
            <i class="fas fa-comment"></i>
            <p>Service Inquiry</p>
          </a>
        </li>--}}
        {{-- withdrawals 
        <li
          class="nav-item
          @if (request()->routeIs('vendor.withdraw')) active @endif
          @if (request()->routeIs('vendor.withdraw.create')) active @endif
          ">
          <a href="{{ route('vendor.withdraw') }}">
            <i class="fal fa-donate"></i>
            <p>Request Withdrawal</p>
          </a>
        </li>--}}

        {{-- transation 
        <li class="nav-item @if (request()->routeIs('vendor.transaction')) active @endif">
          <a href="{{ route('vendor.transaction') }}">
            <i class="fal fa-exchange-alt"></i>
            <p>Transactions</p>
          </a>
        </li>--}}

        {{-- recipitent mail 
        <li class="nav-item
          @if (request()->routeIs('vendor.email.index')) active @endif
          ">
          <a href="{{ route('vendor.email.index') }}">
            <i class="fas fa-envelope"></i>
            <p>Recipient Mail</p>
          </a>
        </li>--}}
        {{-- plugin 
        @if ($permission != '[]')
          @if ($permission->calendar_status == 1)
            <li class="nav-item
          @if (request()->routeIs('vendor.plugins.index')) active @endif
          ">
              <a href="{{ route('vendor.plugins.index') }}">
                <i class="fas fa-plug"></i>
                <p>Plugins</p>
              </a>
            </li>
          @endif
        @endif
        --}}
        {{-- dashboard 
        <li
          class="nav-item
        @if (request()->routeIs('vendor.plan.extend.index')) active
        @elseif (request()->routeIs('vendor.plan.extend.checkout')) active @endif">
          <a href="{{ route('vendor.plan.extend.index') }}">
            <i class="fal fa-lightbulb-dollar"></i>
            <p>Buy Plan</p>
          </a>
        </li>

        <li class="nav-item @if (request()->routeIs('vendor.subscription_log')) active @endif">
          <a href="{{ route('vendor.subscription_log') }}">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>Subscription Logs</p>
          </a>
        </li>
        --}}
        @if ($permission != '[]' && $permission->support_ticket_status == 1)
          {{-- Support Ticket 
          <li
            class="nav-item
                @if (request()->routeIs('vendor.support_tickets')) active
                @elseif (request()->routeIs('vendor.support_tickets.message')) active
                @elseif (request()->routeIs('vendor.support_ticket.create')) active @endif">
            <a data-toggle="collapse" href="#support_ticket">
              <i class="la flaticon-web-1"></i>
              <p>Support Tickets</p>
              <span class="caret"></span>
            </a>

            <div id="support_ticket"
              class="collapse
                    @if (request()->routeIs('vendor.support_tickets')) show
                    @elseif (request()->routeIs('vendor.support_tickets.message')) show
                    @elseif (request()->routeIs('vendor.support_ticket.create')) show @endif">
              <ul class="nav nav-collapse">
                <li
                  class="
@if (request()->routeIs('vendor.support_tickets') && empty(request()->input('status'))) active
                  @elseif(request()->routeIs('vendor.support_tickets.message')) active @endif
                  ">
                  <a href="{{ route('vendor.support_tickets') }}">
                    <span class="sub-item">All Tickets</span>
                  </a>
                </li>
                <li class="{{ request()->routeIs('vendor.support_ticket.create') ? 'active' : '' }}">
                  <a href="{{ route('vendor.support_ticket.create') }}">
                    <span class="sub-item">Add a Ticket</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        --}}
        @endif
        
        <li class="nav-item @if (request()->routeIs('vendor.edit.profile')) active @endif">
          <a href="{{ route('vendor.edit.profile') }}">
            <i class="fal fa-user-edit"></i>
            <p>Edit Profile</p>
          </a>
        </li>
        <li class="nav-item @if (request()->routeIs('vendor.change_password')) active @endif">
          <a href="{{ route('vendor.change_password') }}">
            <i class="fal fa-key"></i>
            <p>Change Password</p>
          </a>
        </li>

        <li class="nav-item @if (request()->routeIs('vendor.logout')) active @endif">
          <a href="{{ route('vendor.logout') }}">
            <i class="fal fa-sign-out"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
