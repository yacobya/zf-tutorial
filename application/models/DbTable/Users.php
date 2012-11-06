<?php
/**
 * users table I/F and management 
 * @author Avi Yacoby
 *
 */
class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
	
	protected  $_dbConfig;
    protected  $_name = 'cc_users';
	protected  $_dbAdapter ;
	protected  $_dbh;
	
  
    const PASSWORD_SALT = 'amrgi3009'; //using constant salt for users password
    const INITIAL_SUPPER_USER_NAME = "admi n";
    const INITIAL_SUPPER_USER_PASSWORD = 'admin';
   
/**
 * Class constructor
 * 
 * created users table if not exists 
 */
    public function __construct ()
    {
    	// create table if not exist
    	//$dbAdapter=getAdapter();
    	$this->_dbAdapter=$this->getDefaultAdapter();
    	$this->_dbConfig=new Application_Model_Users_Config();
    	$sqlCreateTable=$this->_dbConfig->getDBSchema($this->_name);
    	$this->_dbh=$this->_dbAdapter->getConnection();
    	$result = $this->_dbAdapter->getConnection()->exec($sqlCreateTable);// create table if not exist
    	parent::__construct();
    
    }
/**
 * if no users exists, create default administrator user
 */
    public function init ()
    {
    	$this->initUsers();// check if empty--> create admin default user
    }
 /**
  * gets username role: admin, user,...
  * @param string $username
  * @return string|NULL role if exists null if user is not exist 
  */     
    public function getUserRole($username)
    {
    
    	// get user data from users DB
    	$user=$this->getUser('username',$username);
    	if ($user!=null)
    		// set user exist
    		return $user[role];
    	else
    		return null;
    }
    
    /**
     * checks if user "username" exists
     * @param string $username
     * @return boolean true if user exists
     */
    public function checkUserExist($username)
    {
	    // get user data from users DB
	    $user=$this->getUser('username',$username);
	    if ($user!=null)
	    	// set user exist
	    	return true;
	    else
	    	return false;
    }
/**
 * 
 * @param unsigned $id user DB id - key 
 * @throws Exception - user with entered id is no exist
 */    
    public function getUserById($id)
    {
    	$userQuery='id = ' . "$id";
    	$row = $this->fetchRow($userQuery);
    	if (!$row) {
    		throw new Exception("Could not find row $id");
    	}
    	return $row->toArray();
    }
    public function getUser($key,$keyValue)
    {
    	$userQuery= $key. " = " . "'$keyValue'";
    	$row = $this->fetchRow($userQuery);
    	if (!$row) {
    		return null;
    	}
    	return $row->toArray();
    	
    }
    /**
     * add new user to DB
     * @param string $username
     * @param string $userPassword
     * @param ENUM $userRole
     */
    public function addUser($username, $userPassword, $userRole)
    {
    	$data = array(
    			'username'=> $username,
    			'password'=> ( sha1((self::PASSWORD_SALT . $userPassword))),
    			'role' => $userRole
    			);
    	$this->insert($data);
    }
   /**
    * delete user identifies by key type and key value
    * @param string database table column id - key
    * @param unknown_type $keyValue key value. Type is according to key type
    */
    public function deleteUser($key, $keyValue)
    {
    	$this->delete("$key =" . $keyValue);
    }
  /**
   * if users table is empty, add a new administrator default user
   */ 
    public function initUsers ()
    {
    	$users=$this->fetchAll();
    	if (!count($users))
    		$this->initSuperUser();  	 
    }
/**
 * add a new administrator default user
 */    
    public function initSuperUser ()
    {
    	$dbAdapter=$this->getDefaultAdapter();
    	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
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

