<?php

class UsersmanagementController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize context switch to manage AJAX requests*/
    	
    	$ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('add', 'json')
                     ->initContext();
                     
    	
    }

    public function indexAction()
    {
        // list users and expose 
    	$usersDb = new Application_Model_DbTable_Users();
    	$usersData=$usersDb->fetchAll();
    	$this->view->usersData =$usersDb->fetchAll();
    	 
    }

    public function addAction()
    {
		$validData=true;
    	if (!($this->getRequest()->isPost())) 
    	{
    		// no data posted, display add user form
    		$form=new Application_Form_User();
    		//    	$form->submit->setLabel('Add');
    		$this->view->form = $form;
       	}
       	else
       	{
       		// data was posted
       		$formData = $this->getRequest()->getPost();
       		
       		// check if ajax request 
       		if ('json' == $this->_getParam('format', false))
       		{
       			//check user existance
       			$username=$this->_getParam('username',false);
       			
       			// get user data from users DB
       			$usersDb = new Application_Model_DbTable_Users();
       			$user=$usersDb->getUser('username',$username);
       			if ($user!=null)
       				// set user exist
       				$userExist=true;
       			else
       				$userExist=false;
       			$this->view->userExist=$userExist;
       		}
       		else
       		{// form submit action - established by user
       			       			
       			$form=new Application_Form_User();
       			$formData = $this->getRequest()->getPost();// read input form data
       			// check validation - filters       			
       			if ($form->isValid($formData))
       			{
	       			$username = $form->getValue('username');
	       			$userRole = $form->getValue('userRole');
	       			$password = $form->getValue('password');
	       			$passwordValid = $form->getValue('passwordValid');
	       			// check password confirmation
	       			if ((!strcmp($password, $passwordValid)) AND (!$usersDb->getUser('username',$username)))
	       			{
	       				// all data is valid - insert new user to DB
	       				$users = new Application_Model_DbTable_Users();
	       				$users->addUser($username, $password,$userRole);
	       				$this->_helper->redirector('index');
	       			}
	       			else
	       			{
	       				$validData=false;
	       				$errMsg='illegal user name or password';
	       			}
       			}
       			else 
       			{// data not valid
       				$validData=false;
       				$errMsg='illegal data';       				       				
       			}
	       			
	       		if (!$validData)
	       		{	
	       				$this->view->errorMsg=$errMsg;
	       				$form->populate($formData);			
       			}
       			
       		}
       			
       	}
       		 
       		
   }
    		 
/*
 * 
 		    	 
	    	$form=new Application_Form_User();
	//    	$form->submit->setLabel('Add');
	    	$this->view->form = $form;
	    	$validData = false;
	    	$formData = $this->getRequest()->getPost();
	    	
	    	if ($this->getRequest()->isPost()) {
	    		$formData = $this->getRequest()->getPost();
	    		if ($form->isValid($formData)) {
	    			$username = $form->getValue('username');
	    			$userRole = $form->getValue('userRole');
	    			$password = $form->getValue('password');
	    			$passwordValid = $form->getValue('passwordValid');
	    			// Check password confirmation
	    			if (!strcmp($password, $passwordValid)){
	    				// all data is valid - insert new user to DB
	    				$users = new Application_Model_DbTable_Users();
	    				$users->addUser($username, $password,$userRole);
	    				$validData=true;
	    				$this->_helper->redirector('index');
	    			
	    			}
	    				
	    		} 
	    		// check data valid
	    		if (!$validData){
	     			$this->view->errorMsg="<br>Password confirmation error<br>";
	  				$form->populate($formData);
	    		}
	    	}// end isPost
    	}
    }
    */
    public function deleteAction()
    {
    	//delete user
    	if ($this->getRequest()->isPost()) { // user confirmed Yes/No
    		$del = $this->getRequest()->getPost('del');
    		if ($del == 'Yes') { // user confirm deletion
    			$id = $this->getRequest()->getPost('id'); // get user ID
    			$users = new Application_Model_DbTable_Users();
    			$users->deleteUser('id',$id);
    		}
    		$this->_helper->redirector('index'); // redirect to main page
    	} else { // display the confirmation form
    		$userId = $this->_getParam('id', 0);// get userId
    		$users = new Application_Model_DbTable_Users();
    		$this->view->user = $users->getUser('id', $userId);// operate the view part of confirmation screen
    		
    	}
    }
    
 public function editAction()
    {
    	// action body
    }
    
    public function listAction()
    {
        // action body
    }
    


}









