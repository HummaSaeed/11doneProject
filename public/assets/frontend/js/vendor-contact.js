"use strict";
$('body').on('submit', '#vendorContactForm', function (e) {
  e.preventDefault();

  let vendorContactForm = document.getElementById('vendorContactForm');
  $('.request-loader-time').addClass('show');
  var url = $(this).attr('action');
  var method = $(this).attr('method');

  let fd = new FormData(vendorContactForm);
  $.ajax({
    url: url,
    method: method,
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {
      $('.request-loader-time').removeClass('show');
      $('.em').each(function () {
        $(this).html('');
      });

      if (data == 'success') {
        location.reload();
      }
    },
    error: function (error) {
      $('.em').each(function () {
        $(this).html('');
      });

      for (let x in error.responseJSON.errors) {
        document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];
      }

      $('.request-loader-time').removeClass('show');
    }
  })
});
