<?php

namespace szana8\Exchange\Drivers;

interface ProviderInterface
{
    public function getCurrency($from = null, $to = null, $amount = null);
}
