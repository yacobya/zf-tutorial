<?php
class Application_Model_Video_Config extends Application_Model_DbTable_ConfigAbstract
{
	// interface type =>horizontal pixels, vertical pixels,
	
	public $connection =array ('VGA'=>array(array (640,480),array (800,600), array(1024,768),array(1600,1200)),
							 'HDMI'=>array(array(1280,720),array(1920,1080)),
							 'RGBHV'=>array(array (640,480),array (800,600), array(1024,768),
							 		  array(1600,1200),array(1920,1080),array(1920,1200)),
							'COMPOSITE'=>array(array (768,576),array('800','600')));
	//resolutions
	public $resolutions=array('640:480','800:600','1024:768','1280,720','1600:1200','1920:1080','1920,1200');
							
	// screen ratio width:height
	public $_aspect_ratio=array('4:3'=>ARRAY(4,3), '16:9'=>array(16,9));
	const HORIZONTAL =0;
	const VERTICAL=1;
	const MAX_FRAMES_PER_SECOND=60;
		
	public $_defaultEncoderIP='192.168.0.1';
	public $defaultVideoSource=array('name'=>'default','description'=>'default video source','interface_type'=>'VGA',
									 'resolution'=>'1280:720','aspect_ratio'=>'16:9','encoder_IP'=>0,
									 'encoder_fps'=>20,'encoder_MBR'=>10);
			
	/**
	 *  public function returns video source table schema
	 *
	 *  returns an SQL command that create video source table if not exists

	 *
	 * @param  string                   $tableName   table name
	 * @return string                   $videoSourceSchema string identify SQL command for table creation
	*/
	public function getDBSchema ($tableName)
	{	
		// create ENUM values for SQL create table - list of availiable video I/F and aspect ratio
		$videoInputENUM=$this->createENUMstr($this->connection);
		$aspecRatioENUM=$this->createENUMstr($this->_aspect_ratio);
			
		$videoSourceSchema ="CREATE  TABLE IF NOT EXISTS $tableName
		    (id INT UNSIGNED AUTO_INCREMENT NOT NULL,
			name CHAR(20) UNIQUE NOT NULL,
			description CHAR (100),
			interface_type ENUM ($videoInputENUM) NOT NULL,
			resolution CHAR (10),
			aspect_ratio ENUM ($aspecRatioENUM),
			encoder_IP INT NOT NULL,
			encoder_fps INT ,
			encoder_MBR INT NOT NULL,
			PRIMARY KEY (id))";
		
		return $videoSourceSchema; 
	
	}
	
	public function getVideoSourcesDefault ()
	{
		return ($this->$defaultVideoSource);
	}
		
	/**
	 * dataValidation
	 *
	 * validate data before insertion to DB 
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
	
	public function dataValidation($form,$data)
	{
		$errStr=null;
		if (!$form->isValid($data)) 
			return 'invalid data';
		// pass frmaework data validation
		if (strlen($data['name'])>20) $errStr="name length less than 20 chars<br>"; 
		if (strlen($data['description'])>100) $errStr=$errStr."Descriptiopn lenght must be less than 100 chars<br>";
		$tmp=array_search($data['resolution'], $this->resolutions);
		if (!array_key_exists($data['interface_type'], $this->connection)) $errStr=$errStr."illegal interface type<br>";
		if (array_search($data['resolution'], $this->resolutions)===FALSE)  $errStr=$errStr."unsupported resolution<br>";
		if (array_key_exists('aspect_ratio', $data))
		if (array_key_exists($data['aspect_ratio'], $this->_aspect_ratio)) $errStr=$errStr."unsupported aspect ratio<br>";
		if (ip2long($data['encoder_IP']===FALSE))$errStr=$errStr."illegal IP address<br>";
		if ($data['encoder_fps']>60 ||$data['encoder_fps']<15)   $errStr=$errStr."fps must be between 15-60<br>";
		
		if ($data['encoder_MBR']>60 || $data['encoder_MBR']<4)   $errStr=$errStr."encoder MBR must be betwwen 2-60Mbs<br>";
		
		
		return $errStr;	
	}
}