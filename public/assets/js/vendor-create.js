"use strict";
//staff form
$('#vendorBtn').on('click', function (e) {
  $(e.target).attr('disabled', true);
  $(".request-loader").addClass("show");


  let vednorForm = document.getElementById('vednorForm');
  let fd = new FormData(vednorForm);
  let url = $("#vednorForm").attr('action');
  let method = $("#vednorForm").attr('method');


  $.ajax({
    url: url,
    method: method,
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {

      $(e.target).attr('disabled', false);
      $('.request-loader').removeClass('show');

      $('.em').each(function () {
        $(this).html('');
      });

      if (data.status == 'success') {
        location.reload();
      }
    },
    error: function (error) {
      let errors = ``;

      for (let x in error.responseJSON.errors) {
        errors += `<li>
                <p class="text-danger mb-0">${error.responseJSON.errors[x][0]}</p>
              </li>`;
      }

      $('#vendor_erros ul').html(errors);
      $('#vendor_erros').show();

      $('.request-loader').removeClass('show');

      $('html, body').animate({
        scrollTop: $('#vendor_erros').offset().top - 100
      }, 1000);
    }
  });
  $(e.target).attr('disabled', false);
});
