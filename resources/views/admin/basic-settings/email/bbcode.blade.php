<div class="col-lg-5">
  <table class="table table-striped border">
    <thead>
      <tr>
        <th scope="col">{{ __('BB Code') }}</th>
        <th scope="col">{{ __('Meaning') }}</th>
      </tr>
    </thead>
    <tbody>
      @if ($templateInfo->mail_type == 'verify_email')
        <tr>
          <td>{username}</td>
          <td scope="row">{{ __('Username of User') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'verify_email')
        <tr>
          <td>{verification_link}</td>
          <td scope="row">{{ __('Email Verification Link') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'reset_password' || $templateInfo->mail_type == 'product_order')
        <tr>
          <td>{customer_name}</td>
          <td scope="row">{{ __('Name of The Customer') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'balance_added' || $templateInfo->mail_type == 'balance_subtracted')
        <tr>
          <td>{amount}</td>
          <td scope="row">{{ __('Balance add/substract  amount') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'reset_password')
        <tr>
          <td>{password_reset_link}</td>
          <td scope="row">{{ __('Password Reset Link') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'withdraw_approved')
        <tr>
          <td>{withdraw_id}</td>
          <td scope="row">{{ __('Withdraw Payment Id') }}</td>
        </tr>
        <tr>
          <td>{current_balance}</td>
          <td scope="row">{{ __('Vendor Current Balance') }}</td>
        </tr>
        <tr>
          <td>{withdraw_amount}</td>
          <td scope="row">{{ __('Withdraw Amount') }}</td>
        </tr>
        <tr>
          <td>{charge}</td>
          <td scope="row">{{ __('Admin Charge Amount') }}</td>
        </tr>
        <tr>
          <td>{payable_amount}</td>
          <td scope="row">{{ __('Vendor Recived Amount') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'withdraw_declined')
        <tr>
          <td>{withdraw_id}</td>
          <td scope="row">{{ __('Withdraw Payment Id') }}</td>
        </tr>
        <tr>
          <td>{current_balance}</td>
          <td scope="row">{{ __('Vendor Current Balance') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'featured_request_send' ||
              $templateInfo->mail_type == 'featured_request_payment_rejected' ||
              $templateInfo->mail_type == 'featured_request_approved' ||
              $templateInfo->mail_type == 'service_payment_rejected' ||
              $templateInfo->mail_type == 'service_payment_approved' ||
              $templateInfo->mail_type == 'service_booking_rejected' ||
              $templateInfo->mail_type == 'featured_request_rejected' ||
              $templateInfo->mail_type == 'featured_request_payment_approved' ||
              $templateInfo->mail_type == 'service_booking_accepted')
        <tr>
          <td>{service_title}</td>
          <td scope="row">{{ __('Service Title') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'featured_request_send' ||
              $templateInfo->mail_type == 'featured_request_payment_approved' ||
              $templateInfo->mail_type == 'featured_request_payment_rejected' ||
              $templateInfo->mail_type == 'featured_request_rejected')
        <tr>
          <td>{amount}</td>
          <td scope="row">{{ __('Request Amount') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'featured_request_approved')
        <tr>
          <td>{start_date}</td>
          <td scope="row">{{ __('Featured Service Start Date') }}</td>
        </tr>
        <tr>
          <td>{end_date}</td>
          <td scope="row">{{ __('Featured Service End Date') }}</td>
        </tr>
        <tr>
          <td>{day}</td>
          <td scope="row">{{ __('Featured Day') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'service_payment_rejected' ||
              $templateInfo->mail_type == 'service_payment_approved' ||
              $templateInfo->mail_type == 'service_booking_rejected')
        <tr>
          <td>{price}</td>
          <td scope="row">{{ __('Service Price') }}</td>
        </tr>
      @endif


      @if ($templateInfo->mail_type == 'product_order')
        <tr>
          <td>{order_number}</td>
          <td scope="row">{{ __('Order Number') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'product_order')
        <tr>
          <td>{order_link}</td>
          <td scope="row">{{ __('Link to View Order Details') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type != 'verify_email' ||
              $templateInfo->mail_type != 'reset_password' ||
              $templateInfo->mail_type != 'product_order')
        <tr>
          <td>{username}</td>
          <td scope="row">{{ __('Username of Vendor') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'service_booking_accepted')
        <tr>
          <td>{booking_number}</td>
          <td scope="row">{{ __('Booking Number') }}</td>
        </tr>
        <tr>
          <td>{zoom_link}</td>
          <td scope="row">{{ __('Zoom meeting link') }}</td>
        </tr>
        <tr>
          <td>{zoom_password}</td>
          <td scope="row">{{ __('Zoom meeting password') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'service_booking_accepted' || $templateInfo->mail_type == 'service_payment_approved')
        <tr>
          <td>{customer_name}</td>
          <td scope="row">{{ __('Name of Customer') }}</td>
        </tr>
        <tr>
          <td>{appointment_date}</td>
          <td scope="row">{{ __('Appointment Date') }}</td>
        </tr>
        <tr>
          <td>{appointment_time}</td>
          <td scope="row">{{ __('Appointment Time') }}</td>
        </tr>
        <tr>
          <td>{booking_date}</td>
          <td scope="row">{{ __('Booking Date') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'admin_changed_current_package' ||
              $templateInfo->mail_type == 'admin_changed_next_package' ||
              $templateInfo->mail_type == 'admin_removed_current_package')
        <tr>
          <td>{replaced_package}</td>
          <td scope="row">{{ __('Replace Package Name') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'admin_changed_current_package' ||
              $templateInfo->mail_type == 'admin_added_current_package' ||
              $templateInfo->mail_type == 'admin_changed_next_package' ||
              $templateInfo->mail_type == 'admin_added_next_package' ||
              $templateInfo->mail_type == 'admin_removed_current_package' ||
              $templateInfo->mail_type == 'admin_removed_next_package' ||
              $templateInfo->mail_type == 'package_purchase_membership_accepted' ||
              $templateInfo->mail_type == 'package_purchase_membership_rejected' ||
              $templateInfo->mail_type == 'package_purchase')
        <tr>
          <td>{package_title}</td>
          <td scope="row">{{ __('Package Name') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'admin_changed_current_package' ||
              $templateInfo->mail_type == 'admin_added_current_package' ||
              $templateInfo->mail_type == 'admin_added_next_package' ||
              $templateInfo->mail_type == 'package_purchase_membership_accepted' ||
              $templateInfo->mail_type == 'package_purchase_membership_rejected' ||
              $templateInfo->mail_type == 'package_purchase')
        <tr>
          <td>{package_price}</td>
          <td scope="row">{{ __('Price of Package') }}</td>
        </tr>
      @endif

      @if (
          $templateInfo->mail_type == 'admin_changed_current_package' ||
              $templateInfo->mail_type == 'admin_added_current_package' ||
              $templateInfo->mail_type == 'admin_changed_next_package' ||
              $templateInfo->mail_type == 'admin_added_next_package' ||
              $templateInfo->mail_type == 'package_purchase_membership_accepted' ||
              $templateInfo->mail_type == 'package_purchase')
        <tr>
          <td>{activation_date}</td>
          <td scope="row">{{ __('Package activation date') }}</td>
        </tr>
      @endif
      @if (
          $templateInfo->mail_type == 'admin_changed_current_package' ||
              $templateInfo->mail_type == 'admin_added_current_package' ||
              $templateInfo->mail_type == 'admin_changed_next_package' ||
              $templateInfo->mail_type == 'admin_added_next_package' ||
              $templateInfo->mail_type == 'package_purchase_membership_accepted' ||
              $templateInfo->mail_type == 'package_purchase' ||
              $templateInfo->mail_type == 'service_inquery')
        <tr>
          <td>{expire_date}</td>
          <td scope="row">{{ __('Package expire date') }}</td>
        </tr>
      @endif

      @if ($templateInfo->mail_type == 'membership_expiry_reminder')
        <tr>
          <td>{last_day_of_membership}</td>
          <td scope="row">{{ __('Package expire last date') }}</td>
        </tr>
      @endif
      @if ($templateInfo->mail_type == 'membership_expiry_reminder' || $templateInfo->mail_type == 'membership_expired')
        <tr>
          <td>{login_link}</td>
          <td scope="row">{{ __('Login Url') }}</td>
        </tr>
      @endif


      @if ($templateInfo->mail_type == 'service_inquery')
        <tr>
          <td>{enquirer_name}</td>
          <td scope="row">{{ __('Name of enquirer') }}</td>
        </tr>
        <tr>
          <td>{enquirer_email}</td>
          <td scope="row">{{ __('Email address of enquirer') }}</td>
        </tr>
        <tr>
          <td>{enquirer_message}</td>
          <td scope="row">{{ __('Message of enquirer') }}</td>
        </tr>
      @endif
      <tr>
        <td>{website_title}</td>
        <td scope="row">{{ __('Website Title') }}</td>
      </tr>
    </tbody>
  </table>
</div>
