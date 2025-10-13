"use strict";

/*================ Service Type =======================*/
$(document).ready(function () {
  // handle the initial state
  toggleServiceOptions();
});

// toggle advanced section when the radio button is changed
$('input[name="person_type"]').on('change', function () {
  toggleServiceOptions();
});

function toggleServiceOptions() {
  if ($('input[name="person_type"]:checked').val() == '1') {
    $('.groupPersons').addClass('d-none');
  } else {
    $('.groupPersons').removeClass('d-none');
  }
}


/*==== Allow Login toggle button on Staff Page  =====*/
$(document).ready(function () {
  // toggle allow login form when the radio button is changed
  $('input[name="login_allow_toggle"]').on('change', function () {
    toggleAllowLogin();
  });
});

// toggle allow login form section for visibility
function toggleAllowLogin() {
  if ($('input[name="login_allow_toggle"]:checked').val() === '1') {
    $('.allowLoginShowOff').removeClass('d-none');
  } else {
    $('.allowLoginShowOff').addClass('d-none');
  }
  $('input[name="login_allow_toggle"]').trigger('change');
}

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

// service form
$('#ServiceSubmit').on('click', function (e) {
  let can_service_add = $(this).attr('data-can_service_add');
  if (can_service_add == 0) {
    bootnotify('No packages available for this vendor!', 'Alert', 'warning');
    return false;
  } else if (can_service_add == 2) {
    bootnotify("This vendor had reached the limit", 'Alert', 'warning');
    return false;
  } else if (can_service_add == 'downgrad') {
    bootnotify("Something went wrong. Please contact with your owner!", 'Alert', 'warning');
    return false;
  }

  $(e.target).attr('disabled', true);
  $(".request-loader").addClass("show");

  let serviceForm = document.getElementById('serviceForm');
  let fd = new FormData(serviceForm);
  let url = $("#serviceForm").attr('action');
  let method = $("#serviceForm").attr('method');

  //if summernote has then get summernote content
  $('.form-control').each(function (i) {
    let index = i;

    let $toInput = $('.form-control').eq(index);

    if ($(this).hasClass('summernote')) {
      let tmcId = $toInput.attr('id');
      let content = tinyMCE.get(tmcId).getContent();
      fd.delete($(this).attr('name'));
      fd.append($(this).attr('name'), content);
    }
  });


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

      if (data == 'success') {
        location.reload();
        $('#serviceForm')[0].reset();
      }
      if (data == 'empty_package') {
        "use strict";
        var content = {};
        content.message = 'Please buy a package to use this panel!';
        content.title = "Warning";
        content.icon = 'fa fa-bell';
        $.notify(content, {
          type: 'warning',
          placement: {
            from: 'top',
            align: 'right'
          },
          showProgressbar: true,
          time: 1000,
          delay: 4000,
        });
      }

      if (data == "staff_downgrad_js") {
        $('.modal').modal('hide');
        "use strict";
        var content = {};
        content.message = 'Something went wrong. Please contact with your owner!';
        content.title = "Warning";
        content.icon = 'fa fa-bell';
        $.notify(content, {
          type: 'warning',
          placement: {
            from: 'top',
            align: 'right'
          },
          showProgressbar: true,
          time: 1000,
          delay: 4000,
        });
      }

      if (data == "downgrade") {
        $('.modal').modal('hide');
        "use strict";
        var content = {};
        content.message = 'Limit is reached of exceeded!';
        content.title = "Warning";
        content.icon = 'fa fa-bell';
        $.notify(content, {
          type: 'warning',
          placement: {
            from: 'top',
            align: 'right'
          },
          showProgressbar: true,
          time: 1000,
          delay: 4000,
        });
        $("#limitModal").modal('show');
      }

    },
    error: function (error) {
      let errors = ``;

      for (let x in error.responseJSON.errors) {
        errors += `<li>
                <p class="text-danger mb-0">${error.responseJSON.errors[x][0]}</p>
              </li>`;
      }

      $('#service_erros ul').html(errors);
      $('#service_erros').show();

      $('.request-loader').removeClass('show');

      $('html, body').animate({
        scrollTop: $('#service_erros').offset().top - 100
      }, 1000);
    }
  });
  $(e.target).attr('disabled', false);
});


//staff form
$('#staffSubmit').on('click', function (e) {
  let can_staff_add = $(this).attr('data-can_staff_add');
  if (can_staff_add == 0) {
    bootnotify('Please Buy a plan to add a satff.!', 'Alert', 'warning');
    return false;
  } else if (can_staff_add == 2) {
    bootnotify("You can't add more staff for this vendor.", 'Alert', 'warning');
    return false;
  }
  $(e.target).attr('disabled', true);
  $(".request-loader").addClass("show");


  let staffForm = document.getElementById('staffForm');
  let fd = new FormData(staffForm);
  let url = $("#staffForm").attr('action');
  let method = $("#staffForm").attr('method');


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

      if (data == 'success') {
        location.reload();
        $('#staffForm')[0].reset();
      }
      if (data == 'empty_package') {
        "use strict";
        var content = {};
        content.message = 'Please buy a package to use this panel!';
        content.title = "Warning";
        content.icon = 'fa fa-bell';
        $.notify(content, {
          type: 'warning',
          placement: {
            from: 'top',
            align: 'right'
          },
          showProgressbar: true,
          time: 1000,
          delay: 4000,
        });
      }
      if (data == "downgrade") {
        $('.modal').modal('hide');
        "use strict";
        var content = {};
        content.message = 'Limit is reached of exceeded!';
        content.title = "Warning";
        content.icon = 'fa fa-bell';
        $.notify(content, {
          type: 'warning',
          placement: {
            from: 'top',
            align: 'right'
          },
          showProgressbar: true,
          time: 1000,
          delay: 4000,
        });
        $("#limitModal").modal('show');
      }
    },
    error: function (error) {
      let errors = ``;

      for (let x in error.responseJSON.errors) {
        errors += `<li>
                <p class="text-danger mb-0">${error.responseJSON.errors[x][0]}</p>
              </li>`;
      }

      $('#service_erros ul').html(errors);
      $('#service_erros').show();

      $('.request-loader').removeClass('show');

      $('html, body').animate({
        scrollTop: $('#service_erros').offset().top - 100
      }, 1000);
    }
  });
  $(e.target).attr('disabled', false);
});

