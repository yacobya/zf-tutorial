<?php

class IndexController extends Zend_Controller_Action
{
	private $_auth=null;
	private $_username=null;
	private $_layout=null;
    public function init()
    {
        /* Initialize action controller here */
    	//get user name
    	if (!BYPASS_AUTHORIZATION) // bypass authorization and ACL for debug
    	{
    		$this->_auth = Zend_Auth::getInstance();
    		$identity = $this->_auth->getStorage()->read();
    		
    		//assign username and role for layout header
    		$this->_username = $identity->username;
    		
    		//get layout object
    //		$_layout=Zend_Layout::getMvcInstance();
    		//assign header data
    	//	$_layout->assign('username',$identity->username);
    		//$_layout->assign('role',$identity->role); 		    		   
    	}
    	
    	 
    }

    public function indexAction()
    {
    	// fetch all users from DB and send it to viewer
    	$albums = new Application_Model_DbTable_Albums();
    	$this->view->albums = $albums->fetchAll();
    	$this->_auth = Zend_Auth::getInstance();
     	$this->view->user= $this->_username;
    		 
    }

    public function addAction()
    {
        // action body
        $form=new Application_Form_Album();
    	$form->submit->setLabel('Add');
    	$this->view->form = $form;
    	if ($this->getRequest()->isPost()) {
    		$formData = $this->getRequest()->getPost();
    		if ($form->isValid($formData)) {
    			$artist = $form->getValue('artist');
    			$title = $form->getValue('title');
    			$albums = new Application_Model_DbTable_Albums();
    			$albums->addAlbum($artist, $title);
    			$this->_helper->redirector('index');
    		} else {
    			$form->populate($formData);
    		     }
	    	}
   	}
 
    public function editAction()
    {
        // edit action body
    	$form = new Application_Form_Album();
    	$form->submit->setLabel('Save');
    	$this->view->form = $form;
    	if ($this->getRequest()->isPost()) { // edit completed
    		$formData = $this->getRequest()->getPost();
    		if ($form->isValid($formData)) {
    			$id = (int)$form->getValue('id');
    			$artist = $form->getValue('artist');
    			$title = $form->getValue('title');
    			$albums = new Application_Model_DbTable_Albums();
    			$albums->updateAlbum($id, $artist, $title);
    			$this->_helper->redirector('index');
    		} else {
    			$form->populate($formData);
    		}
    	} else {
    		$id = $this->_getParam('id', 0);
    		if ($id > 0) {
    			$albums = new Application_Model_DbTable_Albums();
    			$form->populate($albums->getAlbum($id));
    		}
    	}
    	
    }

    public function deleteAction()
    {
        // delete action body
    	if ($this->getRequest()->isPost()) { // user confirmed Yes/No
    		$del = $this->getRequest()->getPost('del');
    		if ($del == 'Yes') { // user confirm deletion
    			$id = $this->getRequest()->getPost('id'); // get album ID
    			$albums = new Application_Model_DbTable_Albums();
    			$albums->deleteAlbum($id);
    		}
    		$this->_helper->redirector('index'); // redirect to main page
    	} else { // display the confirmation form
    		$id = $this->_getParam('id', 0);// get album id
    		$albums = new Application_Model_DbTable_Albums();
    		$this->view->album = $albums->getAlbum($id);// operate the view part of confirmation screen
    	}
    }


}







