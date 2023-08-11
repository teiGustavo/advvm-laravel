<?php

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

class ExcelFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
       return 'excel';
    }
}
