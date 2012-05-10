<?php

class Member_ProjectController extends  Boilerplate_Controller_Action_Abstract
{

	public function init(){
		
		parent::init();
		debug($_SESSION);
	}
	
	
    public function indexAction()
    {
    	//$member = Zend_Auth::getInstance()->getIdentity();
    	//$this->view->pageTitle = $member->name . '\'s Dashboard \  ' ;
    }
    
    /**
     * 
     */
    public function createProjectStepOneAction()
    {
    	$this->view->pageTitle = "Create Project " ;
    	$this->view->step = 1; // for generation menu
    	
    	// get categories for form
    	$facadeProject = new \App\Facade\ProjectFacade($this->_em);
    	$categories = $facadeProject->findAllProjectCategoriesArray();
    	
    	$form = new \App\Form\MemberCreateProjectStep1($categories);
  
    	if ($this->_request->isPost()) {
    		
    
    		$values = $form->getValues();
    		debug($this->_request->getPost());
    		
    		if ($form->isValid($this->_request->getPost())) {
    			// store data to session, user can cancel the project in the end
    			$session_step1 = new Zend_Session_Namespace('projectStep1');
    			$session_step1->firstFormData = $form->getValues();
    			// fetch values
    			$this->_helper->FlashMessenger( array('info' => "Time to Choose profile Picture"));
    			debug('Current Session Data');
    			debug($session_step1->firstFormData);
    			$this->_redirect('/member/project/create-project-step-two');
    			
    			
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('info' => var_export($values)));
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    		
    		}
    	}

    	if(Zend_Session::namespaceIsset('projectStep1')){	     	
    		$session = Zend_Session::namespaceGet('projectStep1');
    		if(isset($session['firstFormData'])){
    			$form->setDefaults($session['firstFormData']);
    		}
    	};
    	
    	//display form
    	$this->view->form = $form;
    	
    }
    
    
    /**
     * Create Project Picture
     */
    public function createProjectStepTwoAction()
    {
    	// check if session from one
    	if(!Zend_Session::namespaceIsset('projectStep1')){
    		$this->_helper->FlashMessenger( array('success' => "I can't wait so long. You have to start again. Sorry :D"));
    		$this->_redirect("member/project/create-project-step-one");
    	}
    	
    	$this->view->pageTitle = "Choose Picture representing project " ;
    	$this->view->step = 2; // for generation menu
    	
    	// VALIDATION IS DONE BY JQUERY ONLY  
    	$form = new \App\Form\MemberCreateProjectStep2();
    	//then process your file, it's path is found by calling $upload->getFilename()
    	$this->view->form = $form;
    	// Checking the file
       
    }
 
     	
    /**
     * Roles Setting
     */
    public function createProjectStepThreeAction()
    {
    	// check if session from two
    //	if(!Zend_Session::namespaceIsset('projectStep2')){
    //		$this->_helper->FlashMessenger( array('success' => "I can't wait so long. You have to start again. Sorry :D"));
    //		$this->_redirect("member/project/create-project-step-two");
    //	}

    	$this->view->pageTitle = "Roles Setting" ;
    	$this->view->step = 3; // for generation menu
    	 
    	// VALIDATION IS DONE BY JQUERY ONLY
    	$form = new \App\Form\MemberCreateProjectStep3();
    	//then process your file, it's path is found by calling $upload->getFilename()
    	$this->view->form = $form;
    	
    	
    	if ($this->_request->isPost()) {
    	
    		$values = $form->getValues();
    		debug($this->_request->getPost());
    	
    		if ($form->isValid($this->_request->getPost())) {
    			// store data to session, user can cancel the project in the end
    			$session_step3 = new Zend_Session_Namespace('projectStep3');
    			$session_step3->thirdFormData = $form->getValues();
    			// fetch values
    			debug('Current Session Data');
    			debug($session_step1->thirdFormData);
    			$this->_helper->FlashMessenger( array('success' => "Lets to the survey"));
    			$this->_redirect('/member/project/create-project-step-four');
    			 
    			 
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('info' => var_export($values)));
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    	
    		}
    	}
    	
    	if(Zend_Session::namespaceIsset('projectStep3')){
    		$session = Zend_Session::namespaceGet('projectStep3');
    		if(isset($session['thirdFormData'])){
    			$form->setDefaults($session['thirdFormData']);
    		}
    	};
    	 
    	//display form
    	$this->view->form = $form;
	
        
    }
 
    
    /**
     * Project Survey
     */
    public function createProjectStepFourAction()
    {
    	// check if session from one
    	if(!Zend_Session::namespaceIsset('projectStep3')){
    		$this->_helper->FlashMessenger( array('success' => "I can't wait so long. You have to start again. Sorry :D"));
    		$this->_redirect("member/project/create-project-step-three");
    	}
    	
    	$this->view->pageTitle = "Survey" ;
    	$this->view->step = 4; // for generation menu
    	// VALIDATION IS DONE BY JQUERY ONLY
    	//$form = new \App\Form\MemberCreateProjectStep2();
    	//then process your file, it's path is found by calling $upload->getFilename()
    	//$this->view->form = $form;
    	// Checking the file
    }
    
    /**
     * Project Survey
     */
    public function createProjectStepFiveAction()
    {
    	// check if session from one
    	if(!Zend_Session::namespaceIsset('projectStep4')){
    		$this->_helper->FlashMessenger( array('success' => "I can't wait so long. You have to start again. Sorry :D"));
    		$this->_redirect("member/project/create-project-step-four");
    	}
    	
    	$this->view->pageTitle = "Publish Project" ;
    	$this->view->step = 5; // for generation menu
    
    	// VALIDATION IS DONE BY JQUERY ONLY
    	$form = new \App\Form\MemberCreateProjectStep2();
    	//then process your file, it's path is found by calling $upload->getFilename()
    	$this->view->form = $form;
    	// Checking the file
    
    }
    
    
    
    
    
}





