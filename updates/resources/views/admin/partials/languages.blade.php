@if (!empty($langs))
  @if (request()->input('language'))
    <select name="language" class="form-control select2"
      onchange="window.location='{{ url()->current() . '?language=' }}' + this.value">
      <option selected disabled>{{ __('Select a Language') }}</option>
      @foreach ($langs as $lang)
        <option value="{{ $lang->code }}" {{ $lang->code == request()->input('language') ? 'selected' : '' }}>
          {{ $lang->name }}
        </option>
      @endforeach
    </select>
  @else
    <select name="language" class="form-control select2"
      onchange="window.location='{{ url()->current() . '?language=' }}' + this.value">
      <option selected disabled>{{ __('Select a Language') }}</option>
      @foreach ($langs as $lang)
        <option value="{{ $lang->code }}" {{ $lang->code == $defaultLang->code ? 'selected' : '' }}>
          {{ $lang->name }}
        </option>
      @endforeach
    </select>
  @endif
@endif
