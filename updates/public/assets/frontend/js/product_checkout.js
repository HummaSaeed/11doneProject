"use strict";

$(document).ready(function () {
  $('#stripe-element').addClass('d-none');
})

// copy billing details values to shipping details
$('#shipping-check').on('click', function () {
  if ($(this).prop('checked')) {
    let firstName = $('input[name="billing_first_name"]').val();
    $('input[name="shipping_first_name"]').val(firstName);

    let lastName = $('input[name="billing_last_name"]').val();
    $('input[name="shipping_last_name"]').val(lastName);

    let email = $('input[name="billing_email"]').val();
    $('input[name="shipping_email"]').val(email);

    let phone = $('input[name="billing_contact_number"]').val();
    $('input[name="shipping_contact_number"]').val(phone);

    let address = $('input[name="billing_address"]').val();
    $('input[name="shipping_address"]').val(address);

    let city = $('input[name="billing_city"]').val();
    $('input[name="shipping_city"]').val(city);

    let state = $('input[name="billing_state"]').val();
    $('input[name="shipping_state"]').val(state);

    let country = $('input[name="billing_country"]').val();
    $('input[name="shipping_country"]').val(country);
  } else {
    $('input[name="shipping_first_name"]').val('');
    $('input[name="shipping_last_name"]').val('');
    $('input[name="shipping_email"]').val('');
    $('input[name="shipping_contact_number"]').val('');
    $('input[name="shipping_address"]').val('');
    $('input[name="shipping_city"]').val('');
    $('input[name="shipping_state"]').val('');
    $('input[name="shipping_country"]').val('');
  }
});


// get shipping charge by clicking on radio button
$('input[name="shipping_method').on('click', function () {
  let id = $('input[name="shipping_method"]:checked').val();
  let charge = $('input[name="shipping_method"]:checked').data('shipping_charge');
  // set the amount of selected shipping charge in 'charge summary' table
  $('.shipping-charge-amount').text(charge);

  let url = `${baseURL}/shop/put-shipping-method-id/${id}`;

  $.get(url, function (response) {
  })

  let subTotal = $('#subtotal-amount').text();
  let discount = $('#discount').text();
  if (discount.length > 0) {
    discount = discount.replace(',', '');
    discount = parseFloat(discount);
  } else {
    discount = 0.00;
  }
  let tax = $('#tax-amount').text();

  // get the new grand total
  subTotal = subTotal.replace(',', '');
  subTotal = parseFloat(subTotal);

  tax = tax.replace(',', '');
  tax = parseFloat(tax);

  charge = parseFloat(charge);

  let total = (subTotal - discount) + tax + charge;

  $('#grandtotal-amount').text(total);
});

/**
 * show or hide stripe gateway input fields,
 * also show or hide offline gateway informations according to checked payment gateway
 */
$('body').on('change', 'select[name="gateway"]',function () {
  let value = $(this).val();
  let dataType = parseInt(value);

  if (isNaN(dataType)) {
    // hide offline gateway informations
    if ($('.offline-gateway-info').hasClass('d-block')) {
      $('.offline-gateway-info').removeClass('d-block');
    }
    $('.offline-gateway-info').addClass('d-none');

    // show or hide stripe card inputs
    if (value == 'stripe') {
      $('#stripe-element').removeClass('d-none');
    } else {
      $('#stripe-element').addClass('d-none');
    }

    // show or hide authorize.net card inputs
    if (value == 'authorize.net') {
      $('#authorizenet-element').removeClass('d-none');
      $("#authorizenet-element input").removeAttr('disabled');
    } else {
      $('#authorizenet-element').addClass('d-none');
      $("#authorizenet-element input").attr('disabled');
    }
  } else {
    // hide stripe gateway card inputs
    if (!$('#stripe-element').hasClass('d-none')) {
      $('#stripe-element').addClass('d-none');
      $('#stripe-element').removeClass('d-block');
    }


    // hide offline gateway informations
    if ($('.offline-gateway-info').hasClass('d-block')) {
      $('.offline-gateway-info').removeClass('d-block');
    }

    $('.offline-gateway-info').addClass('d-none');

    // show particular offline gateway informations
    $('#offline-gateway-' + value).removeClass('d-none');
  }
});


// Attach a keypress event listener to the coupon code input field
$('#coupon-code').on('keypress', function (event) {
  // Check if the pressed key is Enter
  if (event.which == 13) { // 13 is (ASCII Code) of Enter button
    event.preventDefault();
    applyCoupon(event);
  }
});

// Your existing applyCoupon function
function applyCoupon(event) {
  event.preventDefault();

  let code = $('#coupon-code').val();

  if (code) {
    let url = `${baseURL}/shop/checkout/apply-coupon`;

    let data = {
      coupon: code,
      _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    };

    $.post(url, data, function (response) {
      if ('success' in response) {
        $('#coupon-code').val('');
        toastr['success'](response.success);

        $("#couponReload").load(location.href + " #couponReload");
      } else if ('error' in response) {
        toastr['error'](response.error);
      }
    });
  } else {
    toastr['error']('Please enter your coupon code.');
  }
}



/*-------------------------------------- Stripe Start---------------------------------------*/
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

// Add an instance of the card Element into the `card-element` div
cardElement.mount('#stripe-element');

var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
  event.preventDefault();

  if ($('#gateway').val() == 'stripe') {
    stripe.createToken(cardElement).then(function (result) {
      if (result.error) {
        // Display errors to the customer
        var errorElement = document.getElementById('stripe-errors');
        errorElement.textContent = result.error.message;
      } else {
        stripeTokenHandler(result.token);
      }
    });
  } else if ($('#gateway').val() == 'authorize.net') {
    sendPaymentDataToAnet();
  }
  else {
    $('#payment-form').submit();
  }
});

/*-------------------------------------- Authorize.Net Start---------------------------------------*/
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
