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
        $currency = $this->getCurrency();

        $this->base = $currency['base'];

        $calculate = (1 / $currency['rates'][$this->currencyFrom]) * $currency['rates'][$this->currencyTo] * $this->amount;

        return [
            'amount' => $this->amount,
            'from' => $this->currencyFrom,
            'to' => $this->currencyTo,
            'converted' => $calculate
        ];

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
            $this->from($method, $parameters[0]);
        }
        else {
            $this->from($method);
        }

        return $this;
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
        $method = substr($currency, 2);

        $this->to($method);
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

        $provider = new $className();

        return $provider->getCurrency();
    }
}
