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
    	if (Zend_Auth::getInstance()->hasIdentity()){
    		$this->_redirect('index/index');
    	}
       // create Login form
        $form= new Application_Form_Login();
        $this->view->form = $form;
    	// check users DB content, if empty create user "admin"
    	$usersDb = new Application_Model_DbTable_Users();
    	$usersDb->initUsers();// check if empty--> create admin default user
		// test authoentication
        $username='wrong';
        $userPassword = Application_Model_DbTable_Users::PASSWORD_SALT . 'admin';//adding constant salt to users password
        $authAdapter=$this->getAuthAdapter();
        $authAdapter->setIdentity($username)
                    ->setCredential($userPassword);// need to encode password
        $auth = Zend_Auth::getInstance();
        $result=$auth->authenticate($authAdapter);
        if ($result->isValid()){
        	 $userAttrib = $authAdapter->getResultRowObject();
        	 $authStorage = $auth->getStorage();
        	 $authStorage->write($userAttrib);
        	 $this->_redirect('index/index');       	 
        	
        } 
        else {
        	;
        }
                      
    }

    public function logoutAction()
    {
        // action body
    }
    private function getAuthAdapter(){
    	$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
    	$authAdapter->setTableName('cc_users')
    				->setIdentityColumn('username')
    				->setCredentialColumn('password')
    				->setCredentialTreatment('SHA1(?)');
    	// 
    	return $authAdapter;
    				
    }

}





