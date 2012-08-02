<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){

		$fc = Zend_Controller_Front::getInstance();
		$fc->registerPlugin(new Application_Plugin_AccessCheck());	
	}
}

