<?php

class Site_BrowseController extends Boilerplate_Controller_Action_Abstract
{
	
	
 	/**
 	 * Browse Members
 	 */
    public function memberAction()
    {    
 		
    	// Feeding projects
    	$facadeProject = new \App\Facade\Site\ProjectFacade($this->_em);
    	$paginator = $facadeProject->findAllProjectsPaginator();
    	$paginator->setItemCountPerPage(8); // items per page
    	$page = $this->_request->getParam('page', 1);
    	$paginator->setCurrentPageNumber($page);
    	$this->view->paginator = $paginator;
	
    
    }
      

    /**
     * Browse Projects
     */
    public function projectAction(){
    	
    	// Feeding projects
    	$facadeProject = new \App\Facade\Site\ProjectFacade($this->_em);
    	$paginator = $facadeProject->findAllProjectsPaginator();
    	$paginator->setItemCountPerPage(8); // items per page
    	$page = $this->_request->getParam('page', 1);
    	$paginator->setCurrentPageNumber($page);
    	$this->view->paginator = $paginator;
    			
    }
     
     
   
}