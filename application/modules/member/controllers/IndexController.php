<?php

class Member_IndexController extends  Boilerplate_Controller_Action_Abstract
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em = null;
	
	/**
	 * @var \sfServiceContainer
	 */
	protected $_sc = null;
	
	/**
	 * @var \App\Service\RandomQuote
	 * @InjectService RandomQuote
	 */
	protected $_randomQuote = null;

    public function init()
    {
          $this->_em = Zend_Registry::get('em');
    }

    public function indexAction()
    {
    
    	$tempQuote = $this->_randomQuote->getQuote();
    	$newQuote = new \App\Entity\Quote();

    	$newQuote->setWording($tempQuote[0]);
    	$newQuote->setAuthor($tempQuote[1]);
    	pr($newQuote);
    		$this->_em->persist($newQuote);
    		$this->_em->flush();
    	//	$this->indexQuote($newQuote);
    		
    	
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
    
    
    /*
     * Registration complete - sending emails 
     */
    public function signUpSuccessAction(){
    	/*
    	 * Sending new welcome emails
    	*/
    	pr($this->_request);
    	
    	//     	$mailer = new \App\Mailer\HtmlMailer();
    	//     	$mailer->setSubject("Welcome to FLO~ Platform")
    	//     	->addTo("j.kortan@gmail.com")
    	//     	->setViewParam('name',"Josef Kortan")
    	//     	->sendHtmlTemplate("welcome.phtml");

    	//$this->_helper->flashMessenger()->setNamespace('error')->addMessage('Flash error');
    	//$this->_helper->flashMessenger()->setNamespace('success')->addMessage('Flash messenger test');
    	   
    	
    }
    
    /*
     * Sign up process, validation of form
     */
    public function signUpAction(){
    	
    	$form = new \App\Form\PublicMemberSignUp();	 
    	$this->view->form = $form;
    	 
    	if ($this->_request->isPost()) {
    		
    		if ($form->isValid($this->_request->getPost())) {
    			// fetch values
    			$values = $form->getValues();
    			pr($form->getValues());
    			
    			//     
    			$newQuote = new \App\Entity\User();
                $newQuote->setWording($values['quote']);
                $newQuote->setAuthor($values['name']);
    			
    			
    			
    			$this->_helper->FlashMessenger(array('success' => "Account created! Congratulations. You will get email with information to your email: "));
    			$this->_redirect('/member/index/login');		
    		}
    		 
    		// print error
    		else {
    			pr($form->getValues());
    			pr($this->_request);
    			 
    			$this->_helper->FlashMessenger(array('error' => "Please take a look at the form again."));   		
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





