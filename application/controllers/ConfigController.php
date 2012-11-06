<?php
/**
 * CC Center configuration controller
 * 
 * Manage video source, projectors, DVR and users configuration 
 * 
 * @author Avi Yacoby
 *
 */
class ConfigController extends Zend_Controller_Action
{
	private $_videoSourceDb;
    public function init()
    {
        /* Initialize action controller here */
    	// Connect to database
    	$this->_videoSourceDb= new Application_Model_DbTable_Video;
    }

    public function indexAction()
    {
    	// List video sources
    	$this->view->videoSources=$this->_videoSourceDb->fetchAll();
        
    }

    public function deletesourceAction()
    {
    	$sourceId = $this->_getParam('id', 0);// get userId
    	$this->_videoSourceDb->deleteVideoSource('id',$sourceId);  // delete video source
    	$this->_helper->redirector('listsources');// return to base users management page
    }
    
    
    public function addsourceAction()
    {
 //    	$this->view->text="This is add source action";
    	$form=new Application_Form_addVideoSource; // form 
    	$formHelper=new Application_Model_Actions_addElement; // general add element form
    	$videoSourceModel= new Application_Model_Video_Config; // video source model:data, validation,...
    	$sourceId = $this->_getParam('id', 0);// get userId  	   
    	$result=$formHelper->addElement($this, $this->_videoSourceDb, $form, $videoSourceModel,$sourceId);
    	if (($result!='Error')&&($result!='DisplayForm'))
    		$this->_helper->redirector('listsources');// return tosource list page
    }

    public function listsourcesAction()
    {

    	$this->view->videoSources =$this->_videoSourceDb->fetchAll(); // read all video sources
    	
    	 
    }

    public function addDisplayAction()
    {
        // action body
    }
   
    public function listDisplayAction()
    {
        // action body
    }

    public function deleteDisplayAction()
    {
        // action body
    }


}











