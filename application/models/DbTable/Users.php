<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{

    protected $_name = 'cc_users';
    const PASSWORD_SALT = 'amrgi3009';
   
    protected $passwordSalt='amrgi3009'; //using constant salt for users password
    
    public function getUser($username)
    {
    	$row = $this->fetchRow('username = ' . $username);
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
    

    public function initSuperUser ()
    {
    	$superUserName="admin";
    	$superUserPassword='admin';
    	$row = $this->fetchRow('username =' ."'$superUserName'");
    	if (!$row){
    		//insert admin default user
    		$data = array (
    				'username'=> $superUserName,
    				'password'=> (sha1(self::PASSWORD_SALT . $superUserPassword)),
    				'role' => 'superUser'
    
    		);
    		$this->insert($data);
    	}
    	 
    }

}

