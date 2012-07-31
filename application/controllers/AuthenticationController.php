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
        // action body
    	$usersDb = new Application_Model_DbTable_Users();
    	$usersDb->initSuperUser(); // initialize admin default user
        $username='admin';
        $userPassword=Application_Model_DbTable_Users::PASSWORD_SALT . 'amrgi3009';
        $authAdapter=$this->getAuthAdapter();
        $authAdapter->setIdentity($username)
                    ->setCredential($userPassword);// need to encode password
        $auth = Zend_Auth::getInstance();
        $result=$auth->authenticate($authAdapter);
        if ($result->isValid()){
        	echo 'valid user';
        } 
        else {
        	echo 'invalid user';
        }
                      
    }

    public function logoutAction()
    {
        // action body
    }
    private function getAuthAdapter(){
    	$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
    	$authAdapter->setTableName('users')
    				->setIdentityColumn('username')
    				->setCredentialColumn('password')
    				->setCredentialTreatment(('SHA1(?)) AND state = 1'));
    	// 
    	return $authAdapter;
    				
    }

}





