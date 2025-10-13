(function ($) {
  "use strict";
  $('input[name="is_trial"]').on('change', function () {
    if ($(this).val() == 1) {
      $('#trial_day').show();
    } else {
      $('#trial_day').hide();
    }
    $('#trial_days').val(null);
  });
})(jQuery);


(function ($) {
  "use strict";
  $('input[name="is_trial"]').on('change', function () {
    if ($(this).val() == 1) {
      $('#trial_day').show();
    } else {
      $('#trial_day').hide();
    }
    $('#trial_days_2').val(null);
    $('#trial_days_1').val(null);
  });
})(jQuery);

(function ($) {
  "use strict";
  $('input[name="staff_status"]').on('change', function () {
    if ($(this).val() == 1) {
      $('#staff_limit').show();
    } else {
      $('#staff_limit').hide();
    }
    $('input[name="staff_limit"]').val(null);
  });
})(jQuery);

