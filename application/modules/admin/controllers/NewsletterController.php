<?php

class Admin_NewsletterController extends Boilerplate_Controller_Action_Abstract {
	
	/*
	 * Newsletter admin
	 */
	public function indexAction() {
		$this->view->pageTitle = 'Admin Newsletter';
	}

	/**
	 * Generate CVS file for signed users
	 */
	public function downloadAction(){
		$this->ajaxify();
		
		// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename=emails.csv');
		$fp = fopen('php://output', 'w');
	
		$facadeNewsletter = new \App\Facade\Admin\NewsletterFacade($this->_em);
		$users = $facadeNewsletter->getUserForNewsletter($this->_member_id);
					
		foreach ($users as $user) {
			fputcsv($fp, array($user->email));
		}
		fclose($fp);
	}

}