<?php

class Admin_IndexController extends Boilerplate_Controller_Action_Abstract {
	
	public function adminMenuAction(){
			
	}
	
	/*
	 * Sign up process, validation of form
	 */
	public function indexAction() {
		
		$this->view->pageTitle = 'Admin Dashboard';
		
// 		$form = new \App\Form\PublicMemberSignUp ();
// 		$this->view->form = $form;
		
// 		if ($this->_request->isPost ()) {
			
// 			if ($form->isValid ( $this->_request->getPost () )) {
				
// 				// finding user
// 				$user = $this->_em->getRepository ('\App\Entity\User')->findOneByEmail ( $form->getValue ( 'email' ) );
			
// 				// user doesn't exist, we can create new one
// 				if (! $user) {
					
// 					try {
						
// 						// storing the values
// 						$facadeUser = new \App\Facade\UserFacade($this->_em);
// 						$facadeUser->createAccount($form->getValues());
											
// 						// SUCCESS
// 						$this->_helper->FlashMessenger ( array ('success' => "Account created! Congratulations. You will get email with information to your email." ) );
// 						$this->_redirect('/member/index/login');
						
// 						// something bad happen with Doctrine
// 					} catch ( Exception $e ) {
// 						$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
// 					}
				
// 				} 				// user already exists
// 				else {
// 					$this->_helper->FlashMessenger ( array ('error' => "The provided e-mail address is already associated with a registered user." ) );
// 				}
			
// 			} 			// print error
// 			else {
// 				pr ( $form->getValues () );
// 				pr ( $this->_request );
// 				$this->_helper->FlashMessenger ( array ('error' => "Please take a look at the form again." ) );
// 			}
// 		}
	
	}
	



}





