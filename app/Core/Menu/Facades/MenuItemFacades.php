<?php

namespace App\Core\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class MenuItemFacades extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'core.menu-item';
    }
}