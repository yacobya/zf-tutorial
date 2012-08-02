<?php

class AuthenticationController extends Zend_Controller_Action
{
	protected $passwordSalt='amrgi3009'; //using constant salt for users password
	
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        	
    	// check if user is already logged in
    	if (Zend_Auth::getInstance()->hasIdentity()){
    		$this->_redirect('index/index'); // user is logged in
    	}

    	//user is not logged yet
    	// check users DB content, if empty create user "admin"
    	$usersDb = new Application_Model_DbTable_Users();
    	$usersDb->initUsers();// check if empty--> create admin default user

    	$form= new Application_Form_Login();// create login form
    	
    	// determine if POST perfromed
    	if ($this->getRequest()->isPost() ){
    		if ($form->isValid($this->_request->getPost())){

    			//user tried to login. Check authoentication
    			// read assigned username and password
    			$username = $form->getValue('username');
    			$password = $form->getValue('password');
    			//add password salt infront of user entere3d password
    			$password = Application_Model_DbTable_Users::PASSWORD_SALT . $password;
    			
    			$authAdapter=$this->getAuthAdapter();
    			$authAdapter->setIdentity($username)
    			->setCredential($password);
    			$auth = Zend_Auth::getInstance();
    			$result=$auth->authenticate($authAdapter);
    			
    			if ($result->isValid()){
    				// user is authorized
    				$userAttrib = $authAdapter->getResultRowObject();
    				$authStorage = $auth->getStorage();
    				$authStorage->write($userAttrib);
    				$this->_redirect('index/index');
    			}else{ //user not authorized - return to login form
    				// set error message
    	 		 	$this->view->errorMsg = 'User name or password are wrong<br>';
    				$this->view->form = $form;
    			}
    		}
    		else {// invalid form data
    			$this->view->errorMsg = 'illgal form data';
    			$this->view->form = $form;
    		}
    	}
    	else {// request not posted - render login form
     			$this->view->form = $form;
    	}
    		
		
    }

    public function logoutAction()
    {
    	Zend_Auth::getInstance()->clearIdentity();
    	$this->_redirect('authentication/login');
    }
    
    private function getAuthAdapter(){
    	$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
    	$authAdapter->setTableName('cc_users')
    				->setIdentityColumn('username')
    				->setCredentialColumn('password')
    				->setCredentialTreatment('sha1(?)');
    	// 
    	return $authAdapter;
    				
    }

}





