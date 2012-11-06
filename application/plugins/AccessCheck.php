<?php
/**
 * Access-check ZF plugin CLASS
 * 
 * 
 *  
 * @author Avi Yacoby
 *
 */
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract{
	private $_acl=null;
	private $_auth=null;
	private $_controller =null;
	/**
	 * Class constructor, reads zend authorization instance
	 */
	public function __construct(){
		$this->_auth = Zend_Auth::getInstance();
	}
	/**
	 * access control pre-dispatch function
	 * 
	 * if user is not logined, route the system to login form. 
	 * @param Zend_Controller_Request_Abstract $request
	 */
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
		// enter username and role to layout header
		$_layout->assign('username',$identity->username);
		$_layout->assign('role',$identity->role);
		
		//select controller ACL
		$controllerName = $request->getControllerName();
		$actionName=$request->getActionName();
		$_layout->assign('controller',$controllerName);
		$_layout->assign('action',$actionName);
				
		//$_layout->assign('contentHeader',$this->getContentHeader($controllerName,$actionName ));
		
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
		
		//get request source in order to return to it
				
		//check autorization
		$action = $request->getActionName();
		if (!$this->_acl->isAllowed($identity->role, $controllerName, $action)){
			// user not authorized - do nothing remain in caller controller and action
			$requestSource=$this->getRequestSource($request);
				
			$request->setControllerName ($requestSource['controller'])
	  				->setActionName($requestSource['action']);
			return;
		}
	}
	
	private function getRequestSource($request)
	{
		if ($request->isPost())
		{
			$data = $request->getPost();
			$requestSource['controller']=$data->getValue('sourceController');
			$requestSource['action']=$data->getValue('sourceAction');
		}
		else
		{
			$requestSource['controller']='authentication';
			$requestSource['action']='login';
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


