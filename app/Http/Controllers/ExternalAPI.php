<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ExternalAPI extends Controller
{
    public function getBankHolidays()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://www.gov.uk/bank-holidays.json');
        return $res->getBody();
    }

}
