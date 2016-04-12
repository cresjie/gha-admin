<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('/login',[
	'as' => 'login',
	function(){
		return 'login';
	}
]);
*/
@include('routes-api.php');

Route::get('/',[
	'middleware' => 'auth',
	'uses' =>  'HomeController@index'

]);
Route::get('logout',function(){
	Auth::logout();
	return Redirect::to('/');
});
Route::resource('login','LoginController',['only' => ['index','store']]);

Route::get('test', function(){
	return Route::current()->uri();
});