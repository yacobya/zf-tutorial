<?php
Class Application_Model_Acl_Albums extends Zend_Acl {
	public function __construct(){
		$this->add(new Zend_Acl_Resource('index'));
		$this->add(new Zend_Acl_Resource('edit'),'index');
		$this->add(new Zend_Acl_Resource('add'),'edit');
		$this->add(new Zend_Acl_Resource('delete'),'add');
	
		Application_Model_Acl_Lib::addRoles($this);

		$this->allow('user','index','index');
		$this->allow('admin','index','add');
		$this->allow('admin','index','edit');
 		$this->allow('fieldEngineer','index','delete');
		$this->allow('superUser','index','delete');
		
	}
}
/*
 * 		$acl->addRole(new Zend_Acl_Role('user'));
		$acl->addRole(new Zend_Acl_Role('admin'),'user');
		$acl->addRole(new Zend_Acl_Role('fieldEngineer'),'admin');
		$acl->addRole(new Zend_Acl_Role('superUser'),'FieldEngineer');

 */