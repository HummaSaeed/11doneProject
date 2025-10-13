$(document).ready(function () {
  "use strict";
  function bootnotify(message, title, type) {
    var content = {};

    content.message = message;
    content.title = title;
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: type,
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      allow_dismiss: true,
      delay: 4000
    });
  }

  $('#vendor_package_check').on('change', function () {
    let vendor_id = $(this).val();
    $.ajax({
      url: url,
      method: 'get',
      data: { vendor_id: vendor_id },
      success: function (res) {
        if (res === 'success') {
          bootnotify("You can't add staff for this vendor", 'Alert', 'warning');
        }
      }
    })
  })
});


