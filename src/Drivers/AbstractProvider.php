<?php

namespace szana8\Exchange\Drivers;

abstract class AbstractProvider
{
    /**
     * Currency name what you want to convert from.
     */
    protected $from;

    /**
     * Currency name what you want to convert to.
     */
    protected $to;

    /**
     * Amount what you convert.
     */
    protected $amount;

    /**
     * Create a API request.
     *
     * @param [type] $from
     * @param [type] $to
     * @param [type] $amount
     */
    public function __construct($from = null, $to = null, $amount = null)
    {
        $this->to = $to;
        $this->from = $from;
        $this->amount = $amount;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    abstract function getResponse();
}
