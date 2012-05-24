<?php

class Member_ProfileController extends  Boilerplate_Controller_Action_Abstract
{
		
	private $facadeFlobox;
	
	public function init(){
		parent::init();
		// check project existance for user and project
		$this->facadeFlobox = new \App\Facade\Member\FloBoxFacade($this->_em);
	}

    /**
     * Public Profile for Everybody
     */
    public function indexAction()
    {	 	
    	//try{
			$id = $this->_request->getParam("id");
    		if(is_numeric($id)){
    			$user = $this->_em->getRepository ('\App\Entity\User')->findOneById($id);
    			$this->view->user = $user;
    			$this->view->pageTitle = $user->getName() ." 's Profile " ;
    		} else {
    			$this->view->messages = array('error', 'This member is not found, are you trying to hack us? :D '); // extra message on top
    			    
    		}		 
    	
    }
    
    /**
     * Public Profile for Everybody
     */
    public function floboxAction()
    {    	
    	$this->view->pageTitle = 'FloBox' ;
    	
    	$zend_paginator = $this->facadeFlobox->findFloMessages($this->_member_id);
    	$zend_paginator->setItemCountPerPage(10); // items per page
    	$page = $this->_request->getParam('page', 1);
    	$zend_paginator->setCurrentPageNumber($page);
    	$this->view->paginator = $zend_paginator;
    	
     }
    
     /**
      * Check if the message is really for this owner
      */
     public function checkFloboxMessage(){
     	// checking message
     	$message_id = $this->_request->getParam("message_id");
     	// check id param for project
     	if(!is_numeric($message_id)){
     		$this->_helper->FlashMessenger(array('error' => 'This FloBox message is not found, are you trying to hack us? :D '));
     		$this->_redirect('/member/error/');
     	}
     	 
     	try{
     		return $this->facadeFlobox->findOneMessage($this->_member_id,$message_id);
     	}catch(\Exception $e){
     		$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
     		$this->_redirect('/member/error/');
     	}
     }
     
     
    /**
     * Detail of floBox message
     */
    public function floboxDetailAction()
    {
    		$message = $this->checkFloboxMessage();
			$form = new \App\Form\Member\FloBoxCommentForm($this->_member, $message->id);
    		
			// validation
			if ($this->_request->isPost()) {
				if ($form->isValid($this->_request->getPost())) {
					try{
						$values = $form->getValues();
						$this->facadeFlobox->createComment($this->_member_id, $values['flobox_id'],$values);
					
						$this->_helper->FlashMessenger( array('success' =>  "Comment has been added."));
					} catch (\Exception $e){
						$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
					}
				}
				// not validated properly
				else {
					$this->_helper->FlashMessenger( array('error' => "Please check your input."));
				}
			}
				
    		$this->view->form = $form;
    		$this->view->message = $message;
    		$this->view->pageTitle = 'FloBox Detail' ;
    		
    		
    	 
    }
    
    
}





