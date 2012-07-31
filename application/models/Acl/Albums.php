<?php
Class Model_Acl_Albums extends Zend_Acl {
	public function __construct(){
		$this->add(new Zend_Acl_Resource('album'));
		$this->add(new Zend_Acl_Resource('edit'),'album');
		$this->add(new Zend_Acl_Resource('delete'),'edit');
		$this->add(new Zend_Acl_Resource('albums'));
		$this->add(new Zend_Acl_Resource('list'),'albums');
		
		$this->add(new Zend_Acl_Role('user'));
		$this->add(new Zend_Acl_Role('admin'),'user');
		$this->add(new Zend_Acl_Role('superUser'),'admin');
		
		$this->allow('user','books','list');
		$this->allow('admin','book','add');
		$this->allow('admin','book','edit');
		$this->allow('superUser','book','delete');
		
	}
}
