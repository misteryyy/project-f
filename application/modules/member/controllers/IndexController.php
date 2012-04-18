<?php

class Member_IndexController extends Boilerplate_Controller_Action_Abstract {
	/**
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em = null;
	
	/**
	 *
	 * @var \sfServiceContainer
	 */
	protected $_sc = null;
	
	/**
	 *
	 * @var \App\Service\RandomQuote @InjectService RandomQuote
	 */
	protected $_randomQuote = null;
	
	public function init() {
		$this->_em = Zend_Registry::get ( 'em' );
	}
	
	public function indexAction() {
	
	}
	
	public function logoutAction() {
	
	}
	
	public function loginAction() {
		$this->view->pageTitle = 'Login';
		
		
		$form = new \App\Form\PublicMemberLogin ();
		// $form = new \App\Form\ExampleForm();
		$this->view->form = $form;
		
		
		if ($this->_request->isPost ()) {
			
			if ($form->isValid ( $this->_request->getPost () )) {
				// fetch values
				$values = $form->getValues ();
				
				$authAdapter = new \Boilerplate_Auth_Adapter_Doctrine2($form->getValue("email"), $form->getValue("password"));
				$result = Zend_Auth::getInstance()->authenticate($authAdapter);
				
				if ($result->isValid()) {
					//user is valid so store and redirect to admin home
					$this->_helper->FlashMessenger ( array ('success' => 'Login successful' ) );
					$this->_helper->redirector('index', 'dashboard','member');

				} else {					
					// $form->buildBootstrapErrorDecorators();
					$this->_helper->FlashMessenger ( array ('error' => 'Oops... something is wrong with your account email or password. Please try it again.' ) );	
				}	
			
			} 			
			// print error
			else {
				// $form->buildBootstrapErrorDecorators();
				$this->_helper->FlashMessenger ( array ('error' => 'Oops... something is wrong with your account email or password. Please try it again.' ) );
			}
		}
	
	}
	
	/*
	 * Sign up process, validation of form
	 */
	public function signUpAction() {
		
		$this->view->pageTitle = 'Sign up for FLO~';
		
		$form = new \App\Form\PublicMemberSignUp ();
		$this->view->form = $form;
		
		if ($this->_request->isPost ()) {
			
			if ($form->isValid ( $this->_request->getPost () )) {
				
				// finding user
				
				$user = $this->_em->getRepository ('\App\Entity\User')->findOneByEmail ( $form->getValue ( 'email' ) );
				
				// user doesn't exist, we can create new one
				if (! $user) {
					
					try {
						$user = new \App\Entity\User ();
						
						// loading data
						$user->name = $form->getValue ( 'name' ) ;
						$user->email = $form->getValue ( 'email' );
						$user->password = $form->getValue ( 'password' );
						$user->confirmed =  0 ;
						$this->_em->persist ( $user );
						$this->_em->flush ();
						
						// TODO SENDING EMAIL
						// $mailer = new \App\Mailer\HtmlMailer();
						// $mailer->setSubject("Welcome to FLO~ Platform")
						// ->addTo("j.kortan@gmail.com")
						// ->setViewParam('name',"Josef Kortan")
						// ->sendHtmlTemplate("welcome.phtml");
						
						// SUCCESS
						$this->_helper->FlashMessenger ( array ('success' => "Account created! Congratulations. You will get email with information to your email." ) );
						$this->_redirect('/member/index/login');
						
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
	
	public function headerAction() {
		// action body
	}
	
	public function footerAction() {
		// action body
	}

}





