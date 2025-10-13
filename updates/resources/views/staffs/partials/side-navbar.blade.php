@php
  $vendorId = App\Models\Staff\Staff::where('id', Auth::guard('staff')->user()->id)
      ->pluck('vendor_id')
      ->first();
  $packagePermission = [];
  if ($vendorId != 0) {
      $packagePermission = App\Http\Helpers\VendorPermissionHelper::packagePermission($vendorId);
  }
@endphp

<div class="sidebar sidebar-style-2"
  data-background-color="{{ Session::get('staff_theme_version') == 'light' ? 'white' : 'dark2' }}">
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          @if (Auth::guard('staff')->user()->image != null)
            <img src="{{ asset('assets/img/staff/' . Auth::guard('staff')->user()->image) }}" alt="Vendor Image"
              class="avatar-img rounded-circle">
          @else
            <img src="{{ asset('assets/img/blank-user.jpg') }}" alt="" class="avatar-img rounded-circle">
          @endif
        </div>

        <div class="info">
          <a data-toggle="collapse" href="#vendorProfileMenu" aria-expanded="true">
            <span>
              {{ Auth::guard('staff')->user()->username }}
              <span class="user-level">Staff</span>
              <span class="caret"></span>
            </span>
          </a>

          <div class="clearfix"></div>

          <div class="collapse in" id="vendorProfileMenu">
            <ul class="nav">
              <li>
                <a href="{{ route('staff.edit.profile') }}">
                  <span class="link-collapse">Edit Profile</span>
                </a>
              </li>

              <li>
                <a href="{{ route('staff.change_password') }}">
                  <span class="link-collapse">Change Password</span>
                </a>
              </li>

              <li>
                <a href="{{ route('staff.logout') }}">
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
        <li class="nav-item @if (request()->routeIs('staff.dashboard')) active @endif">
          <a href="{{ route('staff.dashboard') }}">
            <i class="la flaticon-paint-palette"></i>
            <p>Dashboard</p>
          </a>
        </li>
        {{-- services managment --}}
        <li
          class="nav-item
          @if (request()->routeIs('staff.service_managment')) active @endif
          @if (request()->routeIs('staff.service_managment.create')) active @endif
          @if (request()->routeIs('staff.service_managment.edit')) active @endif">
          <a data-toggle="collapse" href="#services">
            <i class="fas fa-wrench"></i>
            <p>Service Managment</p>
            <span class="caret"></span>
          </a>

          <div id="services"
            class="collapse
               @if (request()->routeIs('staff.service_managment')) show @endif
               @if (request()->routeIs('staff.service_managment.create')) show @endif
               @if (request()->routeIs('staff.service_managment.edit')) show @endif">
            <ul class="nav nav-collapse">
              <li
                class="@if (request()->routeIs('staff.service_managment')) active
                        @elseif (request()->routeIs('staff.service_managment.edit')) active @endif">
                <a href="{{ route('staff.service_managment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Services</span>
                </a>
              </li>
              @if ($permission->service_add == 1)
                <li class="@if (request()->routeIs('staff.service_managment.create')) active @endif">
                  <a href="{{ route('staff.service_managment.create') }}">
                    <span class="sub-item">Add Service</span>
                  </a>
                </li>
              @endif
            </ul>
          </div>
        </li>

        {{-- Appointments  --}}
        <li
          class="nav-item
           @if (request()->routeIs('staff.pending_appointment')) active @endif
           @if (request()->routeIs('staff.accepted_appointment')) active @endif
           @if (request()->routeIs('staff.appointment.details')) active @endif
           @if (request()->routeIs('staff.rejected_appointment')) active @endif
           @if (request()->routeIs('staff.appointment')) active @endif">
          <a data-toggle="collapse" href="#eventBooking">
            <i class="fal fa-calendar"></i>
            <p>Appointments </p>
            <span class="caret"></span>
          </a>

          <div id="eventBooking"
            class="collapse
                         @if (request()->routeIs('staff.pending_appointment')) show @endif
           @if (request()->routeIs('staff.accepted_appointment')) show @endif
           @if (request()->routeIs('staff.rejected_appointment')) show @endif
           @if (request()->routeIs('staff.appointment.details')) show @endif
              @if (request()->routeIs('staff.appointment')) show @endif">
            <ul class="nav nav-collapse">
              <li
                class="
              @if (request()->routeIs('staff.appointment')) active @endif
              @if (request()->routeIs('staff.appointment.details')) active @endif
              ">
                <a href="{{ route('staff.appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">All Appointments</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('staff.pending_appointment') ? 'active' : '' }}">
                <a href="{{ route('staff.pending_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Pending Appointments</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('staff.accepted_appointment') ? 'active' : '' }}">
                <a href="{{ route('staff.accepted_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Accepted Appointments</span>
                </a>
              </li>
              <li class="{{ request()->routeIs('staff.rejected_appointment') ? 'active' : '' }}">
                <a href="{{ route('staff.rejected_appointment', ['language' => $defaultLang->code]) }}">
                  <span class="sub-item">Rejected Appointments</span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        {{-- time schedule --}}
        @if ($permission->time == 1)
          <li
            class="nav-item
        @if (request()->routeIs('staff.time-slot')) active @endif
        @if (request()->routeIs('staff.hour.manage')) active @endif
        ">
            <a href="{{ route('staff.time-slot') }}">
              <i class="fas fa-clock"></i>
              <p>Schedule</p>
            </a>
          </li>
        @endif

        {{-- message --}}
        <li class="nav-item @if (request()->routeIs('staff.service_inquery.message')) active @endif">
          <a href="{{ route('staff.service_inquery.message', ['language' => $defaultLang->code]) }}">
            <i class="fas fa-comment"></i>
            <p>Service Inquiry</p>
          </a>
        </li>
        {{-- plugin --}}
        @if (!empty($packagePermission))
          @if ($packagePermission->calendar_status == 1)
            <li class="nav-item
          @if (request()->routeIs('staff.plugins.index')) active @endif
          ">
              <a href="{{ route('staff.plugins.index') }}">
                <i class="fas fa-plug"></i>
                <p>Plugins</p>
              </a>
            </li>
          @endif
        @else
          <li class="nav-item
          @if (request()->routeIs('staff.plugins.index')) active @endif
          ">
            <a href="{{ route('staff.plugins.index') }}">
              <i class="fas fa-plug"></i>
              <p>Plugins</p>
            </a>
          </li>
        @endif
        {{-- edit profile --}}

        <li class="nav-item @if (request()->routeIs('staff.edit.profile')) active @endif">
          <a href="{{ route('staff.edit.profile') }}">
            <i class="fal fa-user-edit"></i>
            <p>Edit Profile</p>
          </a>
        </li>
        <li class="nav-item @if (request()->routeIs('staff.change_password')) active @endif">
          <a href="{{ route('staff.change_password') }}">
            <i class="fal fa-key"></i>
            <p>Change Password</p>
          </a>
        </li>

        <li class="nav-item @if (request()->routeIs('staff.logout')) active @endif">
          <a href="{{ route('staff.logout') }}">
            <i class="fal fa-sign-out"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
