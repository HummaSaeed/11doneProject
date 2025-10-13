!(function ($) {
  "use strict";

  /*============================================
      Sticky header
  ============================================*/
  $(window).on("scroll", function () {
    var header = $(".header-area");
    // If window scroll down .is-sticky class will added to header
    if ($(window).scrollTop() >= 200) {
      header.addClass("is-sticky");
    } else {
      header.removeClass("is-sticky");
    }
  });


  /*============================================
      Mobile menu
  ============================================*/
  var mobileMenu = function () {
    // Variables
    var body = $("body"),
      mainNavbar = $(".main-navbar"),
      mobileNavbar = $(".mobile-menu"),
      cloneInto = $(".mobile-menu-wrapper"),
      cloneItem = $(".mobile-item"),
      menuToggler = $(".menu-toggler"),
      offCanvasMenu = $("#offcanvasMenu"),
      backdrop,
      _initializeBackDrop = function () {
        backdrop = document.createElement('div');
        backdrop.className = 'menu-backdrop';
        backdrop.onclick = function hideOffCanvas() {
          menuToggler.removeClass("active"),
            body.removeClass("mobile-menu-active"),
            backdrop.remove();
        };
        document.body.appendChild(backdrop);
      };

    menuToggler.on("click", function () {
      $(this).toggleClass("active");
      body.toggleClass("mobile-menu-active");
      _initializeBackDrop();
      if (!body.hasClass("mobile-menu-active")) {
        $('.menu-backdrop').remove();
      }
    })

    mainNavbar.find(cloneItem).clone(!0).appendTo(cloneInto);

    if (offCanvasMenu) {
      body.find(offCanvasMenu).clone(!0).appendTo(cloneInto);
    }

    mobileNavbar.find("li").each(function (index) {
      var toggleBtn = $(this).children(".toggle")
      toggleBtn.on("click", function (e) {
        $(this)
          .parent("li")
          .children("ul")
          .stop(true, true)
          .slideToggle(350);
        $(this).parent("li").toggleClass("show");
      })
    })

    // check browser width in real-time
    var checkBreakpoint = function () {
      var winWidth = window.innerWidth;
      if (winWidth <= 1199) {
        mainNavbar.hide();
        mobileNavbar.show()
      } else {
        mainNavbar.show();
        mobileNavbar.hide();
        $('.menu-backdrop').remove();
      }
    }
    checkBreakpoint();

    $(window).on('resize', function () {
      checkBreakpoint();
    });
  }
  mobileMenu();

  var getHeaderHeight = function () {
    var headerNext = $(".header-next");
    var header = headerNext.prev(".header-area");
    var headerHeight = header.height();

    headerNext.css({
      "margin-top": headerHeight
    })
  }
  getHeaderHeight();

  $(window).on('resize', function () {
    getHeaderHeight();
  });


  /*============================================
          Navlink active class
      ============================================*/
  var a = $("#mainMenu .nav-link"),
    c = window.location;

  for (var i = 0; i < a.length; i++) {
    const el = a[i];

    if (el.href == c) {
      el.classList.add("active");
    }
  }


  /*============================================
      Sticky sidebar
  ============================================*/
  $(window).on("scroll", function () {
    if ($(".sticky-sidebar").length) {
      var headerHeight = $("header").height();
      var sidebarOffsetTop = $(".sticky-sidebar").offset().top;
      if ($(window).scrollTop() >= sidebarOffsetTop - headerHeight) {
        $(".sticky-sidebar").addClass("sticky").css("top", headerHeight + "px");
      } else {
        $(".sticky-sidebar").removeClass("sticky").css("top", "0");
      }
    }
  });


  /*============================================
      Image to background image
  ============================================*/
  var bgImage = $(".bg-img")
  bgImage.each(function () {
    var el = $(this),
      src = el.attr("data-bg-image");

    el.css({
      "background-image": "url(" + src + ")",
      "background-repeat": "no-repeat"
    });
  });


  /*============================================
      Tabs mouse hover animation
  ============================================*/
  $("[data-hover='fancyHover']").mouseHover();


  /*============================================
      Sliders
  ============================================*/
  // Category Slider all
  $(".category-slider").each(function () {
    var id = $(this).attr("id");
    var slidePerView = $(this).data("slides-per-view");
    var loops = $(this).data("swiper-loop");
    var sliderId = "#" + id;


    var swiper = new Swiper(sliderId, {
      loop: loops,
      spaceBetween: 24,
      speed: 1000,
      autoplay: {
        delay: 3000,
      },
      slidesPerView: slidePerView,
      pagination: true,

      pagination: {
        el: sliderId + "-pagination",
        clickable: true,
      },

      // Navigation arrows
      navigation: {
        nextEl: sliderId + "-next",
        prevEl: sliderId + "-prev",
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
        1440: {
          slidesPerView: slidePerView
        },
      }
    })
  })

  // category Slider 2
  let options = {
    speed: 1000,
    centeredSlides: true,
    initialSlide: 2,
    spaceBetween: 30,
    autoplay: true,
    autoplay: {
      delay: 3000,
    },

    pagination: {
      el: ".category-2-pagination",
      clickable: true,
    },

    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      576: {
        centeredSlides: false,
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 5
      },
    }
  }
  var categorySliderLength = $(".category-slider-2 .swiper-slide");

  // check browser width in real-time
  var categorySlider2Breakpoint = function () {
    var winWidth = window.innerWidth;
    if (winWidth > 1199) {
      switch (true) {
        case categorySliderLength.length == 4:
          options.initialSlide = 0,
            options.centeredSlides = false;

          $(".category-slider-2 .swiper-wrapper").css({
            "justify-content": "center"
          });
          $(".category-slider-2 .swiper-slide").css({
            "transform": "none"
          });
          break;
        case categorySliderLength.length <= 3:
          options.initialSlide = 1,
            options.centeredSlides = true,
            options.spaceBetween = 40;
          break;
        case categorySliderLength.length <= 5:
          options.pagination = false,
            options.allowSlideNext = false,
            options.allowSlidePrev = false;
          break;
      }
    }
  }
  categorySlider2Breakpoint();
  var categorySlider2 = new Swiper(".category-slider-2", options);

  // Works slider
  var workSlider = new Swiper("#works-slider-1", {
    spaceBetween: 30,
    speed: 1000,
    autoplay: {
      delay: 3000,
    },
    slidesPerView: 2,
    pagination: true,

    pagination: {
      el: "#works-slider-1-pagination",
      clickable: true,
    },

    breakpoints: {
      320: {
        slidesPerView: 1
      },
      576: {
        slidesPerView: 2
      },
      1200: {
        slidesPerView: 2
      },
    }
  })

  // Product slider
  $(".product-slider").each(function () {
    var id = $(this).attr("id");
    var slidePerView = $(this).data("slides-per-view");
    var loops = $(this).data("swiper-loop");
    var sliderId = "#" + id;

    var swiper = new Swiper(sliderId, {
      loop: loops,
      spaceBetween: 24,
      speed: 1000,
      autoplay: {
        delay: 3000,
      },
      slidesPerView: slidePerView,
      pagination: true,

      pagination: {
        el: sliderId + "-pagination",
        clickable: true,
      },

      // Navigation arrows
      navigation: {
        nextEl: sliderId + "-next",
        prevEl: sliderId + "-prev",
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
        1440: {
          slidesPerView: slidePerView
        },
      }
    })
  })
  // Product slider
  $(".product-inline-slider").each(function () {
    var id = $(this).attr("id");
    var slidePerView = $(this).data("slides-per-view");
    var loops = $(this).data("swiper-loop");
    var sliderId = "#" + id;

    var swiper = new Swiper(sliderId, {
      loop: loops,
      spaceBetween: 24,
      speed: 1000,
      autoplay: {
        delay: 3000,
      },
      slidesPerView: slidePerView,
      pagination: true,

      pagination: {
        el: sliderId + "-pagination",
        clickable: true,
      },

      // Navigation arrows
      navigation: {
        nextEl: sliderId + "-next",
        prevEl: sliderId + "-prev",
      },

      breakpoints: {
        320: {
          slidesPerView: 1
        },
        576: {
          slidesPerView: 2
        },
        1200: {
          slidesPerView: slidePerView
        },
      }
    })
  })

  // Shop single slider
  var proSingleThumb = new Swiper(".slider-thumbnails", {
    loop: true,
    speed: 1000,
    spaceBetween: 20,
    slidesPerView: 4
  });
  var proSingleSlider = new Swiper(".product-single-slider", {
    loop: true,
    speed: 1000,
    autoplay: {
      delay: 3000
    },
    effect: 'fade',
    fadeEffect: {
      crossFade: true
    },
    watchSlidesProgress: true,
    thumbs: {
      swiper: proSingleThumb,
    },

    // Navigation arrows
    navigation: {
      nextEl: "#product-single-btn-next",
      prevEl: "#product-single-btn-prev",
    },
  });

  // Testimonial Slider 1
  var testimonialSlider1 = new Swiper("#testimonial-slider-1", {
    speed: 1000,
    slidesPerView: 1,
    loop: true,
    grabCursor: true,
    spaceBetween: 30,
    autoplay: {
      delay: 3000,
    },

    // Pagination bullets
    pagination: {
      el: "#testimonial-slider-1-pagination",
      clickable: true,
    },
  });

  /*============================================
      Parallax image
  ============================================*/
  var parallax = $('.parallax');

  parallax.each(function () {
    $(this).mousemove(function (e) {
      var wx = $(window).width();
      var wy = $(window).height();
      var x = e.pageX - this.offsetLeft;
      var y = e.pageY - this.offsetTop;
      var newx = x - wx / 2;
      var newy = y - wy / 2;

      var parallaxChild = $(this).find('.parallax-img');
      parallaxChild.each(function () {
        var speed = $(this).attr('data-speed');
        if ($(this).attr('data-revert')) speed *= -.2;
        TweenMax.to($(this), 1, {
          x: (1 - newx * speed),
          y: (1 - newy * speed)
        });
      });
    });
  })



  /*============================================
      Date-range Picker
  ============================================*/
  $('input[name="bookDate"]').daterangepicker({
    "showDropdowns": true,
    minDate: moment(),
    opens: 'left',
    "singleDatePicker": true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  })
  $('input[name="bookTime"]').daterangepicker({
    opens: 'left',
    timePicker: true,
    "singleDatePicker": true,
    timePickerIncrement: 1,
    locale: {
      format: 'hh:mm A'
    }
  }).on('show.daterangepicker', function (ev, picker) {
    picker.container.find(".calendar-table").hide();
  });



  /*============================================
      Quantity button
  ============================================*/
  $(document).on('click', '.quantity-down', function () {
    var numProduct = Number($(this).next().val());
    if (numProduct > 0) $(this).next().val(numProduct - 1);
  });
  $(document).on('click', '.quantity-up', function () {
    var numProduct = Number($(this).prev().val());
    $(this).prev().val(numProduct + 1);
  })


  /*============================================
      Read more toggle button
  ============================================*/
  $(".read-more-btn").on("click", function () {
    $(this).parent().toggleClass('show');
  })


  /*============================================
      Toggle List
  ============================================*/
  $("#toggleList").each(function (i) {
    var list = $(this).children();
    var listShow = $(this).data("toggle-show");
    var listShowBtn = $(this).next("[data-toggle-btn]");

    if (list.length > listShow) {
      listShowBtn.show()
      list.slice(listShow).toggle(300);

      listShowBtn.on("click", function () {
        list.slice(listShow).slideToggle(300);
        $(this).text($(this).text() === "Show Less" ? "Show More +" : "Show Less -")
      })
    } else {
      listShowBtn.hide()
    }
  })

  /*============================================
      Pricing Toggle List
  ============================================*/
  $("[data-toggle-list]").each(function (i) {
    var list = $(this).children();
    var listShow = $(this).data("toggle-show");
    var listShowBtn = $(this).next("[data-toggle-btn]");

    if (list.length > listShow) {
      listShowBtn.show()
      list.slice(listShow).toggle(300);

      listShowBtn.on("click", function () {
        list.slice(listShow).slideToggle(300);
        $(this).text($(this).text() === "Show Less" ? "Show More +" : "Show Less -")
      })
    } else {
      listShowBtn.hide()
    }
  })


  /*============================================
      Sidebar scroll
  ============================================*/
  $(document).ready(function () {
    $(".widget").each(function () {
      var child = $(this).find(".accordion-body.scroll-y");
      if (child.height() >= 245) {
        child.css({
          "padding-inline-end": "10px",
        })
      }
    })
  })


  /*============================================
      Password icon toggle
  ============================================*/
  $(".show-password-field").on("click", function () {
    var showIcon = $(this).children(".show-icon");
    var passwordField = $(this).prev("input");
    showIcon.toggleClass("show");
    if (passwordField.attr("type") == "password") {
      passwordField.attr("type", "text")
    } else {
      passwordField.attr("type", "password");
    }
  })


  /*============================================
      Data tables
  ============================================*/
  var dataTable = function () {
    var dTable = $("#myTable");

    if (dTable.length) {
      dTable.DataTable()
    }
  }


  /*============================================
      Image upload
  ============================================*/
  var fileReader = function (input) {
    var regEx = new RegExp(/\.(gif|jpe?g|tiff?|png|webp|bmp)$/i);
    var errorMsg = $("#errorMsg");

    if (input.files && input.files[0] && regEx.test(input.value)) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
        $('#imagePreview').hide();
        $('#imagePreview').fadeIn(650);
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      errorMsg.html("Please upload a valid file type")
    }
  }
  $("#imageUpload").on("change", function () {
    fileReader(this);
  });


  /*============================================
      Product single popup
  ============================================*/
  $(".lightbox-single").magnificPopup({
    type: "image",
    mainClass: 'mfp-with-zoom',
    gallery: {
      enabled: true
    }
  });


  /*============================================
      Go to top
  ============================================*/
  $(".go-top").on("click", function (e) {
    $("html, body").animate({
      scrollTop: 0,
    }, 0);
  });


  /*============================================
      Lazyload image
  ============================================*/
  var lazyLoad = function () {
    window.lazySizesConfig = window.lazySizesConfig || {};
    window.lazySizesConfig.loadMode = 2;
    lazySizesConfig.preloadAfterLoad = true;

    var lazyContainer = $(".lazy-container");

    if (lazyContainer.children(".lazyloaded")) {
      lazyContainer.addClass("lazy-active")
    } else {
      lazyContainer.removeClass("lazy-active")
    }
  }


  /*============================================
      Nice select
  ============================================*/
  $(".niceselect").niceSelect();

  var selectList = $(".nice-select .list")
  $(".nice-select .list").each(function () {
    var list = $(this).children();
    if (list.length > 5) {
      $(this).css({
        "height": "160px",
        "overflow-y": "scroll"
      })
    }
  })


  /*============================================
      Footer date
  ============================================*/
  var date = new Date().getFullYear();
  $("#footerDate").text(date);


  /*============================================
      Document on ready
  ============================================*/
  $(document).ready(function () {
    lazyLoad();
  });

  // format date & time for announcement popup
  $('.offer-timer').each(function () {
    let $this = $(this);

    let date = new Date($this.data('end_date'));
    let year = parseInt(new Intl.DateTimeFormat('en', {
      year: 'numeric'
    }).format(date));
    let month = parseInt(new Intl.DateTimeFormat('en', {
      month: 'numeric'
    }).format(date));
    let day = parseInt(new Intl.DateTimeFormat('en', {
      day: '2-digit'
    }).format(date));

    let time = $this.data('end_time');
    time = time.split(':');
    let hour = parseInt(time[0]);
    let minute = parseInt(time[1]);

    $this.syotimer({
      year: year,
      month: month,
      day: day,
      hour: hour,
      minute: minute
    });
  });
})(jQuery);

$(window).on("load", function () {
  const delay = 1000;
  /*============================================
      Preloader
  ============================================*/
  $("#preLoader").delay(delay).fadeOut();

  /*============================================
      Aos animation
  ============================================*/
  var aosAnimation = function () {
    AOS.init({
      easing: "ease",
      duration: 1200,
      once: true,
      offset: 60,
      disable: 'mobile'
    });
  }
  if ($("#preLoader")) {
    setTimeout(() => {
      aosAnimation()
    }, delay);
  } else {
    aosAnimation();
  }
})

$(window).on('load', function () {
  'use strict';

  //===== Popup
  if ($('.popup-wrapper').length > 0) {
    let $firstPopup = $('.popup-wrapper').eq(0);

    appearPopup($firstPopup);
  }
});

function appearPopup($this) {
  'use strict';
  let closedPopups = [];

  if (localStorage.getItem('closedPopups')) {
    closedPopups = JSON.parse(localStorage.getItem('closedPopups'));
  }

  // if the popup is not in closedPopups Array
  if (closedPopups.indexOf($this.data('popup_id')) == -1) {
    $('#' + $this.attr('id')).show();

    let popupDelay = $this.data('popup_delay');

    setTimeout(function () {
      jQuery.magnificPopup.open({
        items: {
          src: '#' + $this.attr('id')
        },
        type: 'inline',
        callbacks: {
          afterClose: function () {
            // after the popup is closed, store it in the localStorage & show next popup
            closedPopups.push($this.data('popup_id'));
            localStorage.setItem('closedPopups', JSON.stringify(closedPopups));

            // Schedule the deletion of the popup from localStorage after 24 hours
            setTimeout(function () {
              deleteFromLocalStorage($this.data('popup_id'));
            }, 86400000); // 24 hours in milliseconds

            if ($this.next('.popup-wrapper').length > 0) {
              appearPopup($this.next('.popup-wrapper'));
            }
          }
        }
      }, 0);
    }, popupDelay);
  } else {
    if ($this.next('.popup-wrapper').length > 0) {
      appearPopup($this.next('.popup-wrapper'));
    }
  }
}

function deleteFromLocalStorage(popupId) {
  'use strict';
  let closedPopups = JSON.parse(localStorage.getItem('closedPopups')) || [];
  let index = closedPopups.indexOf(popupId);

  if (index > -1) {
    closedPopups.splice(index, 1);
    localStorage.setItem('closedPopups', JSON.stringify(closedPopups));
  }
}


// count total view of an advertisement
function adView($id) {
  'use strict';
  let url = baseURL + '/advertisement/' + $id + '/count-view';

  let data = {
    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  };

  $.post(url, data, function (response) {
    if ('success' in response) { } else { }
  });
}
