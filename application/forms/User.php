<?php

class Application_Form_User extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setName('users');
    	$id = new Zend_Form_Element_Hidden('id');
    	$id->addFilter('Int');
    	$username = new Zend_Form_Element_Text('username');
    	$username->setLabel('User name')
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('Alnum')
    	->addValidator('alnum')	
     	->addFilter('StringTrim');
    	$password =  new Zend_Form_Element_Password('password');
    	$password->setLabel('Password') 
		       	 ->setRequired(true)
		    	 ->addFilter('StripTags')
		    	 ->addValidator('alnum', true)	
    			 ->addFilter('Alnum')
		    	 ->addFilter('StringTrim');
    	$passwordValid =  new Zend_Form_Element_Password('passwordValid');
    	$password->setLabel('Password confirm')
    			 ->setRequired(true)
		    	 ->addFilter('StripTags')
		         ->addFilter('StringTrim');
    	 
    	$submitAddUser = new Zend_Form_Element_Submit('submit');
    	$submitAddUser->setAttrib('id', 'submitbutton');
    	$submitAddUser->setLabel('Add');
    	
    	$roleSelect = new Zend_Form_Element_Select('userRole');
    	
    	$roleSelect->setLabel('userRole');
		foreach (Application_Model_Acl_Lib::$_cc_roles as $role){
			$roleSelection["$role"]=$role;
		}

		// set role selection
    	$roleSelect->setMultiOptions($roleSelection)
    	    	->setRequired(true)->addValidator('NotEmpty', true)
    			->setLabel('useRole')
    			->setRequired(true);;
    	
    	
    
    	
    	$this->addElements(array($id, $username, $password, $passwordValid,$roleSelect,$submitAddUser));
    	$this->setMethod('post'); 
    	$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/UsersManagement/add');
  	 
    }
}