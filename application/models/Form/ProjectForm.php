<?php
class Application_Model_Form_ProjectForm extends Zend_Form
 {
	protected $_formElements=array();
	
	public function __construct(){
		$this->initForm();
		parent::__construct();
		//insert hidden fields - controller and action
	}
	protected function initForm()
	{
		//add hidden controller and action names - enable to return to caller page
		// 
		$sourceController = new Zend_Form_Element_Hidden('sourceController');
		$sourceController->setRequired(true)
		->setAttrib('id','sourceController')
		->addFilter('StripTags')
		->addFilter('Alnum')
		->addValidator('alnum')
		->addFilter('StringTrim')
		->setValue('avi controller');
		$this->_formElements[]=$sourceController;
				
		$sourceAction = new Zend_Form_Element_Hidden('sourceAction');
		$sourceAction->setRequired(true)
		->setAttrib('id','sourceAction')
		->addFilter('StripTags')
		->addFilter('Alnum')
		->addValidator('alnum')
		->addFilter('StringTrim')
		->setValue('avi action');
		$this->_formElements[]=$sourceAction;
		
		// add error popup hidden field to be used by Javascript to popup error reprted by server
		//error text to be used by JS to popup error
		$this_errorPopup=new Zend_Form_Element_Hidden("errorPopup");
		$this_errorPopup->setAttrib('id','errorPopup');
		$this->_formElements[]=$this_errorPopup;
		
	}
	public function setError ($errMsg)
	{
		$this->_errorPopup->setValue($errMsg);
	
	}
	
	
		
}
