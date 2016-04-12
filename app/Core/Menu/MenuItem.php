<?php

namespace App\Core\Menu;

use Route;

class MenuItem
{
	
	protected $priority = [
		// 20 => ['menu_id', 'menu_id2']
	];

	protected $items = [
		// 'menu_id' => MenuItem
	];

	protected $attributes = [
		'menu_wrapper' => 'ul',
		'item_wrapper' => 'li',

		'menu_wrapper_class' => '',
		'item_wrapper_class' => '',
		'has_children_class' => 'has-children'
	];


	public function __construct($attributes = [])
	{
		$this->fill($attributes);
		return $this;
	}

	public function fill($attributes)
	{
		foreach($attributes as $key => $value) {
			$this->attributes[$key] = $value;
		}

		return $this;
	}

	public function hasChildren()
	{
		return count($this->items) ? true : false;
	}

	public function addItem($id, MenuItem $item, $priority = 20 )
	{
		if( !isset($this->priority[$priority]) )
			$this->priority[$priority] = [];

		array_push($this->priority[$priority], $id);

		$this->items[$id] = $item;

		return $this;
	}

	public function removeItem($id)
	{
		unset($this->items[$id]);
		return $this;
	}

	public function getItem($id)
	{
		if( isset($this->items[$id]) )
			return $this->items[$id];
	}

	public function renderChildren()
	{

		$html = "<{$this->menu_wrapper} class=\"{$this->menu_wrapper_class}\">";
		
		ksort($this->priority);
		
		
		
		foreach($this->priority as $menuIds) {
			foreach($menuIds as $id) {

				if( isset($this->items[$id]) ) {
					$item = $this->items[$id];
					$isActive = Route::getCurrentRequest()->fullUrl() == $item->link ? 'active' : '';

					$hasChildren = $item->hasChildren() ? $this->has_children_class : '';
					$html .= "<{$this->item_wrapper} class=\"{$this->item_wrapper_class} {$isActive} {$hasChildren}\">
								<a href=\"{$item->link}\">{$item->title}"."</a>". 
								$item->_renderSubChildren().
							"</{$this->item_wrapper}>";
				}
				
			}
		}
		
		return $html . "</{$this->menu_wrapper}>";
	}

	public function _renderSubChildren()
	{
		if( $this->hasChildren() )
			return $this->renderChildren();
		

	}



	/**
	 * Magic methods
	 */
	
	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public function __get($key)
	{
		if( isset($this->attributes[$key]) )
			return $this->attributes[$key];
	}
	
	public function __toString()
	{
		return $this->renderChildren();
	}
}