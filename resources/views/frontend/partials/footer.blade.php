    <!-- Footer-area start -->
    @if ($secInfo->footer_section_status == 1)
      <footer class="footer-area bg-primary-light">
        <div class="go-top"><i class="fal fa-long-arrow-up"></i></div>
        <div class="footer-top pt-100 pb-70 text-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-5">
                <div class="navbar-brand mt-10">
                  <span></span>
                  @if (!empty($basicInfo->footer_logo))
                    <a href="{{ route('index') }}" target="_self" title="Link">
                      <img src="{{ asset('assets/admin/img/footer/' . $basicInfo->footer_logo) }}" alt="Brand Logo">
                    </a>
                  @endif
                  <span></span>
                </div>
                <ul class="info-list mt-20">
                  @if (!empty($basicInfo->email_address))
                    <li>

                      <a href="mailto:{{ $basicInfo->email_address }}">{{ $basicInfo->email_address }}</a>
                    </li>
                  @endif
                  @if (!empty($basicInfo->contact_number))
                    <li>

                      <a href="tel:{{ $basicInfo->contact_number }}">{{ $basicInfo->contact_number }}</a>
                    </li>
                  @endif
                </ul>
                @if (count($socialMediaInfos) > 0)
                  <div class="social-link mt-20">
                    @foreach ($socialMediaInfos as $socialMediaInfo)
                    @php
       // Extract the main name from 'fa-xyz'
        $iconParts = explode('-', $socialMediaInfo->icon);
        $iconName = isset($iconParts[1]) ? ucfirst($iconParts[1]) : '';
      @endphp
                      <a href="{{ $socialMediaInfo->url }}" target="_blank" title="{{ ucfirst($iconName) }}"><i
                          class="{{ $socialMediaInfo->icon }}"></i></a>
                    @endforeach
                  </div>
                @endif
                <div class="newsletter-form mx-auto mt-30">
                  <form id="newsletterForm" class="subscription-form" action="{{ route('store_subscriber') }}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                      <input class="form-control" placeholder="{{ __('Enter email') }}" type="email" name="email_id"
                        required="" autocomplete="off">
                      <button class="btn btn-md btn-primary btn-gradient no-animation"
                        type="submit">{{ __('Subscribe') }}</button>
                    </div>
                  </form>
                </div>
                <ul class="footer-links list-unstyled mt-30">
                  @foreach ($quickLinkInfos as $quickLinkInfo)
                    <li>
                      <a href="{{ $quickLinkInfo->url }}">{{ $quickLinkInfo->title }}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="copy-right-area border-top ptb-30">
          <div class="container">
            <div class="copy-right-content">
              <span>
                {!! @$footerInfo->copyright_text !!}
              </span>
            </div>
          </div>
        </div>
      </footer>
      <!-- Footer-area end-->
    @endif
    <!-- Add Review Modal Start -->
    @include('frontend.services.booking-modal.modal-page')
    <!-- Add Review Modal End -->
