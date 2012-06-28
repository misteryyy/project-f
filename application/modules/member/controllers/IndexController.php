<?php

class Member_IndexController extends Boilerplate_Controller_Action_Abstract {

	
	public function indexAction() {
	
		$this->_redirect('/member/dashboard');
	}
	
	/*
	 * Lost password 
	*/
	public function lostPasswordAction() {	
		$this->view->pageTitle = 'Lost password';

		$form = new \App\Form\Site\LostPasswordForm();
		$this->view->form = $form;
		
		if ($this->_request->isPost ()) {
				
			if ($form->isValid ( $this->_request->getPost () )) {
				// finding user
				$user = $this->_em->getRepository ('\App\Entity\User')->findOneByEmail ( $form->getValue ( 'email' ) );	
				// user doesn't exist, we can create new one
				if ($user[0]) {	
					try {
						$value = createRandomHash(); // newpassword
						$user[0]->setPassword($value);
						echo $this->_em->flush ();
				
						// TODO SENDING EMAIL
						// $mailer = new \App\Mailer\HtmlMailer();
						// $mailer->setSubject("FLO~ Platform / Lost password")
						// ->addTo("j.kortan@gmail.com")
						// ->setViewParam('name',"Josef Kortan")
						// ->sendHtmlTemplate("lost-password.phtml");
				
						// SUCCESS
						$this->_helper->FlashMessenger ( array ('success' => "Now you can use this password to login to FLO~ '$value'" ) );
						//$this->_redirect('/member/index/login');
				
						// something bad happen with Doctrine
					} catch ( Exception $e ) {
						$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
					}
				}
				else {
					$this->_helper->FlashMessenger ( array ('error' => "The provided e-mail address is not associated with a registered user." ) );
				}
		
				$this->_helper->FlashMessenger ( array ('success' => 'New password was sent. After first login please change this password to new one' ) );
			//	$this->_helper->redirector('index', 'dashboard','member');
			
			} else {
				// $form->buildBootstrapErrorDecorators();
				$this->_helper->FlashMessenger ( array ('error' => 'Oops... something is wrong with your account email or password. Please try it again.' ) );
			}
			
		}
	//	$this->_helper->FlashMessenger ( array ('success' => "You have been logout." ) );

	}
	
	/*
	 * Logout from Account
	 */
	public function logoutAction() {
		Zend_Auth::getInstance()->clearIdentity();
		$this->_helper->FlashMessenger ( array ('success' => "You have been logout." ) );
		$this->_redirect('/');			
		
	}
	
	public function loginAction() {
		$this->view->pageTitle = 'Login';
		
		
		$form = new \App\Form\Site\LoginForm();
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
		
		$form = new \App\Form\Site\SignupForm();
		$this->view->form = $form;
		
		if ($this->_request->isPost ()) {
			
			if ($form->isValid ( $this->_request->getPost () )) {
				
				// finding user
				$user = $this->_em->getRepository ('\App\Entity\User')->findOneByEmail ( $form->getValue ( 'email' ) );
			
				// user doesn't exist, we can create new one
				if (! $user) {
					
					try {
						
						// storing the values
						$facadeUser = new \App\Facade\UserFacade($this->_em);
						$facadeUser->createAccount($form->getValues());
											
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
	



}





