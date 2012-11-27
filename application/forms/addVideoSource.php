<?php	
class Application_Form_addVideoSource extends Application_Model_Form_ProjectForm
{
	/**
	 * Init
	 *
	 * Initialize  and create a form to add a new video source.
	 *
	
	 */
	public function init()
	{
		$dataConfig = new Application_Model_Video_Config(); // video data configuration model


		$this->setName('videoSources');
	
		//source id hidden field
		$element=$this->addFormElement('id',null,'Hidden',null,array('Int'),null);
		$this->_formElements[]=$element;
	
		//Video Source name
	    $element = $this->addFormElement('name','Source name','Text',null,($filters=array('StripTags','StringTrim')),null);
	    $element->setRequired(true);
	    $this->_formElements[]=$element;

	    //description field
		$element=$this->addFormElement('description','Description','Text',null,($filters=array('StripTags','StringTrim')),null);
		$this->_formElements[]=$element;
		 
		//interface type  selection
		foreach ($dataConfig->connection as $connector=>$resolutions) // compute selection array
			$typeSelection[$connector]=$connector;	
		$element=$this->addFormElement('interface_type','interface Type','Select',$typeSelection,null,null);// create element
		$element->setRequired(true);
		$this->_formElements[]=$element;

		// source resolution
		foreach ($dataConfig->resolutions as $sResolution) // compute selection option array
			$resolutionSelection[$sResolution] = $sResolution;
		
		$element=$this->addFormElement('resolution','Resolution','Select',$resolutionSelection,null,null);// create element
		$element->setRequired(true);
		$this->_formElements[]=$element;
		
		//encoder IP	
		$element=$this->addFormElement('encoder_IP','Encoder IP','Text',null,
						               array('StripTags'),null);// create element
		$element->setRequired(true);		
		$this->_formElements[]=$element;			
				
		//enoder fps - frames per seconds
		$element=$this->addFormElement('encoder_fps','Encoder fps (15-60)','Text',null,
								array('StripTags','Digits'),array('Digits'));// create element
		$this->_formElements[]=$element;
		
		//encoder MBR
		$element=$this->addFormElement('encoder_MBR','Encoder MBR (4-60)','Text',null,
				array('StripTags','Digits'),array('Digits'));// create element
		$this->_formElements[]=$element;
			
		// add video source submit buttons
		$buttons=array('Save', 'Save as','Cancel');
		foreach ($buttons as $button)
		{
			$submitButton = new Zend_Form_Element_Button("$button");
			$submitButton->setAttrib('type', "submit")
			              ->setAttrib('id', "$button")
						  ->setAttrib('class', "addVideoSourceBtn")
			              ->setLabel("$button")
						  ->setValue("$button");
						
			$this->_formElements[]=$submitButton;
		}
		

		
		
		$this->addElements($this->_formElements);
		$this->setMethod('post');
//		$this->setAttrib('onsubmit','return validateForm()');// JS check form
		$listVideoSourceUrl=Zend_Controller_Front::getInstance()->getBaseUrl().'/Config/addsource';
		$this->setAction($listVideoSourceUrl);

		
		
	}
	/**
	 * addFormElement
	 *
	 * create a form element 
	 *
	 * @param  string                   $name element name
	 * @param  string                   $label element form label
	 * @param  string					$elementType  element type (text/hiddent/select/...
	 * @param  string|array				$values array of element values (
	 * @param  string|array				$filters array of element filtesr
	 * @param  string|array				$validators array of element validators
	 * @param  string|array             $options String path to configuration file, or array/Zend_Config of configuration options
	 * @throws 
	 * @return Zend_Form_Element_*      $element  created element
	 */
	private function addFormElement($name,$label,$elementType,$values,$filters,$validators)
	{
		switch ($elementType)
		{
			case 'Hidden':
				$element=new Zend_Form_Element_Hidden($name);// create element	
				break;
			
			case 'Text':
				$element=new Zend_Form_Element_Text($name);// create element
				break;
			
			case 'Select':
				$element=new Zend_Form_Element_Select($name);// create element			
				$element->setMultiOptions($values);
				break;
				
			default:
				return null;
				
		}
		if ($label!=null) $element->setLabel($label); // set label
		if (($elementType!='Select')&&($values!=null)) $element->setValue($values);// set value
		
		if ($filters!=null) foreach ($filters as $filter) $element->addFilter($filter);// add filters
		if ($validators!=null) foreach ($validators as $validator) $element->addValidator($validator);// add filters
		return $element;		
	}
}
