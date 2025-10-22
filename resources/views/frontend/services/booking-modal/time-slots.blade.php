@if (count($availableSlots) > 0)
  <h6 class="text-center pb-20 houre-title">
    {{ __('Select Your Preferred Time Slot') }}
  </h6>
  
  <div class="form-group mb-4">
    <select name="time_slot" id="time_slot_select" class="form-control form-select niceselect" required>
      <option value="" selected disabled>{{ __('Choose a time slot') }}</option>
      @foreach ($availableSlots as $time)
        <option value="{{ $time->id }}" data-start="{{ $time->start_time }}" data-end="{{ $time->end_time }}">
          {{ date('h:i A', strtotime($time->start_time)) }} - {{ date('h:i A', strtotime($time->end_time)) }}
        </option>
      @endforeach
    </select>
  </div>
@else
  <h6 class="text-center pb-20 houre-title text-danger">{{ __('No Time Slot Available for This Date') }}</h6>
  <p class="text-center text-muted">{{ __('Please select another date') }}</p>
@endif

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












