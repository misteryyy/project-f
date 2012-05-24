<?php

class Admin_SlideshowController extends Boilerplate_Controller_Action_Abstract {
	
	/*
	 * Sign up process, validation of form
	 */
	public function indexAction() {
		
		$this->view->pageTitle = 'Admin Slideshow Settings';
	
		$slideshowFacade = new \App\Facade\Admin\SlideshowFacade($this->_em);
		
		
		$slideshow = $slideshowFacade->findSlideshow();

		$form1 = new \App\Form\Admin\SlideshowForm($slideshow->getProject(1),1);
		$form2 = new \App\Form\Admin\SlideshowForm($slideshow->getProject(2),2);
		$form3 = new \App\Form\Admin\SlideshowForm($slideshow->getProject(3),3);
		$form4 = new \App\Form\Admin\SlideshowForm($slideshow->getProject(4),4);
		$form5 = new \App\Form\Admin\SlideshowForm($slideshow->getProject(5),5);
	
		if ($this->_request->isPost()) {
			
			// select which form will be validated and updated
			$slot_position = $this->_request->getParam('slot_position');
			$formvar = "form".$slot_position;
			
			if ($$formvar->isValid($this->_request->getPost())) {
				try{
					$slideshowFacade->updateProject($this->_member_id,$this->_request->getParam('project_id'),$slot_position);
					$this->_helper->FlashMessenger( array('success' =>  "SLOT ".$slot_position.' has been updated.' ));
					$this->_redirect($this->view->url());
							
				}catch(\Exception $e){
					$this->_helper->FlashMessenger( array('error' =>  "Please check SLOT ".$slot_position ));
					$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
						
				}	
			}
			
			// not validated properly
			else {
				$this->_helper->FlashMessenger( array('error' => "Please check your input."));
			}
		}
		
		$this->view->form_slot_1 = $form1;
		$this->view->form_slot_2 = $form2;
		$this->view->form_slot_3 = $form3;
		$this->view->form_slot_4 = $form4;
		$this->view->form_slot_5 = $form5;
	
	}
	



}





