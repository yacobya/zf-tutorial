<?php
Class Application_Model_Acl_Albums extends Zend_Acl {
	public function __construct(){
		$result = $this->add(new Zend_Acl_Resource('index'));
		$result = $this->add(new Zend_Acl_Resource('edit'),'index');
		$result = $this->add(new Zend_Acl_Resource('add'),'edit');
		$result = $this->add(new Zend_Acl_Resource('delete'),'add');
	
		Application_Model_Acl_Lib::addRoles($this);

		$result = $this->allow('user','index','index');
		$result = $this->allow('admin','index','add');
 		$result = $this->allow('fieldEngineer','index','delete');
		$result = $this->allow('superUser');//alow everything
		
	}
}
