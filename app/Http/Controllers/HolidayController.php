<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{
    public function getBankHolidays()
    {
        if (! Cache::has('holidays')) {
            try {
                $client = new Client(['base_uri' => 'https://www.gov.uk', 'timeout' => 3.0]);
                $res = $client->request('GET', 'bank-holidays/england-and-wales.json');
                $dates = collect(json_decode($res->getBody(), true)['events'])->pluck('date');
                Cache::put('holidays', $dates, 60 * 24 * 30);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                Log::warning($e->getResponse()->getBody(true));

                return response()->json('Unable to calculate duration.', 503);
            }
        }

        return Cache::get('holidays');
    }
}
