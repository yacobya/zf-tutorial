<?php
class Application_Model_Acl_Users extends Zend_Acl {
	public function __construct(){
		$this->add(new Zend_Acl_Resource('UsersManagement'));
		$this->add(new Zend_Acl_Resource('list'),'UsersManagement');
		$this->add(new Zend_Acl_Resource('edit'),'list');
		$this->add(new Zend_Acl_Resource('add'),'edit');
		$this->add(new Zend_Acl_Resource('delete'),'add');
		
		Application_Model_Acl_Lib::addRoles($this);
		
		$this->allow('user','UsersManagement','index');
		$this->allow('user','UsersManagement','list');
		$this->allow('admin','UsersManagement','add');
		$this->allow('admin','UsersManagement','edit');
		$this->allow('fieldEngineer','UsersManagement','delete');
		$this->allow('superUser');//allow everything
	}
}

