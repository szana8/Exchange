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
            return $this->dynamicFrom($method);
        }

        if (Str::startsWith($method, 'to')) {
            return $this->dynamicTo($method);
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
    public function from($currency)
    {
        $this->currencyFrom = strtoupper($currency);

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
     * Set the amount
     *
     * @param integer $amount
     * @return void
     */
    public function amount($amount = 1)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the changed amount.
     *
     * @return void
     */
    public function get()
    {
        $response = $this->getCurrency()->getResponse();

        return [
            'amount' => $this->amount,
            'from' => $this->currencyFrom,
            'to' => $this->currencyTo,
            'converted' => $this->calculateAmount($response)
        ];
    }

    public function getRaw()
    {
        return $this->getCurrency()->getRaw();
    }

    /**
     * Undocumented function
     *
     * @param [type] $baseCurrency
     * @return void
     */
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
    protected function calculateAmount($rate)
    {
        return $rate * $this->amount;
    }

    /**
     * Undocumented function
     *
     * @param [type] $currency
     * @param [type] $parameters
     * @return void
     */
    protected function dynamicFrom($currency)
    {
        $method = substr($currency, 4);

        return $this->from($method);
    }

    /**
     * Undocumented function
     *
     * @param [type] $currency
     * @param [type] $parameters
     * @return void
     */
    protected function dynamicTo($currency)
    {
        $this->to(substr($currency, 2));

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCurrency()
    {
        $driver = config('exchange.default.driver');
        $className = '\\szana8\\Exchange\\Drivers\\' . $driver;

       return new $className($this->currencyFrom, $this->currencyTo);
    }
}
