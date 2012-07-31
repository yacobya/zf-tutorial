<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'cc_users';
    const PASSWORD_SALT = 'amrgi3009';
    const INITIAL_SUPPER_USER_NAME = "admin";
    const INITIAL_SUPPER_USER_PASSWORD = 'admin';
    
    protected $passwordSalt='amrgi3009'; //using constant salt for users password
    
    public function getUser($username)
    {
    	$userQuery='username = ' . "$username";
    	$row = $this->fetchRow($userQuery);
    	if (!$row) {
    		throw new Exception("Could not find row $id");
    	}
    	return $row->toArray();
    }
    public function addUser($username, $userPassword, $userRole)
    {
    	$data = array(
    			'username'=> $username,
    			'password'=> sha1($passwordSalt . $userPassword),
    			'role' => $userRole
    			);
    	$this->insert($data);
    }
   
    public function deleteUser($username)
    {
    	$this->delete('username =' . $username);
    }
    
    public function initUsers ()
    {
    	$users=$this->fetchAll();
    	if (!count($users))
    		$usersDb->initSuperUser ();  	 
    }
    
    public function initSuperUser ()
    {
    	$queryRow='username =' . "'".self::INITIAL_SUPPER_USER_NAME . "'";
     	$row = $this->fetchRow($queryRow);
    	if (!$row){
    		//insert admin default user
    		$data = array (
    				'username'=> self::INITIAL_SUPPER_USER_NAME,
    				'password'=> (sha1(self::PASSWORD_SALT . self::INITIAL_SUPPER_USER_PASSWORD)),
    				'role' => 'superUser'
    
    		);
    		$this->insert($data);
    	}
    	 
    }

}

