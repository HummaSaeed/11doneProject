@extends('staffs.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Plugins') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('staff.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Plugins') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
      @if($packagePersmission->calendar_status == 1)
      <div class="col-lg-4">
        <div class="card">
          <form action="{{ route('staff.update_google_calendar') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-header">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card-title">{{ __('Google Calendar') }}</div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>{{ __('Upload Your File ') . '*' }}</label>
                    <input type="file" class="form-control" name="google_calendar"
                      value="{{ !empty($data) ? $data->google_calendar : '' }}">

                    @if ($errors->has('google_calendar'))
                      <p class="mt-1 mb-0 text-danger">{{ $errors->first('google_calendar') }}</p>
                    @endif
                    @if ($data && $data->google_calendar)
                      {{ __('You have a file, and you can change it by re-uploading it.') }}<br>
                    @endif

                    <small class="text-warning">{{ __('Only json file allowed.') }}
                    </small>
                  </div>
                  <div class="form-group">
                    <label>{{ __('Calender ID') . '*' }}</label>
                    <input type="text" class="form-control" name="calender_id"
                      value="{{ !empty($data) ? $data->calender_id : '' }}">

                    @if ($errors->has('calender_id'))
                      <p class="mt-1 mb-0 text-danger">{{ $errors->first('calender_id') }}</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <div class="row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-success">
                    {{ __('Update') }}
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    @endif
  </div>
@endsection
