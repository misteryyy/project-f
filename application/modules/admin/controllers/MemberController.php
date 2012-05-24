<?php

class Admin_MemberController extends Boilerplate_Controller_Action_Abstract {

	
	/*
	 * Sign up process, validation of form
	 */
	public function indexAction() {
		
		$this->view->pageTitle = "Member's Administration";
		$facadeUser = new \App\Facade\UserFacade($this->_em);
		$this->view->users = $facadeUser->findAllUsers(); // default 3 resolution	

	}
	
	public function logAction(){
		
		$this->view->pageTitle = "My Projects" ;
		 
		$id = $this->_request->getParam("id");
		if(is_numeric($id)){
			// get categories for form
			try{
				$facadeUser = new \App\Facade\UserFacade($this->_em);
				$this->view->logs = $facadeUser->findLogForUser($id);
				$this->view->user = $facadeUser->findOneUser($id);
			}catch(\Exception $e){
				$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));	
			}
			
		} else {
			$this->_helper->FlashMessenger( array('error' =>  "This user is not found, are you trying to hack us? :D "));
			
		}
		
		
	}
	



}





