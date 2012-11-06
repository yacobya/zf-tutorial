  <?php
 /**
 *  class bootstrap operation
 *
 *  Supply services related to Bootstrap operation - before routing to selected controoler. 
 */

  /**
   *  if authoentication requested, initialize plug in to perform autoentication process.
   *
   *  the function registers the Authoentication class as ZF plugin. Enabled access check before perfromin an operation.
   *
   * @return null
   */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		$fc = Zend_Controller_Front::getInstance();
		if (!BYPASS_AUTHORIZATION)
			// initializing ZF autoentication check		
			$fc->registerPlugin(new Application_Plugin_AccessCheck());	
	}
	/**
	 *  initializes GUI navigation tree
	 *  
	 *  clears browsers cach (during devellopment), reads GUI navigation tree from xml file and set the view container with
	 *  tree data to be displayed. 
	 *
	 * @return null
	 */	
	protected function _initNavigationTree ()
	{
		if  (DEVELOPMENT) clearstatcache();// clear browser cache to enable CSS development
		$this->bootstrap('layout');
		$layout=$this->getResource('layout');
		$view=$layout->getView();
		$navContainerConfig= new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml','nav' );
		$navContainer = new Zend_Navigation($navContainerConfig);
		$view->navigation($navContainer);		
	} 

}

