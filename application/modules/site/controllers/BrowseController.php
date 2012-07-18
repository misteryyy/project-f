<?php

class Site_BrowseController extends Boilerplate_Controller_Action_Abstract
{
	
 	/**
 	 * Browse Members
 	 */
    public function memberAction()
    {    
    	
    	// create search engine
    	//debug($this->_request->getParams());
    	
    	// find users
    	$facadeUser = new \App\Facade\UserFacade($this->_em);
    	
    	$us = $facadeUser->findAllUsersNative();
    	$this->dPr($us);
    	
    	$paginator = $facadeUser->findAllUsersPaginator($this->_member_id,$this->_request->getParams());
    	
    	$paginator->setItemCountPerPage(8); // items per page
    	$page = $this->_request->getParam('page', 1);
    	$paginator->setCurrentPageNumber($page);
    	$this->view->paginator = $paginator;
	}
      

    /**
     * Browse Projects
     */
    public function projectAction(){
    	// read params from url
    	$params = $this->_request->getParams();
    	$facadeProject = new \App\Facade\Site\ProjectFacade($this->_em);
    	// searching in categories
    	if(isset($params["category"])){
    		// Feeding projects
    		try{
    		$paginator = $facadeProject->findAllProjectsByCategory($params['category']);
    		
    		//additional params 
    		} catch (\Exception $e){
    			$this->_helper->FlashMessenger(array('error' => 'This categoory is not found. Are you trying to hack us?'));
    			$this->_redirect('/member/error/');
    		}
    			
    	} else {
    		// get all projects
    		$paginator = $facadeProject->findAllProjectsPaginator();
    	}
    	
    	// if  nothing is  set show all projects
    	$config = Zend_Registry::get('config');
    	$paginator->setItemCountPerPage($config['app']['project']['count_per_page']); // items per page
    	$page = $this->_request->getParam('page', 1);
    	$paginator->setCurrentPageNumber($page);
    	$this->view->paginator = $paginator;
    	

    

    		
    }
     
     
   
}