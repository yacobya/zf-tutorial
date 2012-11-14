 <?php
/**
 * Manage video source DB table
 * 
 * Supports: get all video sources, delete video source,  update video source,
 * get video source and create default Video source services.
 * 
 * @author Avi Yacoby
 *
 */
class Application_Model_DbTable_Video extends Zend_Db_Table_Abstract
      
{
	protected  $_dbConfig;
	protected  $_name='cc_video_sources';
	protected  $_dbAdapter ;
	protected  $_dbh;
/**
 * constructor - initialize DB adapter and creates table if not exists 
 */	
	public function __construct ()      
	{
		// create table if not exist
		//$dbAdapter=getAdapter();
		$this->_dbAdapter=$this->getDefaultAdapter();
		$this->_dbConfig=new Application_Model_Video_Config();
		$sqlCreateTable=$this->_dbConfig->getDBSchema($this->_name);
		$this->_dbh=$this->_dbAdapter->getConnection();
		$result = $this->_dbAdapter->getConnection()->exec($sqlCreateTable);// create table if not exist
		parent::__construct();

	}
	/**
	 * create default video source if not exists.
	 */
	public function init ()
	{
		//check default element existance
		$defaultVideoSource=$this->getVideoSource('name','default');
		if ($defaultVideoSource==null)
			$this->createDefaultVideoSource(); // create default source record in db
		
	}
/**
 * get all video sources from db table
 * @return array db elements
 */
	public function getAllVideoSources()
	{
		return $this->fetch();
	}
/**
 * Delete video source from DB
 * 
 * @param string $key  column id (DB table key name)
 * @param string $keyValue key value (selected key value - for row to be deleted).
 */
	public function deleteVideoSource($key, $keyValue)
	{
		$this->delete("$key =" . $keyValue);
	}
/**
 * add video source to DB
 * 
 * @param array $data video source data
 * @param string $updateKey in case of element update, identify element key column otherwise null
 * @param string $updateValue in case of element update, identify element key value
 * @return string DB query results, null if error.
 */	
	
	public function addVideoSource ($data,$updateKey,$updateValue)
	{
		/**
		 * add/update video source to db table
		 */
		$videoSource=$data;
		// filter out fields that are not related to DB		
		foreach ($data as $key=>$value)
		{
			if (!(array_key_exists($key, $this->_dbConfig->defaultVideoSource)))
				unset($videoSource[$key]);
		}
		//data already validated
//		$errMsg=$this->_dbConfig->dataValidation($videoSource);

		// convert ip address
		$videoSource['encoder_IP']=ip2long($videoSource['encoder_IP']); // convert encoder IP address from string to long
		$errMsg=NULL;
		$result=0;
		try {
			if ($updateKey==null)
			{
				// add new element
				//check that there is no element with this name
				$result=$this->getVideoSource('name',$videoSource['name']);
				if ($result==null) // new element
				{
					$result=$this->insert($videoSource);
					if ($result!=1)
						$errMsg='Add element failure';
				}
				else // element already exist
					$errMsg='Error: video source with this name already exist<br>';				
			}
			else //insert
			{
				$where = $this->getAdapter()->quoteInto("$updateKey= ?", $updateValue);
				//$result=$this->update($videoSource,"WHERE $updateKey=$updateValue");
				$result=$this->update($videoSource,$where);
				if ($result!=1)
					$errMsg='Update element failure';			
			}
				
		} catch (Exception $e){
			$errMsg=$e->getMessage();
			return ;
			
		}
		return $errMsg;
				
	}
/**
 * read video source element from DB
 * 
 * @param string $key  column id (DB table key name)
 * @param string $keyValue key value (selected key value to be read).
 * @return NULL
 */
 	public function getVideoSource($key,$keyValue)
	{
		$userQuery= $key. " = " . "'$keyValue'";
		$row = $this->fetchRow($userQuery);
		if (!$row) {
			return null;
		}
		return $row->toArray();			
	}
/**
 * create default video source element
 */
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
