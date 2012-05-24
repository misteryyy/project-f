<?php

class Site_IndexController extends Boilerplate_Controller_Action_Abstract
{
 
    public function indexAction()
    {    
    	$this->view->pageTitle = 'FLO~ Grow.Lead...';
    	
    	try{
    		$slideshowFacade = new \App\Facade\Admin\SlideshowFacade($this->_em);
    		$this->view->slideshow = $slideshowFacade->findSlideshow();
    	}
    	catch(\Exception $e){
			$this->_helper->FlashMessenger( array('error' =>  "Oops. Functionality of FLO is not good..."));				
		}
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