<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{     
    public function _initConfig()
    {
    	Zend_Registry::set('config', $this->getOptions());
    }
    
    /*
     * Registering of better Twitter UI FlashMessenger 
     */
    public function _initRegViewHelpers(){
    	$this->bootstrap('layout');
    	$layout = $this->getResource('layout');
    	$view = $layout->getView();
    	$view->addHelperPath('Boilerplate/View/Helper','Boilerplate_View_Helper');
    }
  
    public function _initAutoloaderNamespaces()
    {
        require_once APPLICATION_PATH .
            '/../library/Doctrine/Common/ClassLoader.php';

        require_once APPLICATION_PATH .
            '/../library/Symfony/Component/Di/sfServiceContainerAutoloader.php';

        sfServiceContainerAutoloader::register();
        $autoloader = \Zend_Loader_Autoloader::getInstance();

        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Bisna');
        
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('App');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'App');
             
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Custom');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Custom');
         
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Boilerplate');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Boilerplate');

        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL\Migrations');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Doctrine\DBAL\Migrations');
    }

    public function _initModuleLayout()
    {
        $front = Zend_Controller_Front::getInstance();

        $front->registerPlugin(
            new Boilerplate_Controller_Plugin_ModuleLayout()
        );
        
        $front->setParam('prefixDefaultModule', true);
        $eh = new Zend_Controller_Plugin_ErrorHandler();
        $front = Zend_Controller_Front::getInstance()->registerPlugin($eh);
    }


    #Initializes the default timezone for the php ENV
    protected function _initDate() {
    	$config = new Zend_Config(Zend_Registry::get('config'));
 	
    	date_default_timezone_set($config->settings
    			->application
    			->datetime);
    }
    

    public function _initLocale()
    {
        $config = $this->getOptions();
        
        // Reading information about language setting
        try{
            $locale = new Zend_Locale(Zend_Locale::BROWSER);
                    
        } catch (Zend_Locale_Exception $e) {
            $locale = new Zend_Locale($config['resources']['locale']['default']);
        }

        Zend_Registry::set('Zend_Locale', $locale);

        $translator = new Zend_Translate(
            array(
                'adapter' => 'Csv',
                'content' => APPLICATION_PATH . '/../data/lang/',
                'scan' => Zend_Translate::LOCALE_DIRECTORY,
                'delimiter' => ',',
                'disableNotices' => true,
            )
        );

        if (!$translator->isAvailable($locale->getLanguage()))
            $translator->setLocale($config['resources']['locale']['default']);

        Zend_Registry::set('Zend_Translate', $translator);
        Zend_Form::setDefaultTranslator($translator);
    }

    /**
     * Set search engine
     */
    public function _initElasticSearch(){
        $es = new Elastica_Client();
        Zend_Registry::set('es', $es);
    }
    
    
    #initializes the DEBUG constant to true or false based on config. settings and/or cookie
    #and stores a copy of the Zend_Logger in the Registry for future references
    protected function _initDebug() {
    	
    	$config = new Zend_Config(Zend_Registry::get('config'));
    	if (isset($config->settings->debug->enabled)) {
    		
    		if ($config->settings->debug->enabled == TRUE) {
    					define('DEBUG', TRUE);
    		} else {
    			if (isset($config->settings->debug->cookie)) {
    				$debug_cookie = $config->settings->debug->cookie;
    
    				if (array_key_exists($debug_cookie, $_COOKIE)) {
    					define('DEBUG', TRUE);
    				}
    			}
    		}
    	}
    	if (FALSE === defined('DEBUG')) {
    		define('DEBUG', FALSE);
    	}
    	
    	$logger = new Zend_Log();
    	$writer = new Zend_Log_Writer_Firebug();
    	$logger->addWriter($writer);
    	Zend_Registry::set('logger', $logger);
    
    }

    // init Auth Plugin
//     protected function _initAuthPlugin() {
//     	Zend_Controller_Front::getInstance()->registerPlugin(
//     			new Boilerplate_Controller_Plugin_Auth(Zend_Auth::getInstance())
//     	);
//     }
    
    protected  function _initNavigationPlugin(){
    	Zend_Controller_Front::getInstance()->registerPlugin(new Boilerplate_Controller_Plugin_Navigation());
    	
    }
    
    //adding routes to the application
    protected function _initRewrite() {
    	$front = Zend_Controller_Front::getInstance();
    	$router = $front->getRouter();
    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
    	$router->addConfig($config,'routes');
    }
    

}