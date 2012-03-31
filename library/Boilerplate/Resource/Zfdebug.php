<?php
/**
 * 
 * @author misteryyy
 * Resource for ZFDebug collaborating with Doctrine entityManager
 */
class Boilerplate_Resource_ZFDebug
    extends Zend_Application_Resource_ResourceAbstract
{

    public function init()
    {
    	if (!DEBUG) {
     		return FALSE;
     	} // if debug mod is not on, don't display ZFDebug panel
    	
     	//var_dump(  );
     	 
     	$container = Zend_Registry::get('doctrine');
     	$em = $container->getEntityManager();
     	$em->getConnection()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());
     	

     //	var_dump($em->getConnection()->getConfiguration());
     	
     	$options = array(
     			'plugins' => array('Variables',
     					'ZFDebug_Controller_Plugin_Debug_Plugin_Debug' => array('tab' => 'Debug','panel' => ''),
     					'ZFDebug_Controller_Plugin_Debug_Plugin_Auth',
     					 'ZFDebug_Controller_Plugin_Debug_Plugin_Doctrine2'  => array(
                    'entityManagers' => array($em),
                ),
     					'Registry',
     					'File',
     					'Log',
     					'Memory',
     					'Exception')
     	);
    	
     	$debug = new \ZFDebug_Controller_Plugin_Debug($options);		
		$this->getBootstrap()->bootstrap('frontController');
		$frontController = $this->getBootstrap()->getResource('frontController');
		$frontController->registerPlugin($debug);

    }
}