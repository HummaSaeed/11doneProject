(function ($) {
  "use strict";
  $('#zoom').on('change', function () {
    var vendorId = $(this).val();
    $.ajax({
      url: baseUrl + 'admin/basic-settings/vendor-plugins/' + vendorId,
      type: 'GET',
      success: function (res) {
        if (res.zoom == null) {
          $('#zoom_account_id').val('');
          $('#zoom_client_id').val('');
          $('#zoom_client_secret').val('');
        } else {
          $('#zoom_account_id').val(res.zoom.zoom_account_id);
          $('#zoom_client_id').val(res.zoom.zoom_client_id);
          $('#zoom_client_secret').val(res.zoom.zoom_client_secret);
        }
      }
    })
  });

  $('#calendar').on('change', function () {
    var id = $(this).val();
    $.ajax({
      url: baseUrl + 'admin/basic-settings/calendar/' + id,
      type: 'GET',
      success: function (res) {
        if (res.calendar == null) {
          $('#calender_id').val('');
          if (res.calendar.calender_id != "") {
            $('#calendar_file').removeClass('d-none');
          }
        } else {
          $('#calender_id').val(res.calendar.calender_id);
          if (res.calendar.calender_id != "") {
            $('#calendar_file').removeClass('d-none');
          }
        }

      }
    })
  });

})(jQuery);
