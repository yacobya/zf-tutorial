<?php

class UsersManagementController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
        $form=new Application_Form_User();
    	$form->submit->setLabel('Add');
    	$this->view->form = $form;
    	$validData = false;
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








