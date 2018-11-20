<?php

namespace szana8\Exchange\Drivers;

class FixerProvider implements ProviderInterface
{
    public function getCurrency($from = null, $to = null, $amount = null)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://data.fixer.io/api/latest?access_key=' . config('exchange.drivers.fixer.api_key'));

        return json_decode($res->getBody(), true);
    }
}
