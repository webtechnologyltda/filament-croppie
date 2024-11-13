<?php

namespace Michaeld555\FilamentCroppie\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Michaeld555\FilamentCroppie\FilamentCroppie
 */
class FilamentCroppie extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \Michaeld555\FilamentCroppie\FilamentCroppie::class;
    }

}
