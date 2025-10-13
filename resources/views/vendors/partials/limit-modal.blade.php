@if ($currentPackage)
  @php
    $vendor_id = Auth::guard('vendor')->user()->id;
  @endphp
  <!-- show limit check Modal -->
  <div class="modal fade" id="limitModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="page-title" id="exampleModalLabel"><span>{{ __('All Limits') }}</span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item  border">
              <div class="d-flex justify-content-between">
                <span>
                  @if ($totalServices > $currentPackage->number_of_service_add)
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                  @endif
                  {{ __('Services Left') }} :
                </span>
                @if ($currentPackage->number_of_service_add < 999999)
                  @if ($services == 0)
                    <span class="mx-2 d-inline-block text-danger">{{ __('Limit Reached') }}</span>
                  @elseif($totalServices > $currentPackage->number_of_service_add)
                    <span class="mx-2 d-inline-block text-danger">
                      {{ __('Exceeding Limits') }}
                    </span>
                  @endif
                @endif

                @if ($currentPackage->number_of_service_add < 999999)
                  <span
                    class="badge @if ($totalServices > $currentPackage->number_of_service_add) badge-danger @elseif($services == 0) badge-warning @else badge-primary @endif badge-sm">
                    @if ($totalServices > $currentPackage->number_of_service_add)
                      0
                    @else
                      {{ $services }}
                    @endif

                  </span>
                @else
                  <span class="mx-2 d-inline-block badge badge-success badge-pill">
                    {{ __('Unlimited') }}</span>
                @endif
              </div>
              @if ($totalServices > $currentPackage->number_of_service_add)
                <span class="text-danger">{{ __('You need to delete') }}
                  {{ $totalServices - $currentPackage->number_of_service_add }} {{ __('service') }}</span>
              @endif
            </li>

            <li class="list-group-item  border">
              <div class="d-flex justify-content-between">

                <span>
                  @if (vendorTotalAddedStaff($vendor_id) > $currentPackage->staff_limit)
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                  @endif
                  {{ __('Staffs Left') }} :
                </span>
                @if ($currentPackage->staff_limit < 999999)
                  @if ($staffs == 0)
                    <span class="mx-2 d-inline-block text-danger">{{ __('Limit Reached') }}</span>
                  @elseif(vendorTotalAddedStaff($vendor_id) > $currentPackage->staff_limit)
                    <span class="mx-2 d-inline-block text-danger">
                      {{ __('Exceeding Limits') }}
                    </span>
                  @endif
                @endif

                @if ($currentPackage->staff_limit < 999999)
                  <span
                    class="badge @if (vendorTotalAddedStaff($vendor_id) > $currentPackage->staff_limit) badge-danger @elseif($staffs == 0) badge-warning @else badge-primary @endif badge-sm">
                    @if (vendorTotalAddedStaff($vendor_id) > $currentPackage->staff_limit)
                      0
                    @else
                      {{ $staffs }}
                    @endif
                  </span>
                @else
                  <span class="mx-2 d-inline-block badge badge-success badge-pill">
                    {{ __('Unlimited') }}</span>
                @endif
              </div>
              @if (vendorTotalAddedStaff($vendor_id) > $currentPackage->staff_limit)
                <span class="text-danger">{{ __('You need to delete') }}
                  {{ vendorTotalAddedStaff($vendor_id) - $currentPackage->staff_limit }} {{ __('staff') }}</span>
              @endif
            </li>


            <li class="list-group-item  border  d-flex   justify-content-between">
              <span>
                @if ($appointments < 0)
                  <i class="fas fa-exclamation-triangle text-danger"></i>
                @endif
                {{ __('Appointments Left') }} :
              </span>
              @if ($currentPackage->number_of_appointment < 999999)
                @if ($appointments == 0)
                  <span class="mx-2 d-inline-block text-danger">{{ __('Limit Reached') }}</span>
                @elseif($appointments < 0)
                  <span class="mx-2 d-inline-block text-danger">
                    {{ __('Appointments Left') }}
                  </span>
                @endif
              @endif

              @if ($currentPackage->number_of_appointment < 999999)
                <span
                  class="badge @if ($appointments < 0) badge-danger @elseif($appointments == 0) badge-warning @else badge-primary @endif badge-sm">
                  @if ($appointments < 0)
                    0
                  @else
                    {{ $appointments }}
                  @endif
                </span>
              @else
                <span class="mx-2 d-inline-block badge badge-success badge-pill">
                  {{ __('Unlimited') }}</span>
              @endif
            </li>


            <li class="list-group-item  border  d-flex   justify-content-between">
              <span>
                @if ($imageLimitCount > 0)
                  <i class="fas fa-exclamation-triangle text-danger"></i>
                @endif
                {{ __('Images Limit') }} ({{ __('per service') }}):
              </span>
              @if ($currentPackage->number_of_service_image < 999999)
                @if ($imageLimitCount == 0)
                  <span class="badge badge-primary">
                    {{ $currentPackage->number_of_service_image }}
                  </span>
                @else
                  <button class="btn btn-danger btn-sm" data-toggle="modal"
                    data-target="#imageModal">{{ __('Remove') }}</button>
                @endif
              @else
                <span class="mx-2 d-inline-block badge badge-success badge-pill">
                  {{ __('Unlimited') }}</span>
              @endif
            </li>


            @if ($currentPackage->zoom_meeting_status == 1)
              <li class="list-group-item  border  d-flex   justify-content-between">
                <span>{{ __('Zoom Meeting') }} : </span>
                <span class="mx-2 d-inline-block badge badge-success badge-pill">
                  {{ __('Enabled') }}</span>
              </li>
            @endif
            @if ($currentPackage->support_ticket_status == 1)
              <li class="list-group-item  border  d-flex   justify-content-between">
                <span>{{ __('Support Tickets') }}: </span>
                <span class="mx-2 d-inline-block badge badge-success badge-pill">
                  {{ __('Enabled') }}</span>
              </li>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- show image limit check modal -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="page-title" id="exampleModalLabel"><span>{{ __('Remove Image From Service') }}</span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            @foreach ($serviceIds as $id)
              @php
                $service = \App\Models\Services\ServiceContent::where('service_id', $id)
                    ->where('language_id', $defaultLang->id)
                    ->first();
              @endphp

              @if ($service)
                <li class="list-group-item border d-flex justify-content-between align-items-center">
                  <a href="{{ route('vendor.service_managment.edit', $id) }}">
                    {{ $service->name }}
                  </a>
                  <i class="fas fa-paperclip"></i>
                </li>
              @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endif
