<?php

namespace szana8\Exchange\Drivers;

class FixerProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * Response from the Fixer API.
     */
    protected $apiResult;

    protected function callApi()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://data.fixer.io/api/latest?access_key=' . config('exchange.drivers.fixer.api_key') . '&format=1');

        $this->apiResult = json_decode($response->getBody(), true);
    }

    /**
     * Create a API request.
     *
     * @param [type] $from
     * @param [type] $to
     * @param [type] $amount
     */
    public function getResponse()
    {
        $this->callApi();

        return $this->getRate();
    }

    /**
     * Return the raw data which came from the api.
     *
     * @return array
     */
    public function getRaw()
    {
        return $this->apiResult;
    }

    /**
     * Return the calculated conversion rate .
     *
     * @return float
     */
    public function getRate()
    {
        return 1 / $this->getRateFrom() * $this->getRateTo();
    }

    /**
     * Return the base currency.
     *
     * @return float
     */
    protected function getBaseCurrency()
    {
        return $this->apiResult['base'];
    }

    /**
     * Return the value of the calculated currency what you
     * convert from.
     *
     * @return float
     */
    protected function getRateFrom()
    {
        return $this->apiResult['rates'][$this->getFrom()];
    }

    /**
     * Return the value of the calculated currency what you
     * convert to.
     *
     * @return float
     */
    protected function getRateTo()
    {
        return $this->apiResult['rates'][$this->getTo()];
    }
}
