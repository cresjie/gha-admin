<?php

namespace App\Modules\Page\Helpers;

use App\Helpers\Generator;

use App\Modules\Page\Models\Page;


class Slug
{

	static public function page($q, $except = '')
	{
		return Generator::slug( (new Page)->getTable(),'slug', $q, [],0, Generator::MIN_SLUG_LENGTH, function($q) use ($except) {
			if( is_array($except) )
				$q->whereNotIn('id', $except);
			else
				$q->where('id', '!=', $except);
		});	
	}
}