<?php
Class Application_Model_Acl_Albums extends Zend_Acl {
	public function __construct(){
		$this->add(new Zend_Acl_Resource('index'));
		$this->add(new Zend_Acl_Resource('edit'),'index');
		$this->add(new Zend_Acl_Resource('delete'),'index');
		
		$this->addRole(new Zend_Acl_Role('user'));
		$this->addRole(new Zend_Acl_Role('admin'),'user');
		$this->addRole(new Zend_Acl_Role('FieldEngineer'),'admin');
		$this->addRole(new Zend_Acl_Role('superUser'),'FieldEngineer');
		
		$this->allow('user','index','index');
		$this->allow('admin','index','add');
		$this->allow('admin','index','edit');
		$this->allow('superUser','index','delete');
		
	}
}
