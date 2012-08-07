<?php
Class Application_Model_Acl_Lib
{
	static  $_cc_roles = array ('user','admin','fieldEngineer','superUser');
	static public  function addRoles($acl) {
		$acl->addRole(new Zend_Acl_Role('user'));
		$acl->addRole(new Zend_Acl_Role('admin'),'user');
		$acl->addRole(new Zend_Acl_Role('fieldEngineer'),'admin');
		$acl->addRole(new Zend_Acl_Role('superUser'),'fieldEngineer');	
	}
}