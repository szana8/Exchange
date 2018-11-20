<?php

namespace szana8\Exchange\Facades;

use Illuminate\Support\Facades\Facade;

class Exchange extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'exchange';
    }
}
