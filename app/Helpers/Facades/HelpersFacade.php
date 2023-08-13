<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getLastDayOfMonth(mixed $session)
 */
class HelpersFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
       return 'Helpers';
    }
}
