<?php

class Site_IndexController extends Boilerplate_Controller_Action_Abstract
{
 
    public function indexAction()
    {    
    	$this->view->pageTitle = 'FLO~ Grow.Lead...';
    	
    		// Feeding Slideshow
    		$facadeSlideshow = new \App\Facade\Admin\SlideshowFacade($this->_em);
    		$this->view->slideshow = $facadeSlideshow->findSlideshow();
    		
    		// Feeding projects
    		$facadeProject = new \App\Facade\Site\ProjectFacade($this->_em);
    		$paginator = $facadeProject->findAllProjectsPaginator();
    		$paginator->setItemCountPerPage(8); // items per page
    		$page = $this->_request->getParam('page', 1);
    		$paginator->setCurrentPageNumber($page);
    		$this->view->paginator = $paginator;
	
    
    }
      
    
    
    
    public function phpInfoAction(){
    			
    }
     

    public function headerAction()
    {    
    }
    
    public function leftMenuAction()
    {
    }
    
    public function breadcrumbsAction()
    {
    }
    
    /**
     * Learn More Page
     */
    public function learnMoreAction(){
    	
    	
    }
    

    
    public function sitemapAction()
    {
    	$this->view->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	echo $this->view->navigation()->sitemap()->setFormatOutput(true);
    
    }
    
    public function footerAction()
    { 
        $cache = Zend_Registry::get('cache');

        if ($cache->contains('timestamp')) {
            $timestamp = $cache->fetch('timestamp');
            $this->view->cachedTimestamp = true;
        } else {
            $timestamp = time();
            $cache->save('timestamp', $timestamp);
        }

        $this->view->timestamp = $timestamp;
    }
}