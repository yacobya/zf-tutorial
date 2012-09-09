<?php
class Application_Form_User extends Application_Model_Form_ProjectForm
{
	private $errorPopup;
    
	public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setName('users');

    	//user id hiddent field
    	$id = new Zend_Form_Element_Hidden('id');
    	$id->addFilter('Int');
		$this->_formElements[]=$id;
		
		//username input field
    	$username = new Zend_Form_Element_Text('username');
    	$username->setLabel('User name')
    	->setRequired(true)
    	->addFilter('StripTags')
    	->addFilter('Alnum')
    	->addValidator('alnum')	
     	->addFilter('StringTrim');
		$this->_formElements[]=$username;
    	
		//password field
		$password =  new Zend_Form_Element_Password('password');
    	$password->setLabel('Password') 
		       	 ->setRequired(true)
		    	 ->addFilter('StripTags')
		    	 ->addValidator('alnum', true)	
    			 ->addFilter('Alnum')
		    	 ->addFilter('StringTrim');
    	$this->_formElements[]=$password;
    	
    	//password validation field
    	$passwordValid =  new Zend_Form_Element_Password('passwordValid');   	
    	$passwordValid->setLabel('Password confirm')
    			 ->setRequired(true)
		    	 ->addFilter('StripTags')
		         ->addFilter('StringTrim');
    	$this->_formElements[]=$passwordValid;
    	 
    	//error text to be used by JS to popup error
    	$this->errorPopup=new Zend_Form_Element_Hidden("errorPopup");
    	$this->errorPopup->setAttrib('id','errorPopup');
    	$this->_formElements[]=$this->errorPopup;
    	 
    	 
    	$roleSelect = new Zend_Form_Element_Select('userRole');
    	// user role selection
    	$roleSelect->setLabel('userRole');
		foreach (Application_Model_Acl_Lib::$_cc_roles as $role){
			$roleSelection[$role]=$role;
		}

		// set role selection
    	$roleSelect->setMultiOptions($roleSelection)
    	    	->setRequired(true)->addValidator('NotEmpty', true)
    			->setLabel('useRole')
    			->setRequired(true);
    	$this->_formElements[]=$roleSelect;

    	// add user submit button
    	$submitAddUser = new Zend_Form_Element_Submit('submit');
    	$submitAddUser->setAttrib('id', 'submitbutton');
    	$submitAddUser->setLabel('Add');
    	$this->_formElements[]=$submitAddUser;
    	 
//    	$this->addElements(array($id, $username, $password, $passwordValid,$roleSelect,$submitAddUser,$this->errorPopup));
    	$this->addElements($this->_formElements);
    	$this->setMethod('post'); 
    	$this->setAttrib('onsubmit','return validateForm()');
    	$addUseUrl=Zend_Controller_Front::getInstance()->getBaseUrl().'/usersmanagement/add';  	
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

