<?php

namespace szana8\Exchange\Drivers;

class FixerProvider implements ProviderInterface
{
    protected $apiResult;

    protected $from;

    protected $to;

    protected $amount;

    public function __construct($from = null, $to = null, $amount = null)
    {
        $this->to = $to;
        $this->from = $from;
        $this->amount = $amount;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://data.fixer.io/api/latest?access_key=' . config('exchange.drivers.fixer.api_key'));

        $this->apiResult = json_decode($response->getBody(), true);
    }

    public function getBaseCurrency()
    {
        return $this->apiResult['base'];
    }

    public function getRawResponse()
    {
        return $this->apiResult;
    }

    public function getRateFrom()
    {
        return $this->apiResult['rates'][$this->from];
    }

    public function getRateTo()
    {
        return $this->apiResult['rates'][$this->to];
    }
}
