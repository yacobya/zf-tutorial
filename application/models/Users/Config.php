<?php
/**
 *  class represent users db table model
 *
 *  Supply services related to users DB table. Such as : sql command to create a new table if not exists. 
 */
class Application_Model_Users_Config extends Application_Model_DbTable_ConfigAbstract
{
	public $_cc_roles = array ('user','admin','fieldEngineer','superUser');
	
	/**
	 *  sql command for users table creation if not exists.
	 *  
	 *  the function returns the SQL command that creates cc_users table in DB. If table exists, creation is not perfromed.
	 *  
	 * @return string   
	 */
	public function getDBSchema ($tableName)
	{
		
		// create ENUM values for SQL create table - list of availiable user roles
		$usersRoleENUM=$this->createRolesENUMstr($this->_cc_roles);
			
		$usersSchemaSql ="CREATE TABLE IF NOT EXISTS $tableName (id int(11) NOT NULL AUTO_INCREMENT,
		                 username varchar(64) UNIQUE NOT NULL,
		                 password varchar(64) NOT NULL,
		                 role ENUM ($usersRoleENUM) DEFAULT 'user',
		                 PRIMARY KEY (id))"; 
		return $usersSchemaSql;
	}
	/**
	 *  public function perfrom data validation on user data input
	 *
	 *	
	 * @access public
	 * @param  array                    $data   the input data to be checked
	 * @return string                   $errStr string describing the detected error, null if OK
	 */
	public function dataValidation ($form, $usersData)
	{
		return null;	
	}
	
	/**
	 *  converts array of strings to commas separated string
	 *
	 *  the function returns a
	 * @access private
	 * @return string
	 */	
	private function createRolesENUMstr($strArray)
	{
		$str=null;
		foreach ($strArray as $role)
			$str=$str."'$role'" .',';
			
		if ($str!=null)
			$str[strlen($str)-1]=' ';// //delete the last comma
		return $str;
	}
}// end of class
