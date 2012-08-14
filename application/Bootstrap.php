<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){
		$fc = Zend_Controller_Front::getInstance();
		if (!BYPASS_AUTHORIZATION)		
			$fc->registerPlugin(new Application_Plugin_AccessCheck());	
	}
}

