<?php

namespace App\Modules\Page\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Modules\Page\Models\Page;

use App\Modules\Page\Helpers\Slug;

use Input;
use Validator;
use Response;
use Auth;
use URL;
use Carbon\Carbon;

class PageController extends Controller
{

	public function index()
	{
		return Page::with('author')
					->orderBy('title')
					->paginate( Input::get('limit', 15) );
	}

	public function store()
	{
		$page = new Page;
		$page->fill( Input::all() );
		$page->slug = Input::has('slug') ? Slug::page( Input::get('slug') ) : Slug::page( Input::get('title') ) ;
		$page->user_id = Auth::id();

		if( Input::get('publish') )
			$page->published_at = new Carbon;
		else
			$page->published_at = null;

		$rules = $page->published_at ? Page::createRules() : Page::draftRules();

		$validator = Validator::make($page->toArray(), $rules);
		if( $validator->fails() )
			return Response::json(['success' => false, 'error_msg' => $validator->messages() ]);

		if( $page->save() )
			return Response::json(['success' => true, 'data' => $page, 'redirect' => URL::route('page.index')]);

		return Response::json(['success' => false, 'error_msg' => 'Unable to save page.']);
	}

	public function show($id)
	{
		$page = Page::find($id);

		if( !$page )
			return Response::json(['success' => false, 'error_msg' => 'Page doesn\'t exists.', 'error_code' => 404]);

		return Response::json(['success' => true, 'data' => $page]);
	}

	public function update($id)
	{
		$page = Page::find($id);

		if( !$page )
			return Response::json(['success' => false, 'error_msg' => 'Page doesn\'t exists.']);

		$page->fill( Input::all() );
		$page->slug = Input::has('slug') ? Slug::page( Input::get('slug'), $page->id) : Slug::page( Input::get('title'), $page->id) ;

		if( !$page->published_at && Input::get('publish') )
			$page->published_at = new Carbon;
		else
			$page->published_at = null;

		$rules = $page->published_at ? Page::createRules() : Page::draftRules();

		$validator = Validator::make($page->toArray(), $rules);
		if( $validator->fails() )
			return Response::json(['success' => false, 'error_msg' => $validator->messages() ]);

		if( $page->save() )
			return Response::json(['success' => true, 'data' => $page, 'redirect' => URL::route('page.index')]);

		return Response::json(['success' => false, 'error_msg' => 'Unable to save page.']);

	}

	public function destroy($id)
	{
		$page = Page::find($id);

		if( !$page )
			return Response::json(['success' => false, 'error_msg' => 'Page doesn\'t exists.']);

		if( $page->delete() )
			return Response::json(['success' => true, 'data' => $page, 'redirect' => URL::route('page.index')]);

		return Response::json(['success' => false, 'error_msg' => 'Unable to delete page.']);
	}
}