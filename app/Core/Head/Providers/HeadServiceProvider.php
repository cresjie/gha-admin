<?php

namespace App\Core\Head\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Head\Head;

class HeadServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton('core.head', function($app){
			return new Head;
		});
	}
}