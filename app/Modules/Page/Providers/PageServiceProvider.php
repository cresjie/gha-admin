<?php

namespace App\Modules\Page\Providers;

use Illuminate\Support\ServiceProvider;

use Route;
use Menu;
use MenuItem;
use Head;

class PageServiceProvider extends ServiceProvider
{

	public function register()
	{

	}

	public function boot()
	{
		
		$this->addRouters();
		$this->addMenu();
		$this->addScripts();

	}

	protected function addRouters()
	{
		Route::group(['namespace' => 'App\Modules\Page\Http\Controllers', 'middleware' => 'auth'], function(){
			Route::resource('page','PageController');
			Route::resource('api/page','Api\PageController');
			
			Route::any('api/slug/page', 'PageController@slug');
		});
	}

	protected function addMenu()
	{
		Menu::addItem('page', new MenuItem(['title' => '<i class="fa fa-laptop menu-item-icon"></i> <span class="sidebar-collapse-hide">Page</span>', 'link' => '#/page']));
	}

	protected function addScripts()
	{
		Route::matched(function($route){
			switch($route->uri()) {
				case '/':
					Head::addStyle('froala_editor', asset('css/library/froala/froala_editor.min.css') );

					Head::addScripts([
						'momentjs' => asset('js/library/datetime/moment.js'),
						'froala_editor' => asset('js/library/froala/froala_editor.min.js'),
						'froala_color' => asset('js/plugins/froala/colors.min.js'),
						'froala_font_size' => asset('js/plugins/froala/font_size.min.js'),
						'page_script' => asset('js/module/page/script.js')
					]);
					break;
			}
			
		});
		
	}

	
}