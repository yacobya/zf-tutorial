<?php
class Application_Model_Form_ProjectForm extends Zend_Form {
	protected $_formElements=array();
	public function __construct(){
		$this->initForm();
		parent::__construct();
		//insert hidden fields - controller and action
	}
	protected function initForm()
	{
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
		
	}
		
}
