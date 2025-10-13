$(function ($) {
  "use strict";
  $("#withdrawBtn").on('click', function (e) {
    $(e.target).attr('disabled', true);
    $(".request-loader").addClass("show");

    let withdrawForm = document.getElementById('withdrawForm');
    let fd = new FormData(withdrawForm);
    let url = $("#withdrawForm").attr('action');
    let method = $("#withdrawForm").attr('method');

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
          location.reload();
        }
      },
      error: function (error) {
        $('.em').each(function () {
          $(this).html('');
        });
        if (error.responseJSON.errors) {
          for (let x in error.responseJSON.errors) {
            document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];
          }
        } else {
          $('#err_limit_amount').text(error.responseJSON.error)
        }

        $('.request-loader').removeClass('show');
        $(e.target).attr('disabled', false);
      }
    });
  });




  $("#updateWithdrawBtn").on('click', function (e) {
    $(e.target).attr('disabled', true);
    $(".request-loader").addClass("show");

    let updateWithdrawForm = document.getElementById('updateWithdrawForm');
    let fd = new FormData(updateWithdrawForm);
    let url = $("#updateWithdrawForm").attr('action');
    let method = $("#updateWithdrawForm").attr('method');

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
          $('#editModal').modal('hide');
          location.reload();
        }
      },
      error: function (error) {
        $('.em').each(function () {
          $(this).html('');
        });
        if (error.responseJSON.errors) {
          for (let x in error.responseJSON.errors) {
            document.getElementById('editErr_' + x).innerHTML = error.responseJSON.errors[x][0];
          }
        } else {
          $('#editErr_limit_amount').text(error.responseJSON.error)
        }

        $('.request-loader').removeClass('show');
        $(e.target).attr('disabled', false);
      }
    });
  });


});
