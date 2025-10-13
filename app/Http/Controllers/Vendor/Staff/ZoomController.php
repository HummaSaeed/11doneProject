<?php

namespace App\Http\Controllers\Vendor\Staff;

use App\Http\Controllers\Controller;
use App\Models\Services\ServiceContent;
use App\Models\VendorPlugins\VendorPlugin;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Session;
use Illuminate\Support\Str;

class ZoomController extends Controller
{
  public function createMeeting($bookInfo)
  {
    try {
      if ($bookInfo['vendor_id'] != 0) {
        $plugin = VendorPlugin::where('vendor_id', $bookInfo['vendor_id'])->select('zoom_account_id', 'zoom_client_id', 'zoom_client_secret')->first();
      } else {
        $plugin = DB::table('basic_settings')->select('zoom_account_id', 'zoom_client_id', 'zoom_client_secret')->first();
      }

      $zoomCredential = [
        'account_id' => $plugin->zoom_account_id,
        'client_id' => $plugin->zoom_client_id,
        'client_secret' => $plugin->zoom_client_secret,
      ];
      Config::set('services.zoom', $zoomCredential);

      // Convert strings to Carbon instances
      $start_time = $bookInfo['start_date'];
      $end_time = $bookInfo['end_date'];

      // Format date for Zoom API (ISO 8601 format)
      $date = $bookInfo['booking_date'];
      $date = Carbon::parse($date);
      $startTime = Carbon::parse($start_time);
      $date->setTime($startTime->hour, $startTime->minute, 0);

      $formatStartTime = $date->format('Y-m-d\TH:i:s.u\Z');

      $timeFormat = DB::table('basic_settings')->pluck('time_format')->first();

      if ($timeFormat == 12) {
        $time1 = Carbon::createFromFormat('h:i A', $start_time);
        $time2 = Carbon::createFromFormat('h:i A', $end_time);
      } else {
        $time1 = Carbon::createFromFormat('H:i', $start_time);
        $time2 = Carbon::createFromFormat('H:i', $end_time);
      }


      // find duration from request time
      $duration = $time2->diffInMinutes($time1);

      $token = $this->getZoomAccessToken();
      $service_id = $bookInfo['service_id'];
      $serviceContent = ServiceContent::where('service_id', $service_id)->select('name')->firstOrFail();
      $topicName = truncateString($serviceContent->name, 50);

      // Make a POST request to the Zoom API to create a meeting
      $response = Http::withToken($token)->post('https://api.zoom.us/v2/users/me/meetings', [
        'topic' => $topicName,
        'start_time' => $formatStartTime,
        'duration' => $duration,
        'type' => 2,
        'timezone' => 'UTC',
        'password' => Str::random(8)
      ]);
      Session::put('zoom_info', $response->json());
      return response()->json($response->json());
    } catch (\Exception $e) {
      session()->flash('error', 'Zoom meeting link could not be created.');
    }
  }

  public function getZoomAccessToken()
  {
    $client = new Client();
    $clientId = config('services.zoom.client_id');
    $clientSecret = config('services.zoom.client_secret');
    $accountId = config('services.zoom.account_id');

    $response = $client->request('POST', 'https://zoom.us/oauth/token', [
      'headers' => [
        'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Accept' => 'application/json',
      ],
      'form_params' => [
        'grant_type' => 'account_credentials',
        'account_id' => $accountId,
      ],
    ]);

    $token = json_decode($response->getBody(), true);
    return $token['access_token'];
  }
}
