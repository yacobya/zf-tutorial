<?php
/**
 *  abstract class - represents table model 
 *
 *  The class represents table mode, supports data validation and table creation sql command.
 */
abstract class Application_Model_DbTable_ConfigAbstract
{
	/**
	 *  abstract public function returns db table creation sql command
	 *
	 *@return string 
	 */
	abstract public function getDBSchema ($tableName);
	/**
	 *  abstract public function perfrom data validation on user input
	 *  
	 *	The function perfrom validation check on user input data, 
	 *
	 * @param  array                    $data   the input data to be checked 
	 * @return string                   $errStr string describing the detected error, null if OK
	 */
	abstract public function dataValidation ($form=null, $data); 
	/**
	 *  converts array of strings to commas separated string.
	 *
	 *  the function returns a a string that can be used for ENUM type definition in mysql db column
	 *
	 * @return string
	 */
	protected function createENUMstr($strArray)
	{
		$str=null;
		foreach ($strArray as $role)
			$str=$str."'$role'" .',';
			
		if ($str!=null)
			$str[strlen($str)-1]=' ';// //delete the last comma
		return $str;
	}
	
}
