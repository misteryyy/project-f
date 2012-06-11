<?php

class Launch_IndexController extends Boilerplate_Controller_Action_Abstract
{
 
    public function indexAction()
    {    
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow.';
    	
    }
    
    public function rulesAction()
    {
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - Rules';
    	 
    }
    
    public function faqAction()
    {
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - FAQ';
    
    }
    
    	/*
    	 * Sign up process, validation of form
    	*/
    	public function signUpAction() {

    		
    		$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - SignUp';
    		$form = new \App\Form\Launch\SignupForm();
    		$this->view->form = $form;
    	
    		if ($this->_request->isPost ()) {		
    			if ($form->isValid ( $this->_request->getPost () )) {
    					try {
    						// storing the values
    						$facadeLaunch = new \App\Facade\Launch\LaunchFacade($this->_em);
    						$facadeLaunch->createBetaAccount($form->getValues()); 							
    						// SUCCESS
    						$this->_helper->FlashMessenger ( array ('success' => "Sign for BETA FLO~ was success. We are proud to have you on our board." ) );
    						$this->_helper->redirector('index', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName());
    						 
    					} catch ( Exception $e ) {
    						$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
    					}	 	    					
    			} 			
    			else {
    				pr ( $form->getValues () );
    				pr ( $this->_request );
    				$this->_helper->FlashMessenger ( array ('error' => "Please take a look at the form again." ) );
    			}
    		}
    	
    	}
	
   
    
    
    /**
     * Handler for ajax form for newsletters
     */
    public function ajaxNewsletterAction(){
    	
    	
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