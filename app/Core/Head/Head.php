<?php
 
 namespace App\Core\Head;

class Head
{
	protected $title;

	protected $scripts = [
		// 'jquery' => 'path-to-script'
	];	

	protected $styles = [
		// 'bootstrap' => 'path-to-bs'
	];

	public function addScript($name, $url = null)
	{	
		if($url) { //if two parameters are passed
			$this->scripts[$name] = $url;
		} else { //if single parameter, treat $name as direct url
			$this->scripts[] = $name;
		}	

		return $this;
	}

	public function addScripts($scripts)
	{
		foreach($scripts as $name => $url) {
			$this->addScript($name, $url);
		}
		return $this;
	}

	public function removeScript($name)
	{
		unset($this->scripts[$name]);
		return $this;
	}

	public function addStyle($name, $url = null)
	{
		if($url) {
			$this->styles[$name] = $url;
		} else { //if single parameter, treat $name as direct url
			$this->styles[] = $name;
		}
		return $this;
	}

	public function addStyles($styles) {
		foreach($styles as $name => $url) {
			$this->addStyle($name, $url);
		}
		return $this;
	}

	public function removeStyle($name)
	{
		unset($this->styles[$name]);
		return $this;
	}

	public function renderScripts()
	{
		$html = '';
		foreach($this->scripts as $name => $url) {
			$html .= "<script src=\"{$url}\"></script>";
		}
		return $html;
	}

	public function renderStyles()
	{
		$html = '';
		foreach($this->styles as $name => $url) {
			$html .= "<link rel=\"stylesheet\" href=\"{$url}\"/>";
		}
		return $html;
	}

	public function __toString()
	{
		return $this->renderStyles() . $this->renderScripts();
	}
}