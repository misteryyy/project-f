<?php
class Boilerplate_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract {

    /**
     * @var Zend_Auth
     */
    protected $_auth;
    
    public function __construct(Zend_Auth $auth) {
        $this->_auth = $auth;
    }
    
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {       
        ////Check if the user is not logged in
        if (!$this->_auth->hasIdentity() 
        	&& 'member' == $request->getModuleName()
        		&& 'index' != $request->getControllerName()  ) { //everething in index controller is public

            return $this->_redirect($request, 'index', 'login', 'member');
        }
    }
    
    protected function _redirect($request, $controller, $action, $module) {

    	if ($request->getControllerName() == $controller &&
                $request->getActionName() == $action &&
                $request->getModuleName() == $module) {
            return true;
        }

        $url = Zend_Controller_Front::getInstance()->getBaseUrl();
        $url .= '/' . $module . '/' . $controller . '/' . $action;
  
        if (DEBUG) {
                debug_redirect($url);
          }
          
        $request->setModuleName('member');
        $request->setControllerName('index');
        $request->setActionName('login');
    }

}

?>
