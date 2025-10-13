@if (count($availableSlots) > 0)
  <h6 class="text-center pb-20 houre-title">
    @if (count($availableSlots) > 1)
      {{ __('Available Time Slots') }}
    @else
      {{ __('Available Time Slot') }}
    @endif
  </h6>
@else
  <h6 class="text-center pb-20 houre-title">{{ __('No Time Slot Found') }}</h6>
@endif

<div class="booking-time-wrapper">
  @if (count($availableSlots) > 0)
    @foreach ($availableSlots as $time)
      <div class="item border radius-sm time" data-id="{{ $time->id }}">
        <input type="radio" class="selectgroup-input d-none" value="{{ $time->id }}" id="{{ $time->id }}" name="time">
        <div class="d-flex gap-1 align-items-center">
          <span class="start_time">{{ $time->start_time }}</span>
          {{ '-' }}
          <span class="end_time">{{ $time->end_time }}</span>
        </div>
      </div>
    @endforeach
  @endif
</div>

@if (!empty($maxPerson))
  @if ($maxPerson > 1)
    <div class="col-lg-12 mt-4 d-flex justify-content-center">
      <div class="form-group d-none col-lg-6" id="max_person_id">
        <select name="max_person" id="max_person" class="form-control form-select niceselect">
          <option selected disabled>{{ __('Number of persons') }}</option>
          @for ($i = 1; $i <= $maxPerson; $i++)
            <option value="{{ $i }}">
              {{ $i }} {{ $i === 1 ? __('Person') : __('Persons') }}
            </option>
          @endfor
        </select>
      </div>
    </div>
  @endif
@endif












