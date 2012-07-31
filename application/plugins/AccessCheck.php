<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{
	public function preDispatch(){
		echo 'pre disatch <br>';
	}
	public function postDispatch(){
		echo 'post disatch <br>';
	}
	public function routeShutdown(){
		echo 'route shutdown <br>';
	}
	public function dispatchLoopShutdown(){
		echo 'dispatch loop shutdown<br>';
	}
	public function routeStartup(){
		echo 'route startup<br>';
	}
	
}

