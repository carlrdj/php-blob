<?php
namespace App\Controllers;

use Twig_Loader_Filesystem;
class BaseController {
	
	protected $templateEngine;

	public function __construct(){
		//$loader = \Twig_Loader_Filesystem('../views');
		$loader =new  Twig_Loader_Filesystem('../views');
		$this -> templateEngine = new \Twig_Environment($loader, [
				'debug' => true,
				'cache' => false
			]);

		$this -> templateEngine -> addFilter(new \Twig_SimpleFilter('url', function ($path) {
			return BASEURL . $path;
		}));
	}

	public function render($filename, $data = []) {
		return $this -> templateEngine -> render($filename, $data);
	} 
}
