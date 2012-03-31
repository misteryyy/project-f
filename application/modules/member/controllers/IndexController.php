<?php

class Member_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       // action body
    }
    
    public function signOffAction(){
    	
    }

    public function loginAction(){
    	
    	$form = new \App\Form\PublicMemberLogin();
    	//$form = new \App\Form\ExampleForm();	
    	$this->view->form = $form;
    	
    	if ($this->_request->isPost()) {
    	
    		if ($form->isValid($this->_request->getPost())) {
    			// fetch values
    			$values = $form->getValues();
    			$this->_helper->FlashMessenger(array('success' =>'Flash messenger test'));	
    		}
    		 
    		// print error
    		else {
    			//$form->buildBootstrapErrorDecorators();
    			$this->_helper->FlashMessenger(array('success' => 'Flash messenger test'));
    		}
    	}
    	
    	
    	
    }
    
    public function signUpAction(){
    	
    	/*
    	 * Sending new welcome emails
    	 */	
//     	$mailer = new \App\Mailer\HtmlMailer();
//     	$mailer->setSubject("Welcome to FLO~ Platform")
//     	->addTo("j.kortan@gmail.com")
//     	->setViewParam('name',"Josef Kortan")
//     	->sendHtmlTemplate("welcome.phtml");
    		
   

    	//$this->_helper->flashMessenger()->setNamespace('error')->addMessage('Flash error');
    	//$this->_helper->flashMessenger()->setNamespace('success')->addMessage('Flash messenger test');   	

    	
    	$form = new \App\Form\PublicMemberSignUp();
    	//$form = new \App\Form\ExampleForm();
    	 
    	$this->view->form = $form;
    	 
    	if ($this->_request->isPost()) {
    		
    		if ($form->isValid($this->_request->getPost())) {

    			// fetch values
    			$values = $form->getValues();
    		}
    		 
    		// print error
    		else {
    			$form->buildBootstrapErrorDecorators();
    			$this->view->messages = array('error', 'Please control your input!'); // extra message on top
    			 
    		}
    	}
    	 
    	
    	
    	
    	
    	
    	
    }
    
    public function headerAction()
    {
        // action body
    }

    public function footerAction()
    {
        // action body
    }


}





