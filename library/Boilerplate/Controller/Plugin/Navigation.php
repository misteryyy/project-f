<?php
/**
 * Plugin for initialization of different navigations for system
 * @author misteryyy
 *
 */
class Boilerplate_Controller_Plugin_Navigation extends Zend_Controller_Plugin_Abstract {

    
	public function preDispatch(Zend_Controller_Request_Abstract $request){

		// Choosing with navigation file we will use
		switch ($request->getModuleName()){
			case "launch" : 
					$fileNavigation = "navigation-launch.xml";
					break;
			case "member" :
					$fileNavigation = "navigation-member.xml";
					break;
			case "project" :
					$fileNavigation = "navigation-project.xml";
					break;
			case "admin" :
					$fileNavigation = "navigation-admin.xml";
				break;
			default :
				$fileNavigation = "navigation.xml";
		}
		
		 // Get the view, we'll need to assign the navigation to it later
         $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
         if (null === $viewRenderer->view) $viewRenderer->initView();
         $view = $viewRenderer->view;

		 $config = new Zend_Config_Xml(APPLICATION_PATH. '/configs/navigation/'.$fileNavigation,'nav');
		 $navigation_container = new Zend_Navigation($config);
		 $view->navigation($navigation_container);
		 $view->navigation_container = $navigation_container;
	}

}

?>
