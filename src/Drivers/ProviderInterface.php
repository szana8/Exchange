<?php

namespace szana8\Exchange\Drivers;

interface ProviderInterface
{
    public function getRawResponse();

    public function getBaseCurrency();

    public function getRateFrom();

    public function getRateTo();
}
