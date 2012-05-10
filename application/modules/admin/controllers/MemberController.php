<?php

class Admin_MemberController extends Boilerplate_Controller_Action_Abstract {

	
	/*
	 * Sign up process, validation of form
	 */
	public function indexAction() {
		
		$this->view->pageTitle = 'Admin Dashboard';
		$facadeUser = new \App\Facade\UserFacade($this->_em);
		$this->view->users = $facadeUser->findAllUsers(); // default 3 resolution	

	}
	
	public function logAction(){
		
		
		
		
	}
	



}





