<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{
	private $_acl=null;
	private $_auth=null;
	
	public function __construct(){
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = new Application_Model_Acl_Albums();
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		$controllerName = $request->getControllerName();
		$action = $request->getActionName();
		$identity = $this->_auth->getStorage()->read();
		if  ( (!$identity) or (!$this->_acl->isAllowed($identity->role, $controllerName, $action) )){
			// user not logged or no permission
			// dispatch the login page
			$request->setControllerName ('authentication')
						->setActionName('login');
		}
		
	}
/*	public function postDispatch(){
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
*/
		
}


