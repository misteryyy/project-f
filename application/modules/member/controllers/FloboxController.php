<?php
use Doctrine\ORM\Tools\Pagination as Paginator; // goes at top of file

class Member_FloboxController extends  Boilerplate_Controller_Action_Abstract
{

	private $facadeFlobox;
	
	public function init(){
		parent::init();
		// check project existance for user and project
		$this->facadeFlobox = new \App\Facade\Member\FloBoxFacade($this->_em);
	}
	
    public function indexAction()
    {
    	$this->view->pageTitle = $this->_member['name'] . '\'s FLO~ Box / Administration' ;

    	$zend_paginator = $this->facadeFlobox->findFloMessages($this->_member_id);
    	$zend_paginator->setItemCountPerPage(3); // items per page
    	$page = $this->_request->getParam('page', 1);
    	$zend_paginator->setCurrentPageNumber($page); 
    	$this->view->paginator = $zend_paginator; 
    }
    
    	/**
    	 *
    	 */
    	public function messageCreateAction()
    	{
    		$this->view->pageTitle = "Create Flo Message" ;
    		
     		$form = new \App\Form\Member\FloBoxAdminForm();
    		$this->view->form = $form;	
    		
    		if ($this->_request->isPost()) {
    			if ($form->isValid($this->_request->getPost())) {
    				// storing data
    				try{
    					$values = $form->getValues();
    					$this->facadeFlobox->createFloMessage($this->_member_id,$values);
    					$this->_helper->FlashMessenger( array('success' => "Added successfully :D"));
    					$this->_helper->redirector('index', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName());
    					
    				}
    				catch (Exception $e){
    					$this->_helper->FlashMessenger( array('error' => $e->getMessage()));
    				}
    			}
    			// not validated properly
    			else {
    				$this->_helper->FlashMessenger( array('error' => "Please control your input."));
    			}	 
    		}	
    	}
    	
    	/**
    	 * Delete FloBox Message
    	 */
    	public function messageDeleteAction()
    	{
    		$message = $this->checkMessage(); // returns update
    		try{ // update project data
    			$this->facadeFlobox->deleteMessage($this->_member_id, $message->id);
    			$this->_helper->FlashMessenger( array('success' =>  "Message has been deleted"));
    			$this->_helper->redirector('index', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName());
    	
    		} catch (\Exception $e){
    			$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
    		}
    		 
    	}
    		
    	/**
    	 * Check if the message is really for this owner
    	 */
    	public function checkMessage(){
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
    

   

}





