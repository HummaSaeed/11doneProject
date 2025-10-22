<!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/bootstrap.min.css') }}">
<!-- Data Tables CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/datatables.min.css') }}">
<!-- Fontawesome Icon CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/fonts/fontawesome/css/all.min.css') }}">
<!-- Icomoon Icon CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/fonts/icomoon/style.css') }}">
<!-- Date-range Picker -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/daterangepicker.css') }}">
{{-- whatsapp css --}}
<link rel="stylesheet" href="{{ asset('assets/css/floating-whatsapp.css') }}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/magnific-popup.min.css') }}">
<!-- Swiper Slider -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/swiper-bundle.min.css') }}">
<!-- Nice Select -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/nice-select.css') }}">
<!-- NoUi Range Slider -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/nouislider.min.css') }}">
<!--====== Stepper css ======-->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/bs-stepper.min.css') }}">
<!--====== calendar css ======-->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/pignose.calendar.min.css') }}">
<!-- AOS Animation CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/aos.min.css') }}">
<!-- map -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/leaflet.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/MarkerCluster.css') }}">
<!-- Animate CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/vendors/animate.min.css') }}">
<!-- Toaster css -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/toastr.min.css') }}">

<!-- Main Style CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/base.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/header/header.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/footer/footer.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/inner-pages.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/tinymce-content.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">
<!-- Responsive CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">
{{-- rtl css are goes here --}}
@if ($currentLanguageInfo->direction == 1)
  <link rel="stylesheet" href="{{ asset('assets/frontend/css/rtl.css') }}">
@endif

@yield('style')
