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
		$errMsg = $this->_dataModel->dataValidation($form,$formData);
		if ($errMsg)
		{// data not valid
			//set and populate error form message
			$this->setPopulateError ($form, $frontController,$formData,$errMsg);
			return 'Error';
		}
		
		// all data is valid - insert new element to DB
		//db delete form data that is not part of DB data
		
		// need to check which button was pushed
		if (array_key_exists('Save',$formData))
			$errMsg=$dbHandle->addVideoSource($formData,'id',$formData['id']);		
		else // "save as" was pushed"
			// check that element with this name does not exists.
			$errMsg=$dbHandle->addVideoSource($formData,null,null);
		if ($errMsg==null)
			return 'Saved';
		else
		{// error while inser/update data
			//set and populate error form message
			$this->setPopulateError ($form, $frontController,$formData,$errMsg);
			return 'Error';
		}
				
	}
	
	private function setPopulateError (&$form, &$frontController,$formData,$errMsg)
	{
		$form->populate($formData);
		$form->setError($errMsg);// populate before setting error (populate set the previouse data
		$frontController->view->form = $form;
	}
/**
 * filter out form data that is not included in video source db table. 
 * @param unknown_type $videoSourceData
 * @param unknown_type $id
 * @return array includes only filtered formed data - only data that is inserted to video source table included.
 */
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
		
}