<?php
class Application_Model_Acl_Users extends Zend_Acl {
	public function __construct(){
		$this->add(new Zend_Acl_Resource('Usersmanagement'));
		$this->add(new Zend_Acl_Resource('list'),'Usersmanagement');
		$this->add(new Zend_Acl_Resource('edit'),'list');
		$this->add(new Zend_Acl_Resource('add'),'edit');
		$this->add(new Zend_Acl_Resource('delete'),'add');
		
		Application_Model_Acl_Lib::addRoles($this);
		
		$this->allow('user','Usersmanagement','index');
		$this->allow('user','Usersmanagement','list');
		$this->allow('admin','Usersmanagement','add');
		$this->allow('admin','Usersmanagement','edit');
		$this->allow('fieldEngineer','Usersmanagement','delete');
		$this->allow('superUser');//allow everything
	}
}

