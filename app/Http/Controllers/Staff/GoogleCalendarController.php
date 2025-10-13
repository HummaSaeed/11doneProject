<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontEnd\MiscellaneousController;
use App\Models\Services\ServiceContent;
use App\Models\Staff\Staff;
use App\Models\Staff\StaffPlugin;
use Carbon\Carbon;
use DB;
use Google\Client as Google_Client;
use Google\Service\Calendar;

class GoogleCalendarController extends Controller
{
  public function createEvent($data)
  {
    try {
      $misc = new MiscellaneousController();
      $language = $misc->getLanguage();
      $language_id = $language->id;

      $bs = DB::table('basic_settings')->select('timezone')->first();

      // Parse dates with explicit time zone
      $startTime = Carbon::parse($data['start_date'])->setTimezone($bs->timezone);
      $endTime = Carbon::parse($data['end_date'])->setTimezone($bs->timezone);

      // Keep the original date unchanged
      $dateForCalendar = Carbon::parse($data['booking_date'])->setTimezone($bs->timezone);

      $dateForCalendar->setTime($startTime->hour, $startTime->minute, 0);
      $endTime = $dateForCalendar->copy()->setTime($endTime->hour, $endTime->minute, 0);

      $formatStartTime = $dateForCalendar->format('Y-m-d\TH:i:sP');
      $formatEndTime = $endTime->format('Y-m-d\TH:i:sP');

      //find service title
      $service_id = $data['service_id'];
      $serviceContent = ServiceContent::where('service_id', $service_id)
        ->first();
      $topicName = $serviceContent->name;

      //staff content
      $staff = Staff::with(['staffContent' => function ($q) use ($language_id) {
        $q->where('language_id', $language_id);
      }])->findOrFail($data['staff_id']);

      $client = new Google_Client();
      $client->setApplicationName("My Application");
      $client->setScopes([Calendar::CALENDAR]);

      $calenderInfo = StaffPlugin::where('staff_id', $data['staff_id'])->select('google_calendar', 'calender_id')->first();


      $client->setAuthConfig(public_path('assets/file/calendar/' . $calenderInfo->google_calendar));

      $calendarService = new Calendar($client);

      $event = new Calendar\Event([
        'summary' => $topicName,
        'location' => 'Online',
        'description' => "Customer Name: " . $data['customer_name'] . "<br>Customer Email: " . $data['customer_email'] . "<br>Customer Phone: " . $data['customer_phone'] . "<br>Staff Name: " . $staff->staffContent->first()->name . "<br>Staff Email: " . $staff->email,
        'start' => [
          'dateTime' => $formatStartTime,
          'timeZone' => $bs->timezone,
        ],
        'end' => [
          'dateTime' => $formatEndTime,
          'timeZone' => $bs->timezone,
        ],
      ]);

      $event = $calendarService->events->insert($calenderInfo->calender_id, $event);
      session()->put('calendarInfo', $event->getId());

      return response()->json($event);
    } catch (\Exception $e) {
      session()->flash('error', 'Calendar event not created.');
    }
  }
}
