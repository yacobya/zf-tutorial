<?php
class Application_Form_User extends Zend_Form
{
	private $errorPopup;
    
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
    	
    	$this->errorPopup=new Zend_Form_Element_Hidden("errorPopup");
    	$this->errorPopup->setAttrib('id','errorPopup');
    	
    	 
    	$submitAddUser = new Zend_Form_Element_Submit('submit');
    	$submitAddUser->setAttrib('id', 'submitbutton');
    	$submitAddUser->setLabel('Add');
    	
    	$roleSelect = new Zend_Form_Element_Select('userRole');
    	
    	$roleSelect->setLabel('userRole');
		foreach (Application_Model_Acl_Lib::$_cc_roles as $role){
			$roleSelection[$role]=$role;
		}

		// set role selection
    	$roleSelect->setMultiOptions($roleSelection)
    	    	->setRequired(true)->addValidator('NotEmpty', true)
    			->setLabel('useRole')
    			->setRequired(true);
    	  	
       	
    	$this->addElements(array($id, $username, $password, $passwordValid,$roleSelect,$submitAddUser,$this->errorPopup));
    	$this->setMethod('post'); 
    	$this->setAttrib('onsubmit','return validateForm()');
    	$addUseUrl=Zend_Controller_Front::getInstance()->getBaseUrl().'/Usersmanagement/add';  	
     	$this->setAction($addUseUrl);
   	
    }

    
    public function dataValidation($formData)
    {  	
 		$errStr=null;
    	if (!$this->isValid($formData))
    		return 'invalid data';
    	$password=$formData['password'];
    	$passwordValid=$formData['passwordValid'];
 //   	$form->getValue('username')
    	// data filters - valid
    	// check password confirmation    	
    	if (strcmp($password, $passwordValid)!=0){// string not equal
    		return 'Password confirmation error';
    	}
    	//check user exist
    	$userDb= new Application_Model_DbTable_Users();
    	$username=$this->getValue('username');
    	if ($username!=null)
	   	 	if ($userDb->checkUserExist($this->getValue('username')))
	    		return 'server: user already exist';	

    	return null; // data is valid
    }
    public function setError ($errMsg)
    {
     	$this->errorPopup->setValue($errMsg);

    }
         			       				       			
    
} 

