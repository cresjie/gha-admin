<?php

namespace App\Modules\Page\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Page\Models\Page;

use App\Modules\Page\Helpers\Slug;

use App;
use View;
use Input;
use Validator;
use Auth;
use Carbon\Carbon;
use Redirect;
use Response;

class PageController extends Controller
{
	
	public function index()
	{
		
		return View::make('page.index');
	}

	public function create()
	{
		return View::make('page.create');
	}

	public function store()
	{
		$page = new Page;
		$page->fill( Input::all() );
		$page->slug = Input::has('slug') ? Slug::page( Input::get('slug') ) : Slug::page( Input::get('title') ) ;
		$page->user_id = Auth::id();

		if( Input::get('publish') )
			$page->published_at = new Carbon;

		$rules = $page->published_at ? Page::createRules() : Page::draftRules();

		$validator = Validator::make($page->toArray(), $rules);
		if( $validator->fails() )
			return Redirect::route('page.create')->withInput( Input::all() )->withErrors($validator->messages());

		if( $page->save() )
			return Redirect::route('page.index');

		return Response::json(['success' => false, 'error_msg' => 'Unable to save page.']);
	}	

	public function show($id)
	{
		$page = Page::find($id);

		if( !$page )
			return App::abort(404);

		return View::make('page.show', compact('page'));
	}

	public function edit($id)
	{
		$page = Page::find($id);

		if( !$page )
			return App::abort(404);

		return View::make('page.edit', compact('page'));
	}


	public function update($id)
	{
		$page = Page::find($id);
		$page->fill( Input::all() );
		$page->slug = Input::has('slug') ? Slug::page( Input::get('slug') ) : Slug::page( Input::get('title') ) ;

		if( Input::get('publish') )
			$page->published_at = new Carbon;
		else
			$page->published_at = null;

		$rules = $page->published_at ? Page::createRules() : Page::draftRules();
		$validator = Validator::make($page->toArray(), $rules);
		if( $validator->fails() )
			return Redirect::route('page.edit')->withInput( Input::all() )->withErrors($validator->messages());

		if( $page->save() )
			return Redirect::route('page.index');

		return Response::json(['success' => false, 'error_msg' => 'Unable to save page.']);

	}

	public function destroy($id)
	{

	}

	public function slug()
	{
		//$q = Input::get('q');
		$slug = Slug::page( Input::get('q'), Input::get('except', '') );
		
		return Response::json(['slug' => $slug]);
	}
}