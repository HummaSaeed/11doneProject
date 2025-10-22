<aside class="widget-area mb-40">
  <div class="widget p-25 radius-md">
    <ul class="links">
      <li><a href="{{ route('user.dashboard') }}"
          class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">{{ __('Dashboard') }}</a></li>
                <li><a href="{{ route('user.wishlist') }}"
          class="{{ request()->routeIs('user.wishlist') ? 'active' : '' }}">{{ __('My Wishlist') }} </a></li>
      <li><a href="{{ route('user.appointment.index') }}"
          class="{{ request()->routeIs('user.appointment.index') || request()->routeIs('user.appointment.details') ? 'active' : '' }}">{{ __('Appointments') }}
        </a></li>
      @if ($basicInfo->shop_status == 1)
        <li><a href="{{ route('user.order.index') }}"
            class="{{ request()->routeIs('user.order.index') || request()->routeIs('user.order.details') ? 'active' : '' }}">{{ __('Product Orders') }}
          </a></li>
      @endif
      <li><a href="{{ route('user.change_password') }}"
          class="{{ request()->routeIs('user.change_password') ? 'active' : '' }}">{{ __('Change Password') }} </a>
      </li>
      <li><a href="{{ route('user.edit_profile') }}"
          class="{{ request()->routeIs('user.edit_profile') ? 'active' : '' }}">{{ __('Edit Profile') }} </a></li>
      <li><a href="{{ route('user.logout') }}">{{ __('Logout') }} </a></li>
    </ul>
  </div>
</aside>
