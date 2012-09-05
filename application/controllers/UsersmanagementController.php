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
        	
    	$userDb=null;
		$validData=true;
       	$form=new Application_Form_User();
       	$usersDb = new Application_Model_DbTable_Users();
		$errMsg=null;

		
		
		if (!($this->getRequest()->isPost())) 
    	{	// no data posted, display add user page
//    		$form->setError("Hi this is an error");
			$bodyTag=new Application_View_Helper_BodyTag();
			$bodyTag->bodyTag('onclick', 'donothing()');
	    	$this->view->form = $form;
	    	$this->view->bodyTag = $bodyTag;
 	    	return;
    	}
    	//read posted data
       	$formData = $this->getRequest()->getPost();// read form input data
       		
       	// check if ajax request     		
       	if ('json' == $this->_getParam('format', false))
       	{   //check user existance
			$username=$this->_getParam('username',false);
       		$userExist=$userDb->checkUserExist($username);
       		// return data to ajax
       		$this->view->userExist=$userExist;
       		return;
       	}
       	     			
       	// form submit action - handle user request
       	// check data validation
       	$errStr = $form->dataValidation($formData);
       	if ($errStr)
       	{// data not valid
       		$this->view->errorMsg=$errStr;
     		$form->populate($formData);
         	$form->setError($errStr);// populate before setting error (populate set the previouse data
     		$this->view->form = $form;
	    	return;
       	}
       	
       	// all data is valid - insert new user to DB
    	$password=$formData['password'];
    	$username=$formData['username'];
    	$userRole=$formData['userRole'];
       	$usersDb->addUser($username, $password,$userRole);
	    $this->_helper->redirector('index');// return to base users management page       				
   }
    		 
   
    public function deleteAction()
    {
     	$userId = $this->_getParam('id', 0);// get userId
    	$users = new Application_Model_DbTable_Users();
    	$users->deleteUser('id',$userId);  // delete user
    	$this->_helper->redirector('index');// return to base users management page
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









