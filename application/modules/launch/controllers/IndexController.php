<?php

class Launch_IndexController extends Boilerplate_Controller_Action_Abstract
{
 
    public function indexAction()
    {    
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow.';
    		
    	// count of registrated members
    	$facadeLaunch = new \App\Facade\Launch\LaunchFacade($this->_em);
    	$betaRegistrations = $facadeLaunch->findBetaAccounts();
    	$this->view->betaRegistrationCount = count($betaRegistrations); 
    	
    }

    public function aboutAction()
    {
        $this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - About';
    
    }
    
    public function privacyAction()
    {
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - Privacy & Terms';
    	 
    }
    
    public function faqAction()
    {
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - FAQ';
    
    }

    
    /*
     * Sign up process, validation of form
    */
    public function newsletterAction() {
    	$this->ajaxify(); 
    	
    	if ($this->_request->isPost ()) {
    		if ( trim($_POST['email']) != "" ) {
    			try {
    				// storing the values
    				$facadeLaunch = new \App\Facade\Launch\LaunchFacade($this->_em);
    				$facadeLaunch->createNewsleter($_POST);
    				// SUCCESS
    				$this->_helper->FlashMessenger ( array ('success' => "I think this one can remain the same. Whatever we have for the current one. It’s written somewhere..." ) );
    				$this->_helper->redirector('index', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName());
    					
    			} catch ( Exception $e ) {
    				$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
    			}
    		}
    		else {
    			$this->_helper->FlashMessenger ( array ('error' => "Something is wrong and you can't be sign-up for newsletter." ) );
    		}
    	}
    	 
    }
    
     
    
    
    	/*
    	 * Sign up process, validation of form
    	*/
    	public function signUpAction() {
    		$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow. - Early Access';
    		$form = new \App\Form\Launch\SignupForm();
    		$this->view->form = $form;
    	
    		if ($this->_request->isPost ()) {		
    			if ($form->isValid ( $this->_request->getPost () )) {
    					try {
    						// storing the values
    						$facadeLaunch = new \App\Facade\Launch\LaunchFacade($this->_em);
    						$facadeLaunch->createBetaAccount($form->getValues()); 							
    						// SUCCESS
    						$this->_helper->FlashMessenger ( array ('success' => "Thank you for choosing to be one of our Guinea pigs! Actually no, you are much much more than that. Please take a minute to read the welcome e-mail we’ve sent you....(minute)....and thanks for jumping on board!" ) );
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