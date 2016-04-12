<?php

namespace App\Core\Head\Facades;

use Illuminate\Support\Facades\Facade;

class HeadFacade extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'core.head';
    }
}