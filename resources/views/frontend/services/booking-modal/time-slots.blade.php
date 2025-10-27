@if (count($availableSlots) > 0)
  <div class="booking-time-slider">
    
    <div class="form-group mb-2">
      <select name="time_slot" id="time_slot_select" class="form-control form-select niceselect" required>
        <option value="" selected disabled>{{ __('Choose a time slot') }}</option>
        @foreach ($availableSlots as $time)
          <option value="{{ $time->id }}" data-start="{{ $time->start_time }}" data-end="{{ $time->end_time }}">
            {{ date('h:i A', strtotime($time->start_time)) }} - {{ date('h:i A', strtotime($time->end_time)) }}
          </option>
        @endforeach
      </select>
    </div>
    
    <!-- Cart Summary Section -->
    <div class="cart-summary" id="cart-summary" style="display: none;">
      <div class="summary-header">
        <h6 class="summary-title">{{ __('Booking Summary') }}</h6>
      </div>
      <div class="summary-content">
        <div class="summary-item">
          <span class="summary-label">{{ __('Service') }}:</span>
          <span class="summary-value" id="selected-service">{{ $service->title ?? 'N/A' }}</span>
        </div>
        <div class="summary-item">
          <span class="summary-label">{{ __('Date') }}:</span>
          <span class="summary-value" id="selected-date">-</span>
        </div>
        <div class="summary-item">
          <span class="summary-label">{{ __('Time') }}:</span>
          <span class="summary-value" id="selected-time">-</span>
        </div>
        <div class="summary-item">
          <span class="summary-label">{{ __('Price') }}:</span>
          <span class="summary-value" id="selected-price">{{ $service->price ?? 'N/A' }}</span>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="booking-time-slider">
    <h6 class="text-center pb-2 houre-title text-danger">{{ __('No Time Slot Available for This Date') }}</h6>
    <p class="text-center text-muted">{{ __('Please select another date') }}</p>
  </div>
@endif

@if (!empty($maxPerson))
  @if ($maxPerson > 1)
    <div class="col-lg-12  d-flex justify-content-center">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeSelect = document.getElementById('time_slot_select');
    const timeLabel = document.getElementById('time-label');
    const cartSummary = document.getElementById('cart-summary');
    
    if (timeSelect && timeLabel && cartSummary) {
        timeSelect.addEventListener('change', function() {
            if (this.value && this.value !== '') {
                // Hide the time label when time is selected
                timeLabel.style.display = 'none';
                
                // Show cart summary
                cartSummary.style.display = 'block';
                
                // Update selected time in cart
                const selectedOption = this.options[this.selectedIndex];
                const timeText = selectedOption.textContent;
                document.getElementById('selected-time').textContent = timeText;
                
                // Update selected date (get from calendar if available)
                const selectedDate = document.querySelector('.pignose-calendar-unit.pignose-calendar-unit-active');
                if (selectedDate) {
                    const dateText = selectedDate.textContent.trim();
                    const monthYear = document.querySelector('.pignose-calendar-top .pignose-calendar-month');
                    if (monthYear) {
                        const monthYearText = monthYear.textContent.trim();
                        document.getElementById('selected-date').textContent = dateText + ' ' + monthYearText;
                    }
                }
            } else {
                // Show the time label when no time is selected
                timeLabel.style.display = 'flex';
                cartSummary.style.display = 'none';
            }
        });
    }
});
</script>
