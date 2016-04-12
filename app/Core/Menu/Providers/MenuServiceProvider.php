<?php

namespace App\Core\Menu\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Menu\MenuItem;


class MenuServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton('core.menu', function($app){
			return new MenuItem(['menu_wrapper_class' => 'main-navigation-sidebar']);
		});

		$this->app->singleton('core.menu-item', function(){
			return $this->app->share(function(){ return new MenuItem;});
		}) ;
	}

	public function boot()
	{
		
	}
}