<?php

class IndexController extends Zend_Controller_Action
{

    private $_auth = null;

    private $_username = null;

    private $_layout = null;

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
    	// CC Center status view
    	$this->_auth = Zend_Auth::getInstance();
     	$this->view->user= $this->_username;
     	$this->view->header='This is the video control center status view';
 
    		 
    }

    public function addAction()
    {
	    	
    }

}
