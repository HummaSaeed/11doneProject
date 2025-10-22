"use strict";
$("#featureBtn").on('click', function (e) {
  $(e.target).attr('disabled', true);
  $(".request-loader").addClass("show");

  if ($(".iconpicker-component").length > 0) {
    $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
  }
  if ($(".iconpicker-component2").length > 0) {
    $("#inputIcon2").val($(".iconpicker-component2").find('i').attr('class'));
  }

  let featureForm = document.getElementById('featureForm');
  let fd = new FormData(featureForm);
  let url = $("#featureForm").attr('action');
  let method = $("#featureForm").attr('method');


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
        $('#createModal').modal('hide');
        $('#ajaxForm')[0].reset();
        location.reload();
      }
      if (data == "empty_package") {
        $('.modal').modal('hide');
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
        var content = {};
        content.message = 'Limit is reached or exceeded!';
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
      $('.em').each(function () {
        $(this).html('');
      });

      for (let x in error.responseJSON.errors) {
        document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];
      }

      $('.request-loader').removeClass('show');
      $(e.target).attr('disabled', false);
    }
  });
});


$("#featureUpdate").on('click', function (e) {
  $(".request-loader").addClass("show");

  if ($(".edit-iconpicker-component").length > 0) {
    $("#editInputIcon").val($(".edit-iconpicker-component").find('i').attr('class'));
  }

  let featueUpdateForm = document.getElementById('featueUpdateForm');
  let fd = new FormData(featueUpdateForm);
  let url = $("#featueUpdateForm").attr('action');
  let method = $("#featueUpdateForm").attr('method');

  $.ajax({
    url: url,
    method: method,
    data: fd,
    contentType: false,
    processData: false,
    success: function (data) {
      $('.request-loader').removeClass('show');
      $(e.target).attr('disabled', false);

      $('.em').each(function () {
        $(this).html('');
      });

      if (data.status == 'success') {
        $(".modal").modal('hide');
        location.reload();
      }
      if (data == "empty_package") {
        $('.modal').modal('hide');
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
        $('.modal').modal('hide');
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
      $('.em').each(function () {
        $(this).html('');
      });

      for (let x in error.responseJSON.errors) {
        document.getElementById('editErr_' + x).innerHTML = error.responseJSON.errors[x][0];
      }

      $('.request-loader').removeClass('show');
      $(e.target).attr('disabled', false);
    }
  });
});
