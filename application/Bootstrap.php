<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){
		$fc = Zend_Controller_Front::getInstance();
		if (!BYPASS_AUTHORIZATION)		
			$fc->registerPlugin(new Application_Plugin_AccessCheck());	
	}
	
	protected function _initNavigationTree (){
		if  (DEVELOPMENT) clearstatcache();// clear browser cache to enable CSS development
		$this->bootstrap('layout');
		$layout=$this->getResource('layout');
		$view=$layout->getView();
		$navContainerConfig= new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml','nav' );
		$navContainer = new Zend_Navigation($navContainerConfig);
		$view->navigation($navContainer);		
	} 

}

