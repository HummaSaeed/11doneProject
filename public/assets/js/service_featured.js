"use strict";

$(function () {
  $('body').on('click', '.featured', function () {
    let id = $(this).data('id');
    $("#featured").modal('show');
    $('#service_id').val(id);

    // Select payment method
    $('body').on('change', 'select[name="gateway"]', function () {
      let value = $(this).val();
      let dataType = parseInt(value);

      // Hide all gateway related elements
      $('#stripe-element, #authorizenet-element, .offline-gateway-info').addClass('d-none');

      if (isNaN(dataType)) {
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

    // Submit payment form
    $("#payment-form").on('submit', function (event) {
      $(event.target).attr('disabled', true);
      $(".request-loader").addClass('show');
      event.preventDefault();

      // Validate the form fields
      if ($('#gateway').val() == 'stripe') {
        stripe.createToken(cardElement).then(function (result) {
          if (result.error) {
            // Display errors to the customer
            var errorElement = document.getElementById('stripe-errors');
            errorElement.textContent = result.error.message;
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
          $(event.target).attr('disabled', false);
          $(".request-loader").removeClass('show');
          if (data.redirectURL) {
            window.location.href = data.redirectURL;
          } else {
            $('#razorPayForm').html(data);
            // If no redirect URL, remove loader and enable button
            $(e.target).attr('disabled', true);
            $('.request-loader').removeClass('show');
          }

          $('.em').each(function () {
            $(this).html('');
          });
        },
        error: function (error) {
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

          $('.request-loader').removeClass('show');
          $(e.target).attr('disabled', false);
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
        $("#authorizeNetErrors").show();
        $("#authorizeNetErrors").html(errorLists);
      } else {
        paymentFormUpdate(response.opaqueData);
      }
    }

    function paymentFormUpdate(opaqueData) {
      document.getElementById("opaqueDataDescriptor").value = opaqueData.dataDescriptor;
      document.getElementById("opaqueDataValue").value = opaqueData.dataValue;
      document.getElementById("payment-form").submit();
    }
  });
});
