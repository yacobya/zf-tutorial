<?php

class Application_Form_Login extends Zend_Form
{

	public function __construct($options=NULL){
		parent::__construct($options);
		$this->setName("login");
		$username = new Zend_Form_Element_Text('username');
		$username->setLabel("User name: ")
				 ->setRequired(TRUE)
				 ->addFilter('StripTags');
				 //->addFilter('StripTrim');
	    $password =  new Zend_Form_Element_Password('password');
		$password->setLabel('Password:')
				 ->setRequired(TRUE)
			     ->addFilter('StripTags');
				 //->addFilter('StripTrim');
		
		$login =  new Zend_Form_Element_Submit('login');
		$login->setLabel('Login');
		
		$this->addElements (array ($username, $password, $login));
		$this->setMethod('post');
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl().'/Authentication/login');
	}
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }


}

