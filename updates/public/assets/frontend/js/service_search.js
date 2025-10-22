$(function ($) {
  "use strict";

  // Handle click events for ratings, service type, category toggle and sort
  $('body').on('click', '.rating', function () {
    $('#rating').val($(this).val());
    updateUrl();
  });

  $('body').on('click', '.service_type', function () {
    $('#service_type').val($(this).val());
    updateUrl();
  });

  $('body').on('keydown', '#location', function (event) {
    if (event.keyCode === 13) {
      $('#location_val').val($(this).val());
      updateUrl();
    }
  });

  $('body').on('keydown', '#search_service_title', function (event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      $('#service_title').val($(this).val());
      updateUrl();
    }
  });


  $('body').on('change', '.sort', function () {
    $('#sort_val').val($(this).val());
    updateUrl();
  });

  $('body').on('click', '.category-toggle', function () {
    let slug = $(this).data('slug');

    // Reset all other filters in a single line
    $('#rating, #service_type, #location_val, #service_title, #min_val, #max_val, #page').val('');

    // Reload the specific parts of the page
    $("#service_details").load(location.href + " #service_details > *");
    $("#rating_div").load(location.href + " #rating_div > *");
    $("#service_type_div").load(location.href + " #service_type_div > *");

    // Set the selected category and update the URL
    $('.category-toggle.active').removeClass('active');
    $(this).addClass('active');
    $('#category').val(slug);

    updateUrl();
  });



  /*============================================
       Price range
  ============================================*/
  function initializePriceSliders() {
    var range_slider_max = document.getElementById('min');
    if (range_slider_max) {
      var sliders = document.querySelectorAll("[data-range-slider='priceSlider']");
      var filterSliders = document.querySelector("[data-range-slider='filterPriceSlider']");
      var input0 = document.getElementById('min');
      var input1 = document.getElementById('max');
      var min = parseFloat(document.getElementById('min').value);
      var max = parseFloat(document.getElementById('max').value);
      var o_min = parseFloat(document.getElementById('o_min').value);
      var o_max = parseFloat(document.getElementById('o_max').value);
      var currency_symbol = document.getElementById('currency_symbol').value;
      var inputs = [input0, input1];

      // Home price slider
      sliders.forEach(function (el) {
        noUiSlider.create(el, {
          start: [min, max],
          connect: true,
          step: 10,
          margin: 0,
          range: {
            'min': o_min,
            'max': o_max
          }
        });
        el.noUiSlider.on("update", function (values, handle) {
          $("[data-range-value='priceSliderValue']").text(currency_symbol + values.join(" - " + currency_symbol));
          inputs[handle].value = values[handle];
        });
      });

      // Filter price slider
      if (filterSliders) {
        noUiSlider.create(filterSliders, {
          start: [min, max],
          connect: true,
          step: 10,
          margin: 40,
          range: {
            'min': o_min,
            'max': o_max
          }
        });

        filterSliders.noUiSlider.on("update", function (values, handle) {
          $("[data-range-value='filterPriceSliderValue']").text(currency_symbol + values.join(" - " + currency_symbol));
          $('#min_val').val(values[0]);
          $('#max_val').val(values[1]);
          inputs[handle].value = values[handle];
        });

        filterSliders.noUiSlider.on("change", function (values, handle) {
          updateUrl();
        });

        inputs.forEach(function (input, handle) {
          if (input) {
            input.addEventListener('change', function () {
              filterSliders.noUiSlider.setHandle(handle, this.value);
            });
          }
        });
      }
    }
  }

  // Function to update URL and submit form
  function updateUrl() {
    $('#searchForm').submit();
  }

  // Form submission handling
  $('#searchForm').on('submit', function (e) {
    e.preventDefault();
    var fd = $(this).serialize();
    $(".request-loader-time").addClass("show");

    $.ajax({
      url: searchUrl,
      method: "get",
      data: fd,
      contentType: false,
      processData: false,
      success: function (res) {
        $('#search_container').html(res);
        $('#total-service').text($('#countServie').val());
        $('.category_total_service').text('(' + $('#countServie').val() + ')');
      },
      complete: function () {
        $(".request-loader-time").removeClass("show");
      }
    });
  });

  // Pagination handling
  $('body').on('click', '.pagination a', function (e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    let searchParams = $('#searchForm').serialize();
    servicePage(page, searchParams);
  });

  function servicePage(page, searchParams) {
    $(".request-loader-time").addClass("show");
    $.ajax({
      url: location.href + '/service/search/?page=' + page + '&' + searchParams,
      success: function (res) {
        $(".request-loader-time").removeClass("show");
        $('#search_container').html(res);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }

  // Initialize sliders on document ready
  $(document).ready(function () {
    initializePriceSliders();
  });
});
