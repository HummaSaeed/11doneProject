$(document).ready(function () {
  "use strict";
  $('#cpyBtn').on('click',function () {
    var textToCopy = $('#inputField').val();
    var tempTextarea = $('<textarea>');

    $('body').append(tempTextarea);
    tempTextarea.val(textToCopy).select();
    document.execCommand('copy');

    // Show the alert
    $('#alert').fadeIn('slow', function () {
      // Hide the alert after 1 second
      setTimeout(function () {
        $('#alert').slideUp('slow');
      }, 1000);
    });

    // Remove the temporary textarea
    tempTextarea.remove();
  });
});
