 <?php

class Application_Model_DbTable_Video extends Zend_Db_Table_Abstract
      
{
	protected  $_dbConfig;
	protected  $_name='cc_video_sources';
	protected  $_dbAdapter ;
	protected  $_dbh;
	
	public function __construct ()      
	{
		// create table if not exist
		//$dbAdapter=getAdapter();
		$this->_dbAdapter=$this->getDefaultAdapter();
		$this->_dbConfig=new Application_Model_Video_Config();
		$sqlCreateTable=$this->_dbConfig->getVideoSourcesDBSchema($this->_name);
		$this->_dbh=$this->_dbAdapter->getConnection();
		$result = $this->_dbAdapter->getConnection()->exec($sqlCreateTable);// create table if not exist
		parent::__construct();

	}
	public function init ()
	{
		//check default element existance
		$defaultVideoSource=$this->getVideoSource('name','default');
		if ($defaultVideoSource==null)
			$this->createDefaultVideoSource(); // create default source record in db
		
	}

	public function getAllVideoSources()
	{
		return $this->fetch();
	}

	public function deleteVideoSource($key, $keyValue)
	{
		$this->delete("$key =" . $keyValue);
	}
	
	
	public function addVideoSource ($data,$updateKey,$updateValue)
	{
		//  add/update video source
		
		
		$videoSource=$data;
		// filter out fields that are not related to DB		
		foreach ($data as $key=>$value)
		{
			if (!(array_key_exists($key, $this->_dbConfig->defaultVideoSource)))
				unset($videoSource[$key]);
		}
		//data already validated
//		$errStr=$this->_dbConfig->dataValidation($videoSource);

		// convert ip address
		$videoSource['encoder_IP']=ip2long($videoSource['encoder_IP']); // convert encoder IP address from string to long
		try {
			if ($updateKey==null)// new record
				$result=$this->insert($videoSource)	;
			else //insert
			{
				$where = $this->getAdapter()->quoteInto("$updateKey= ?", $updateValue);
				//$result=$this->update($videoSource,"WHERE $updateKey=$updateValue");
				$result=$this->update($videoSource,$where);
			}
				
		} catch (Exception $e){
			$errorMsg=$e->getMessage();
			return null;
			
		}
		return $result;
				
	}
	
	public function updateVideoSource ($key,$data)
	{
		

	}
	public function getVideoSource($key,$keyValue)
	{
		$userQuery= $key. " = " . "'$keyValue'";
		$row = $this->fetchRow($userQuery);
		if (!$row) {
			return null;
		}
		return $row->toArray();
			
	}
	private function createDefaultVideoSource()
	{
		$defaultSourceData=$this->_dbConfig->defaultVideoSource ;
		//convert default encoder IP
		$tmp=$this->_dbConfig->_defaultEncoderIP;
		$tmp2=ip2long($this->_dbConfig->_defaultEncoderIP);
		$defaultSourceData['encoder_IP']=ip2long($this->_dbConfig->_defaultEncoderIP	);
		$this->insert($defaultSourceData);
	}
}// end of class
