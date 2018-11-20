<?php

namespace szana8\Exchange;

use Illuminate\Support\Str;


class Exchange
{
    /**
     * Name of the currency what we want to convert from.
     */
    protected $currencyFrom = null;

    /**
     * Name of the currency what we want to convert to.
     */
    protected $currencyTo = null;

    /**
     * Amount of currency
     */
    protected $amount = 1;

    /**
     * Base currency
     */
    protected $base = null;

    /**
     * Call the from and to method dynamically.
     *
     * @param [type] $method
     * @param [type] $arguments
     * @return void
     */
    public function __call($method, $arguments)
    {
        if (Str::startsWith($method, 'from')) {
            return $this->dynamicFrom($method, $arguments);
        }

        if (Str::startsWith($method, 'to')) {
            return $this->dynamicTo($method, $arguments);
        }


        return $this;
    }

    /**
     * Set the from currency
     *
     * @param [type] $currency
     * @param integer $amount
     * @return void
     */
    public function from($currency, $amount = 1)
    {
        $this->currencyFrom = strtoupper($currency);
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set the to currency
     *
     * @param [type] $currency
     * @return void
     */
    public function to($currency)
    {
        $this->currencyTo = strtoupper($currency);

        return $this;
    }

    /**
     * Get the changed amount.
     *
     * @return void
     */
    public function get()
    {
        $response = $this->getCurrency();
        $this->setBaseCurrency($response->getBaseCurrency());

        return [
            'amount' => $this->amount,
            'from' => $this->currencyFrom,
            'to' => $this->currencyTo,
            'converted' => $this->calculateAmount($response)
        ];
    }

    protected function setBaseCurrency($baseCurrency)
    {
        $this->base = $baseCurrency;
    }

    /**
     * Calculate the amount based on the currencies.
     *
     * @param [type] $rates
     * @return void
     */
    protected function calculateAmount($response)
    {
        return (1 / $response->getRateFrom()) * $response->getRateTo() * $this->amount;
    }

    /**
     * Undocumented function
     *
     * @param [type] $currency
     * @param [type] $parameters
     * @return void
     */
    protected function dynamicFrom($currency, $parameters)
    {
        $method = substr($currency, 4);

        if ($parameters[0]) {
            return $this->from($method, $parameters[0]);
        }

        return $this->from($method);
    }

    /**
     * Undocumented function
     *
     * @param [type] $currency
     * @param [type] $parameters
     * @return void
     */
    protected function dynamicTo($currency, $parameters)
    {
        $this->to($substr($currency, 2));

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected function getCurrency()
    {
        $driver = config('exchange.default.driver');
        $className = '\\szana8\\Exchange\\Drivers\\' . $driver;

        return new $className($this->currencyFrom, $this->currencyTo);
    }
}
