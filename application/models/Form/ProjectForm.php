<?php
/**
 * project form class
 * 
 * Derived from Zend form. Add to base class the hidden elements identifying source controller and action, set error if indicated 
 * to be displayed by form js.
 * @author Avi Yacoby
 *
 */
class Application_Model_Form_ProjectForm extends Zend_Form
 {
 	protected $_errorPopup;

	protected $_formElements=array();
	/**
	 * Constructor, initialize the form 
	 */
	public function __construct(){
		$this->initForm();
		parent::__construct();
		//insert hidden fields - controller and action
	}
	/**
	 * initialize the form
	 * 
	 * adding hidden elements identifying source controller and action - - enable to return to caller page. Create hidden element idefying
	 * error identified mainly during server side data validation.
	 */
	protected function initForm()
	{
		//add hidden controller and action names
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
		$this->_errorPopup=new Zend_Form_Element_Hidden("errorPopup");
		$this->_errorPopup->setAttrib('id','errorPopup')
						  ->setValue(null);
		$this->_formElements[]=$this->_errorPopup;
		
	}
	/** 
	 * Set error values
	 * @param string $errMsg
	 */
	public function setError ($errMsg)
	{
		$this->_errorPopup->setValue($errMsg);
	
	}
 }
