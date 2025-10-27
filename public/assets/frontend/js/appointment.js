"use strict";
var bookingStepper;
const csrfToken = $('meta[name="csrf-token"]').attr('content');
$('body').on('click', '.bookNowBtn', function () {
  $('.request-loader-time').addClass('show');
  var service_id = $(this).data('id');
  //service
  $.ajax({
    type: 'get',
    url: baseURL + '/services/services-staff-content/' + service_id,
    data: {
      service_id: service_id,
    },
    success: function (response) {
      $('#makeBooking').modal('show');
      $('.request-loader-time').removeClass('show');
      $('#bookInfoShow').html(response);
      //  Bootstrap Stepper
      bookingStepper = new Stepper(document.querySelector('#booking-stepper'), {
        linear: true,
        animation: true,
      });
      // Initialize calendar directly for general availability
      var serviceId = service_id; // Use the service ID from the button click
      initializeGeneralCalendar(serviceId);

      /*-----init stripe payment method-----*/
      // set your stripe public key
      var stripe = Stripe(stripe_key);
      // Create a Stripe Element for the card field
      var elements = stripe.elements();
      var cardElement = elements.create('card', {
        style: {
          base: {
            iconColor: '#454545',
            color: '#454545',
            fontWeight: '500',
            lineHeight: '50px',
            fontSmoothing: 'antialiased',
            backgroundColor: '#f2f2f2',
            ':-webkit-autofill': {
              color: '#454545',
            },
            '::placeholder': {
              color: '#454545',
            },
          }
        },
      });
      if ($('#stripe-element').length) {
        cardElement.mount('#stripe-element');
      }
      // hide after init
      if ($('#stripe-element').length) {
        $('#stripe-element').addClass('d-none');
      }

      //submit payment form
      $("#payment-form").submit(function (event) {
        event.preventDefault();
        $('.request-loader-time').addClass('show');
        // Validate the form fields
        if ($('#gateway').val() == 'stripe') {
          stripe.createToken(cardElement).then(function (result) {
            if (result.error) {
              // Display errors to the customer
              var errorElement = document.getElementById('stripe-errors');
              errorElement.textContent = result.error.message;
              $('.request-loader-time').removeClass('show');
              return; // Prevent further execution
            } else {
              stripeTokenHandler(result.token);
            }
          });
        } else if ($('#gateway').val() == 'authorize.net') {
          sendPaymentDataToAnet();
        }

        let form = document.getElementById('payment-form');
        let fd = new FormData(form);
        let url = $("#payment-form").attr('action');
        let method = $("#payment-form").attr('method');

        // Submit the form via AJAX
        $.ajax({
          url: url,
          method: method,
          data: fd,
          contentType: false,
          processData: false,
          success: function (data) {
            $('#featuredBtn').addClass('disabled');
            if (data.redirectURL) {
              window.location.href = data.redirectURL;
            } else {
              $('#razorPayForm').html(data);
              $(".request-loader-time").removeClass("show");
            }

            $('.em').each(function () {
              $(this).html('');
            });
            $('.request-loader-time').removeClass('show');
          },
          error: function (error) {
            $('#featuredBtn').removeClass('disabled');
            $('.em').each(function () {
              $(this).html('');
            });

            if (error.status === 422 && error.responseJSON.errors) {
              // Display errors returned by the server
              for (let field in error.responseJSON.errors) {
                document.getElementById('err_' + field).innerHTML = error.responseJSON.errors[field][0];
              }
            } else {
              $('#err_currency').text(error.responseJSON.error)
            }
            $(event.target).prop('disabled', false);
            $('.request-loader-time').removeClass('show');
          }
        });
      });

      // Send the token to your server
      function stripeTokenHandler(token) {
        // Add the token to the form data before submitting to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);
        // Submit the form to your server
        form.submit();
      }
      //Send the authorize.net token to your server
      function sendPaymentDataToAnet() {
        // Set up authorisation to access the gateway.
        var authData = {};
        authData.clientKey = authorize_public_key;
        authData.apiLoginID = authorize_login_key;

        var cardData = {};
        cardData.cardNumber = document.getElementById("anetCardNumber").value;
        cardData.month = document.getElementById("anetExpMonth").value;
        cardData.year = document.getElementById("anetExpYear").value;
        cardData.cardCode = document.getElementById("anetCardCode").value;

        // Now send the card data to the gateway for tokenisation.
        // The responseHandler function will handle the response.
        var secureData = {};
        secureData.authData = authData;
        secureData.cardData = cardData;
        Accept.dispatchData(secureData, responseHandler);
      }

      function responseHandler(response) {
        if (response.messages.resultCode === "Error") {
          var i = 0;
          let errorLists = ``;
          while (i < response.messages.message.length) {
            errorLists += `<li class="text-danger">${response.messages.message[i].text}</li>`;
            i = i + 1;
          }
          $('.request-loader-time').removeClass('show');
          $("#authorizeNetErrors").show();
          $("#authorizeNetErrors").html(errorLists);
        } else {
          paymentFormUpdate(response.opaqueData);
        }
      }

      function paymentFormUpdate(opaqueData) {
        var form = document.getElementById('payment-form');
        document.getElementById("opaqueDataDescriptor").value = opaqueData.dataDescriptor;
        document.getElementById("opaqueDataValue").value = opaqueData.dataValue;
        form.submit();
      }

    }, error: function (xhr, status, error) {
      $('.request-loader-time').removeClass('show');
      $('#bookInfoShow').html(`
  <div class="not-available">
    <div class="icon">
      <i class="fa fa-info"></i>
    </div>
    <h6 class="text-center text-danger">
      ${bookingUnableText}
    </h6>
  </div>
`);

      toastr.error(xhr.responseJSON.error);
    }
  });

  // search staff
  $('body').on('keyup', '#searchVale', function (e) {
    $('.request-loader-time').addClass('show');
    e.preventDefault();
    let searchVal = $('#searchVale').val();
    $.ajax({
      method: 'get',
      url: baseURL + '/services/staff/search/' + service_id,
      data: { searchVal: searchVal },
      success: function (res) {
        $('.request-loader-time').removeClass('show');
        $('.staff-slider').html(res);
        // Staff slider
        var staffSlider = new Swiper(".staff-slider", {
          spaceBetween: 24,
          speed: 1000,
          loop: false,
          autoplay: {
            delay: 3000,
          },
          slidesPerView: 1,
          pagination: false,

          pagination: {
            el: "#staff-slider-pagination",
            clickable: true,
          },

          breakpoints: {
            320: {
              slidesPerView: 1
            },
            576: {
              slidesPerView: 2
            },
            992: {
              slidesPerView: 3
            },
          }
        });

      }
    });
  });
});

$('body').on('click', '.login_prev', function () {
  $('.auth-info').removeClass('d-none');
  $('#billing-form').addClass('d-none');
});


//remove error message after click prev button from payment page
$('body').on('click', '#payment_prev', function () {
  $('.em').each(function () {
    $(this).html('');
  });
});

/*=====================login customer=================*/
$(document).on('keydown', function (event) {
  if (event.which == 13 && $('#login-form input:focus').length > 0) {
    event.preventDefault();
    $(".request-loader-time").addClass("show");
    customerLogin(event);
  }
});

function customerLogin() {
  var data = $('#login-form').serialize();
  const csrfToken = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    type: 'post',
    url: baseURL + '/services/login',
    data: data,
    dataType: 'json',
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: function (response) {
      $(".request-loader-time").removeClass("show");
      if (response.success) {
        $('.auth-info').addClass('d-none');

        //billing data
        Object.keys(response.billingData).forEach(key => {
          $(`#${key}`).val(response.billingData[key]);
        });

        $('#billing-form').removeClass('d-none');
        $('#billing_prev').removeClass('login_prev').addClass('back_to_time');
        $('#backtoAuth').addClass('d-none');
        toastr['success'](response.success);

        // Check and bind appropriate click event based on class
        if ($('#billing_prev').hasClass('back_to_time')) {
          $('body').off('click', '.back_to_time').on('click', '.back_to_time', function () {
            bookingStepper.previous();
          });
        }
      } else {
        $('#err_username').addClass('d-none');
        $('#err_password').addClass('d-none');
        toastr['error'](response.error);
      }
    },
    error: function (error) {
      $(".request-loader-time").removeClass("show");
      $('.em').each(function () {
        $(this).html('');
      });

      for (let x in error.responseJSON.errors) {
        document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];
      }
    }
  });
}

/*=====================Initialize General Calendar=================*/
function initializeGeneralCalendar(serviceId) {
  $(".request-loader-time").addClass("show");
  
  $.ajax({
    type: 'get',
    url: baseURL + '/services/general-date-time/' + serviceId,
    dataType: 'json',
    success: function (response) {
      $(".request-loader-time").removeClass("show");
      let disabledDates = [];
      let disabledWeekdays = [];
      var vendor_id = response.vendor_id;
      var serviceId = response.serviceId;
      // Use global settings for general availability
      for (var x in response.globalHoliday) {
        let glboalHoliday = response.globalHoliday[x];
        disabledDates.push(glboalHoliday.date);
      }
      for (let x in response.globalWeekend) {
        var value = response.globalWeekend[x];
        disabledWeekdays.push(value.indx);
      }
      if (vendor_id == 0) {
        for (let x in response.adminGlobalWeekend) {
          var value = response.adminGlobalWeekend[x];
          disabledWeekdays.push(value.indx);
        }
      }
      //convert full date to day
      function convertDayName(dateString) {
        // Parse as local date to avoid UTC timezone shifts (e.g., showing previous day)
        // Expected format: YYYY-MM-DD
        if (typeof dateString === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(dateString)) {
          var parts = dateString.split('-');
          var year = parseInt(parts[0], 10);
          var monthIndex = parseInt(parts[1], 10) - 1; // 0-based month
          var day = parseInt(parts[2], 10);
          var date = new Date(year, monthIndex, day);
          var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
          var dayName = dayNames[date.getDay()];
          return dayName;
        }
        // Fallback: let Date try to parse
        var d = new Date(dateString);
        var fallbackDayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return fallbackDayNames[d.getDay()];
      }

      // Booking Calender
      function onInitBookingCalendar() {
        //weekend days color change
        const weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        var disabledDayNames = [];
        disabledWeekdays.forEach(function (index) {
          disabledDayNames.push('.pignose-calendar-week-' + weekdays[index]);
        });
        disabledDayNames.forEach(function (selector) {
          $(selector).addClass('weekend');
        });

        //holiday days color change
        disabledDates.forEach(function (date) {
          // Check if any element matches the current date
          var $element = $('.pignose-calendar-unit-disabled[data-date="' + date + '"]');
          if ($element.length > 0) {
            $element.addClass('holiday');
          }
        });

        // Add green highlighting for available dates (days with time slots)
        setTimeout(function() {
          $('.pignose-calendar-unit').each(function() {
            var $this = $(this);
            var dateStr = $this.data('date');
            if (dateStr && !$this.hasClass('pignose-calendar-unit-disabled')) {
              var dayName = convertDayName(dateStr);
              // Check if this day has available slots
              if (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'].includes(dayName)) {
                $this.addClass('available-date');
                $this.css({
                  'background-color': '#d4edda',
                  'border': '2px solid #28a745',
                  'border-radius': '4px'
                });
              }
            }
          });
        }, 100);

        $('.pignose-calendar-top-next, .pignose-calendar-top-prev').on('click', function () {
          $('#time_next_step, #max_person_id').addClass('d-none');
          $('.booking-time-slider').empty();
        });
      }
      //initialize calender with staff holiday & vendor membership expiree date
      $('.booking-calendar').pignoseCalendar({
        init: onInitBookingCalendar,
        initialize: false,
        disabledDates: disabledDates,
        disabledWeekdays: disabledWeekdays.map(Number),
        minDate: moment().format('YYYY-MM-DD'),
        select: function (date) {
          let bookingDate = date[0]["_i"];
          var dayName = convertDayName(bookingDate);
          $(".request-loader-time").addClass("show");
          //show general time slots
          $.ajax({
            method: 'get',
            url: baseURL + '/services/show-general-hour/' + serviceId,
            data: {
              dayName: dayName,
              bookingDate: bookingDate,
              vendor_id: vendor_id,
              serviceId: serviceId,
            },
            success: function (res) {
              console.log('Date selected:', bookingDate);
              console.log('Day name:', dayName);
              console.log('Time slots response:', res);
              
              if (res) {
                $(".booking-time-slider").html(res);
                $('.request-loader-time').removeClass('show');
                $('.houre-title-1').addClass('d-none');
                
                // Check if dropdown was created
                setTimeout(function() {
                  var dropdown = $('#time_slot_select');
                  console.log('Dropdown exists:', dropdown.length > 0);
                  console.log('Dropdown options:', dropdown.find('option').length);
                  if (dropdown.length > 0) {
                    console.log('Dropdown ready for selection');
                  }
                }, 100);
              } else {
                console.error('Empty response from server');
              }
            },
            error: function(xhr, status, error) {
              console.error('Error loading time slots:', error);
              console.error('Response:', xhr.responseText);
              $('.request-loader-time').removeClass('show');
            }
          });

          //service hour select - using dropdown
          $('body').on('change', '#time_slot_select', function () {
            let serviceHourId = $(this).val();
            
      

            $('#time_next_step').removeClass('d-none');
            $('#max_person_id').removeClass('d-none');
            $('#service_hour_id').val(serviceHourId);
            
            console.log('Next Step button visible:', !$('#time_next_step').hasClass('d-none'));
          });

          //service hour select - using clickable buttons (legacy support)
          $('body').on('click', '.time', function () {
            $('.time').removeClass('time_active');
            $(this).addClass('time_active');

            let serviceHourId = $(this).data('id');

            $('#time_next_step').removeClass('d-none');
            $('#max_person_id').removeClass('d-none');
            $('#service_hour_id').val(serviceHourId);
          });

          //this data pass on checkout page
          $('body').on('click', '#time_next_step', function () {
            let max_person = $('#max_person').val();
            $('#booking_date').val(bookingDate);
            $('#max_person').val(max_person);
            // Set default staff ID for general booking
            $('#staff_id').val('11done');
          });

        }
      });
    },
    error: function(error) {
      $(".request-loader-time").removeClass("show");
      console.error('Error loading general calendar:', error);
    }
  });
}


/*==========reset service hour value and houre-title after click previous======*/
$('body').on('click', '#time_prev_step', function () {
  $(".booking-time-slider").html('');
  $('.houre-title-1').removeClass('d-none');
  $('#time_next_step').addClass('d-none');
});


/*=====================assing data on payment page for booking=================*/
$(document).on('keydown', function (event) {
  if (event.which == 13 && $('#billing-form input:focus').length > 0) {
    event.preventDefault();
    $(".request-loader-time").addClass("show");
    submitForm(event);
  }
});

function submitForm(event) {
  let url = $("#billing-form").attr('action');
  let method = $("#billing-form").attr('method');
  $.ajax({
    url: url,
    method: method,
    data: $('#billing-form').serialize(),
    success: function (response) {
      $(".request-loader-time").removeClass("show");
      if (response) {
        const fields = ['name', 'phone', 'email', 'address', 'zip_code', 'country'];
        fields.forEach(field => $(`#billing_${field}`).val(response[field]));

        $('#serviceHourId').val(response.service_hour_id);
        $('#bookingDate').val(response.booking_date);
        $('#staffId').val('11done'); // Set default staff ID
        $('#userId').val(response.user_id);
        $('#bmax_person').val(response.max_person);
        bookingStepper.next();
      }
    },
    error: function (error) {
      $('.em').each(function () {
        $(this).html('');
      });

      for (let x in error.responseJSON.errors) {
        document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];
      }
      $(".request-loader-time").removeClass("show");
    }
  });
}

/*=====================success msg after complete payment=================*/
if (complete == 'payment_complete') {
  var id = bookingInfo.vendor_id;
  $.ajax({
    type: 'get',
    url: baseURL + '/services/payment-success/' + id,
    success: function (response) {
      $('#makeBooking').modal('show');
      $('#bookInfoShow').html(response);
      $('#confirm').addClass('active');
      $('#staff').addClass('d-none');
      $('#time').addClass('d-none');
      $('#info').addClass('d-none');
      $('#payment').addClass('d-none');
      $('.step').addClass('active');
      $('.con_user').val(id);
    }
  });
}

/*=====================forget session data after close modal=================*/
$('#makeBooking').on('hidden.bs.modal', function (e) {
  $('.request-loader-time').removeClass('show');
  $.ajax({
    type: 'post',
    url: baseURL + '/services/session/forget',
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: function (response) {
    }
  });
});

// Fix modal accessibility issue
$('#makeBooking').on('shown.bs.modal', function (e) {
  $(this).attr('aria-hidden', 'false');
});

$('#makeBooking').on('hidden.bs.modal', function (e) {
  $(this).attr('aria-hidden', 'true');
});

/**
 * show or hide stripe gateway input fields,
 * also show or hide offline gateway informations according to checked payment gateway
 */
$('body').on('change', 'select[name="gateway"]', function () {
  $('#err_currency').html('');
  $('#stripe-errors').html('');
  $('#err_gateway').html('');
  let value = $(this).val();
  let dataType = parseInt(value);

  // Hide all gateway related elements
  $('#stripe-element, #authorizenet-element, .offline-gateway-info').addClass('d-none');

  if (isNaN(dataType)) {
    // For online gateways

    // Show or hide stripe card inputs
    if (value === 'stripe') {
      $('#stripe-element').removeClass('d-none');
    }

    // Show or hide authorize.net card inputs
    else if (value === 'authorize.net') {
      $('#authorizenet-element').removeClass('d-none');
      $("#authorizenet-element input").removeAttr('disabled');
    }
  } else {

    // Show particular offline gateway information
    $('#offline-gateway-' + value).removeClass('d-none');
  }
});

/*=====================guest checkout form=================*/
$('body').on('click', '#guest_checkout', function () {
  $('.auth-info').addClass('d-none');
  $('#billing-form').removeClass('d-none');
  $('#billingBtn').addClass('d-none');
});


$(document).ready(function () {
  // Listen for changes in the active class
  $(document).on('DOMSubtreeModified', '.step', function handler() {
    // Unbind the event handler to prevent it from being called again
    $(document).off('DOMSubtreeModified', '.step', handler);
    // $('.step').removeClass('active-prev');
    $('.step.active').each(function () {
      $(this).prevAll('.step').addClass('active-prev');
    });
    // Rebind the event handler for future changes
    $(document).on('DOMSubtreeModified', '.step', handler);
  });
});



/*=====================Initialize General Calendar=================*/

function initializeGeneralCalendar(serviceId) {

  $(".request-loader-time").addClass("show");

  

  $.ajax({

    type: 'get',

    url: baseURL + '/services/general-date-time/' + serviceId,

    dataType: 'json',

    success: function (response) {

      $(".request-loader-time").removeClass("show");

      let disabledDates = [];

      let disabledWeekdays = [];

      var vendor_id = response.vendor_id;

      var serviceId = response.serviceId;

      // Use global settings for general availability

      for (var x in response.globalHoliday) {

        let glboalHoliday = response.globalHoliday[x];

        disabledDates.push(glboalHoliday.date);

      }

      for (let x in response.globalWeekend) {

        var value = response.globalWeekend[x];

        disabledWeekdays.push(value.indx);

      }

      if (vendor_id == 0) {

        for (let x in response.adminGlobalWeekend) {

          var value = response.adminGlobalWeekend[x];

          disabledWeekdays.push(value.indx);

        }

      }

      //convert full date to day

      function convertDayName(dateString) {

        var date = new Date(dateString);

        var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        var dayName = dayNames[date.getDay()];

        return dayName;

      }



      // Booking Calender

      function onInitBookingCalendar() {

        //weekend days color change

        const weekdays = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        var disabledDayNames = [];

        disabledWeekdays.forEach(function (index) {

          disabledDayNames.push('.pignose-calendar-week-' + weekdays[index]);

        });

        disabledDayNames.forEach(function (selector) {

          $(selector).addClass('weekend');

        });



        //holiday days color change

        disabledDates.forEach(function (date) {

          // Check if any element matches the current date

          var $element = $('.pignose-calendar-unit-disabled[data-date="' + date + '"]');

          if ($element.length > 0) {

            $element.addClass('holiday');

          }

        });





        $('.pignose-calendar-top-next, .pignose-calendar-top-prev').on('click', function () {

          $('#time_next_step, #max_person_id').addClass('d-none');

          $('.booking-time-slider').empty();

        });

      }

      //initialize calender with staff holiday & vendor membership expiree date

      $('.booking-calendar').pignoseCalendar({

        init: onInitBookingCalendar,

        initialize: false,

        disabledDates: disabledDates,

        disabledWeekdays: disabledWeekdays.map(Number),

        minDate: moment().format('YYYY-MM-DD'),

        select: function (date) {

          let bookingDate = date[0]["_i"];

          var dayName = convertDayName(bookingDate);

          $(".request-loader-time").addClass("show");

          //show general time slots

          $.ajax({

            method: 'get',

            url: baseURL + '/services/show-general-hour/' + serviceId,

            data: {

              dayName: dayName,

              bookingDate: bookingDate,

              vendor_id: vendor_id,

              serviceId: serviceId,

            },

            success: function (res) {

              console.log('Date selected:', bookingDate);
              console.log('Day name:', dayName);
              console.log('Time slots response:', res);
              
              if (res) {

                $(".booking-time-slider").html(res);

                $('.request-loader-time').removeClass('show');

                $('.houre-title-1').addClass('d-none');

              } else {
                console.error('Empty response from server');
              }
            },
            error: function(xhr, status, error) {
              console.error('Error loading time slots:', error);
              console.error('Response:', xhr.responseText);
              $('.request-loader-time').removeClass('show');
            }
          });

          //service hour select - using dropdown
          $('body').on('change', '#time_slot_select', function () {
            let serviceHourId = $(this).val();

            $('#time_next_step').removeClass('d-none');
            $('#max_person_id').removeClass('d-none');
            $('#service_hour_id').val(serviceHourId);
          });

          //service hour select - using clickable buttons (legacy support)
          $('body').on('click', '.time', function () {

            $('.time').removeClass('time_active');

            $(this).addClass('time_active');



            let serviceHourId = $(this).data('id');



            $('#time_next_step').removeClass('d-none');

            $('#max_person_id').removeClass('d-none');

            $('#service_hour_id').val(serviceHourId);

          });



          //this data pass on checkout page

          $('body').on('click', '#time_next_step', function () {

            let max_person = $('#max_person').val();

            $('#booking_date').val(bookingDate);

            $('#max_person').val(max_person);

            // Set default staff ID for general booking

            $('#staff_id').val('11done');

          });



        }

      });

    },

    error: function(error) {

      $(".request-loader-time").removeClass("show");

      console.error('Error loading general calendar:', error);

    }

  });

}





/*==========reset service hour value and houre-title after click previous======*/

$('body').on('click', '#time_prev_step', function () {

  $(".booking-time-slider").html('');

  $('.houre-title-1').removeClass('d-none');

  $('#time_next_step').addClass('d-none');

});





/*=====================assing data on payment page for booking=================*/

$(document).on('keydown', function (event) {

  if (event.which == 13 && $('#billing-form input:focus').length > 0) {

    event.preventDefault();

    $(".request-loader-time").addClass("show");

    submitForm(event);

  }

});



function submitForm(event) {

  let url = $("#billing-form").attr('action');

  let method = $("#billing-form").attr('method');

  $.ajax({

    url: url,

    method: method,

    data: $('#billing-form').serialize(),

    success: function (response) {

      $(".request-loader-time").removeClass("show");

      if (response) {

        const fields = ['name', 'phone', 'email', 'address', 'zip_code', 'country'];

        fields.forEach(field => $(`#billing_${field}`).val(response[field]));



        $('#serviceHourId').val(response.service_hour_id);

        $('#bookingDate').val(response.booking_date);

        $('#staffId').val('11done'); // Set default staff ID

        $('#userId').val(response.user_id);

        $('#bmax_person').val(response.max_person);

        bookingStepper.next();

      }

    },

    error: function (error) {

      $('.em').each(function () {

        $(this).html('');

      });



      for (let x in error.responseJSON.errors) {

        document.getElementById('err_' + x).innerHTML = error.responseJSON.errors[x][0];

      }

      $(".request-loader-time").removeClass("show");

    }

  });

}



/*=====================success msg after complete payment=================*/

if (complete == 'payment_complete') {

  var id = bookingInfo.vendor_id;

  $.ajax({

    type: 'get',

    url: baseURL + '/services/payment-success/' + id,

    success: function (response) {

      $('#makeBooking').modal('show');

      $('#bookInfoShow').html(response);

      $('#confirm').addClass('active');

      $('#staff').addClass('d-none');

      $('#time').addClass('d-none');

      $('#info').addClass('d-none');

      $('#payment').addClass('d-none');

      $('.step').addClass('active');

      $('.con_user').val(id);

    }

  });

}



/*=====================forget session data after close modal=================*/

$('#makeBooking').on('hidden.bs.modal', function (e) {

  $('.request-loader-time').removeClass('show');

  $.ajax({

    type: 'post',

    url: baseURL + '/services/session/forget',

    headers: {

      'X-CSRF-TOKEN': csrfToken

    },

    success: function (response) {

    }

  });

});



/**

 * show or hide stripe gateway input fields,

 * also show or hide offline gateway informations according to checked payment gateway

 */

$('body').on('change', 'select[name="gateway"]', function () {

  $('#err_currency').html('');

  $('#stripe-errors').html('');

  $('#err_gateway').html('');

  let value = $(this).val();

  let dataType = parseInt(value);



  // Hide all gateway related elements

  $('#stripe-element, #authorizenet-element, .offline-gateway-info').addClass('d-none');



  if (isNaN(dataType)) {

    // For online gateways



    // Show or hide stripe card inputs

    if (value === 'stripe') {

      $('#stripe-element').removeClass('d-none');

    }



    // Show or hide authorize.net card inputs

    else if (value === 'authorize.net') {

      $('#authorizenet-element').removeClass('d-none');

      $("#authorizenet-element input").removeAttr('disabled');

    }

  } else {



    // Show particular offline gateway information

    $('#offline-gateway-' + value).removeClass('d-none');

  }

});



/*=====================guest checkout form=================*/

$('body').on('click', '#guest_checkout', function () {

  $('.auth-info').addClass('d-none');

  $('#billing-form').removeClass('d-none');

  $('#billingBtn').addClass('d-none');

});





$(document).ready(function () {

  // Listen for changes in the active class

  $(document).on('DOMSubtreeModified', '.step', function handler() {

    // Unbind the event handler to prevent it from being called again

    $(document).off('DOMSubtreeModified', '.step', handler);

    // $('.step').removeClass('active-prev');

    $('.step.active').each(function () {

      $(this).prevAll('.step').addClass('active-prev');

    });

    // Rebind the event handler for future changes

    $(document).on('DOMSubtreeModified', '.step', handler);

  });

});


