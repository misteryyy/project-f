<?php

class Launch_IndexController extends Boilerplate_Controller_Action_Abstract
{
 
    public function indexAction()
    {    
    	$this->view->pageTitle = 'FLO~ Start.Build.Lead.Grow.';
    	
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
    	
    				// finding user
    				$user = $this->_em->getRepository ('\App\Entity\User')->findOneByEmail ( $form->getValue ( 'email' ) );
    					
    				// user doesn't exist, we can create new one
    				if (! $user) {
    						
    					try {
    	
    						// storing the values
    					//	$facadeUser = new \App\Facade\UserFacade($this->_em);
    					//	$facadeUser->createAccount($form->getValues());
    							
    						// SUCCESS
    						$this->_helper->FlashMessenger ( array ('success' => "Account created! Congratulations. You will get email with information to your email." ) );
    					//	$this->_redirect('/member/index/login');
    	
    						// something bad happen with Doctrine
    					} catch ( Exception $e ) {
    						$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
    					}
    	
    				} 				// user already exists
    				else {
    					$this->_helper->FlashMessenger ( array ('error' => "The provided e-mail address is already associated with a registered user." ) );
    				}
    					
    			} 			// print error
    			else {
    				pr ( $form->getValues () );
    				pr ( $this->_request );
    				$this->_helper->FlashMessenger ( array ('error' => "Please take a look at the form again." ) );
    			}
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