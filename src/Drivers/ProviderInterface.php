<?php

namespace szana8\Exchange\Drivers;

interface ProviderInterface
{
    public function getRate();

    public function getRaw();
}
