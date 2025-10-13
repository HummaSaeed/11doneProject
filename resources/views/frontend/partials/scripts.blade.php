<script>
  'use strict';
  const baseURL = "{{ url('/') }}";
  const all_model = "{{ __('All') }}";
  const read_more = "{{ __('Read More') }}";
  const read_less = "{{ __('Read Less') }}";
  const show_more = "{{ __('Show More') . '+' }}";
  const show_less = "{{ __('Show Less') . '-' }}";
  const langDir = "{{ $currentLanguageInfo->direction }}";
  var vapid_public_key = "{!! env('VAPID_PUBLIC_KEY') !!}";
  let bookingUnableText =
    "{{ __('We regret to inform you that the service you are trying to book is currently unavailable. Please contact our support team for further assistance') }}";
</script>
<!-- Jquery JS -->
<script src="{{ asset('assets/frontend/js/vendors/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/frontend/js/vendors/bootstrap.min.js') }}"></script>
<!-- Data Tables JS -->
<script src="{{ asset('assets/frontend/js/vendors/datatables.min.js') }}"></script>
<!-- Date-range Picker JS -->
<script src="{{ asset('assets/frontend/js/vendors/moment.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/vendors/daterangepicker.js') }}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('assets/frontend/js/vendors/jquery.nice-select.min.js') }}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('assets/frontend/js/vendors/jquery.magnific-popup.min.js') }}"></script>
<!-- Calendar js -->
<script src="{{ asset('assets/frontend/js/vendors/pignose.calendar.full.min.js') }}"></script>
<!-- Swiper Slider JS -->
<script src="{{ asset('assets/frontend/js/vendors/swiper-bundle.min.js') }}"></script>
<!-- Lazysizes -->
<script src="{{ asset('assets/frontend/js/vendors/lazysizes.min.js') }}"></script>
<!-- Noui Range Slider JS -->
<script src="{{ asset('assets/frontend/js/vendors/nouislider.min.js') }}"></script>
<!-- Twinmax JS -->
<script src="{{ asset('assets/frontend/js/vendors/tweenMax.min.js') }}"></script>
<!-- Simple Parallax JS -->
<script src="{{ asset('assets/frontend/js/vendors/parallax.min.js') }}"></script>
<!-- AOS JS -->
<script src="{{ asset('assets/frontend/js/vendors/aos.min.js') }}"></script>
<!-- Mouse Hover JS -->
<script src="{{ asset('assets/frontend/js/vendors/mouse-hover-move.js') }}"></script>
<!-- toastr js -->
<script src="{{ asset('assets/frontend/js/toastr.min.js') }}"></script>
<!-- Stepper js -->
<script src="{{ asset('assets/frontend/js/vendors/bs-stepper.min.js') }}"></script>
<!-- syotimer js -->
<script src="{{ asset('assets/frontend/js/vendors/jquery.syotimer.min.js') }}"></script>
<!-- Main script JS -->
<script src="{{ asset('assets/frontend/js/script.js') }}"></script>
{{-- whatsapp js --}}
<script src="{{ asset('assets/js/floating-whatsapp.js') }}"></script>
<script src="{{ asset('assets/frontend/js/svg-loader.min.js') }}"></script>

{{-- whatsapp init code --}}
@if ($basicInfo->whatsapp_status == 1)
  <script type="text/javascript">
    var whatsapp_popup = "{{ $basicInfo->whatsapp_popup_status }}";
    var whatsappImg = "{{ asset('assets/img/whatsapp.svg') }}";

    $(function() {
      $('#WAButton').floatingWhatsApp({
        phone: "{{ $basicInfo->whatsapp_number }}", //WhatsApp Business phone number
        headerTitle: "{{ $basicInfo->whatsapp_header_title }}", //Popup Title
        popupMessage: `{!! nl2br($basicInfo->whatsapp_popup_message) !!}`, //Popup Message
        showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
        buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
        position: "right" //Position: left | right
      });
    });
  </script>
@endif
<!--Start of Tawk.to Script-->
@if ($basicInfo->tawkto_status == 1)
  <script src="{{ asset('assets/frontend/js/tawk-to.js') }}"></script>
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();

    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = 'https://embed.tawk.to/{{ $basicInfo->tawkto_direct_chat_link }}/default';
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
@endif
<!--End of Tawk.to Script-->

@yield('script')
@if (session()->has('success'))
  <script>
    "use strict";
    toastr['success']("{{ __(session('success')) }}");
  </script>
@endif

@if (session()->has('error'))
  <script>
    "use strict";
    toastr['error']("{{ __(session('error')) }}");
  </script>
@endif
@if (session()->has('warning'))
  <script>
    "use strict";
    toastr['warning']("{{ __(session('warning')) }}");
  </script>
@endif
