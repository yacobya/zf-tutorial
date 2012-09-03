<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{
	private $_acl=null;
	private $_auth=null;
	private $_controller =null;
	
	public function __construct(){
		$this->_auth = Zend_Auth::getInstance();
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		
		$_layout=Zend_Layout::getMvcInstance();// get layout object
		
		// check if user already logged on
		if (!($identity = $this->_auth->getStorage()->read())){ 
			// user not logged - route to login page
			$_layout->assign('controller','authentication');
			$_layout->assign('action','login');
			$request->setControllerName ('authentication')
			->setActionName('login');
			return;
		}
		//add user login and role to layout
		$_layout=Zend_Layout::getMvcInstance();// enter username and role to layout header
		$_layout->assign('username',$identity->username);
		$_layout->assign('role',$identity->role);
		
		//select controller ACL
		$controllerName = $request->getControllerName();
		$_layout->assign('controllerName',$controllerName);
		$_layout->assign('actionName',$request->getActionName());
		switch ($controllerName){
			case 'index':
				$this->_acl = new Application_Model_Acl_Albums();
				break;
			case 'Usersmanagement':	
				$this->_acl = new Application_Model_Acl_Users();
				break;
			default:
				// unprotected resource - continue
				return;
		}
		
		//check autorization
		$action = $request->getActionName();
		if (!$this->_acl->isAllowed($identity->role, $controllerName, $action)){
			// user not authorized
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


