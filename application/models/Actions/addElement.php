<?php
/**
 * Generic add element form management class
 * 
 * 
 * @author Avi Yacoby
 *
 */
class Application_Model_Actions_addElement
{
	private $_dataModel;// element data modeldata model

	/**
	 * 
	 * @param unknown_type $dbHandle
	 * @param unknown_type $form
	 */
	public function init ($dbHandle, $form)
	{
		
	}
	/**
	 * generic add element function
	 * 
	 * Check state: if data is not posted, create add element   
	 *   
	 * @param controller-action $frontController the called controller and action
	 * @param unknown_type $dbHandle database table manager class 
	 * @param zend-form $form zend framework form object
	 * @param unknown_type $dataModel object represents the DB table data model 
	 * @param unknown_type $sourceId
	 * @return void|string 'Cancel' if cancel was pushed, 'Error' if data validation failed, 'Saved' if data was saved successfully, 'DisplayForm' to display add element form
	 */
	public function addElement(&$frontController ,$dbHandle, &$form,$dataModel,$sourceId)
	{
		$validData=true;
		$errMsg=null;
		$this->_dataModel=$dataModel;
			
		if (!($frontController->getRequest()->isPost()))
		{	// no data posted, sourceId is passed display add/edit element page 
			$bodyTag=new Application_View_Helper_BodyTag();
			$bodyTag->bodyTag('onclick', 'donothing()');
			//READ VIDEO SOURCE DATA FROM db
			$videoSourceData=$dbHandle->getVideoSource('id',$sourceId);
			//set form data
			$formData=$this->convertDbToForm($videoSourceData,$sourceId);
			$form->populate($formData);
			$frontController->view->form = $form;
			$frontController->view->bodyTag = $bodyTag;
			return 'DisplayForm';
		}
		//read posted data
		$formData = $frontController->getRequest()->getPost();// read form input data
		// form submit action - handle user request
		
		//check if cancel button was pressed
		if (array_key_exists('Cancel',$formData))
				return 'Cancel';
							
		// check data validation support add or insert data
		$errStr = $this->_dataModel->dataValidation($form,$formData);
		if ($errStr)
		{// data not valid
			$frontController->view->errorMsg=$errStr;
			$form->populate($formData);
			$form->setError($errStr);// populate before setting error (populate set the previouse data
			$frontController->view->form = $form;
			return 'Error';
		}
		
		// all data is valid - insert new element to DB
		//db delete form data that is not part of DB data
		
		// need to check which button was pushed
		if (array_key_exists('Save',$formData))
			$dbHandle->addVideoSource($formData,'id',$formData['id']);		
		else // "sava as" was pushed"
			$dbHandle->addVideoSource($formData,null,null);
		return 'Saved';
	}


private function convertDbToForm($videoSourceData,$id)
{
	$formData['errorPopup']=null;
	$formData['id']=$id;
	$formData['sourceController']='config';
	$formData['sourceAction']='listsources';
	foreach ($videoSourceData as $key=>$value)
	{
		$formData[$key]=$value;
	}
	unset($formData['aspect_ratio']);
	$formData['Saveas']='';
	$formData['encoder_IP']=long2ip($formData['encoder_IP']);
	return $formData;
}
		
		/*
		Data from $formdata
		$formData	Array [12]
		errorPopup	(string:0)
		sourceController	(string:13) avicontroller
		sourceAction	(string:9) aviaction
		
		
		id	(string:1) 0
		name	(string:7) Avi try
		description	(string:15) trying to debug
		interface_type	(string:4) HDMI
		resolution	(string:8) 1280,720
		encoder_IP	(string:11) 87.26.23.26
		encoder_fps	(string:2) 20
		encoder_MBR	(string:2) 20
		Saveas	(string:0)
		
		
		$videoSourceData	Array [9]	
			id	(string:1) 3	
			name	(string:7) Avi try	
			description	(string:15) trying to debug	
			interface_type	(string:3) VGA	
			resolution	(string:8) 1280,720	
			aspect_ratio	null	
			encoder_IP	(string:10) 1461327642	
			encoder_fps	(string:2) 20	
			encoder_MBR	(string:2) 20	
		
		*/
}