<?php
use Doctrine\ORM\Tools\Pagination as Paginator; // goes at top of file

class Member_DashboardController extends  Boilerplate_Controller_Action_Abstract
{

    public function indexAction()
    {
    	$member = Zend_Auth::getInstance()->getIdentity();
    	$this->view->pageTitle = $member['name'] . '\'s Dashboard ' ;
    	$this->_helper->_layout->setLayout('member-dashboard');
    	
    
    }
    
    /*
     * Generates user menu if is logged
     * TODO possible attack
     */
    public function memberMenuAction(){
    		
    }
    
    /**
     * FloBox Administration
     */
    public function floBoxAction(){
    	    	
    	$this->view->pageTitle = $this->_member['name'] . '\'s FLO~ Box / Administration' ;	
    	$form = new \App\Form\Member\FloBoxAdminForm();
    	$this->view->form = $form;
    	
    	$facade = new \App\Facade\FloBoxFacade($this->_em);
    	
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			// storing data
    			try{
    				$values = $form->getValues();
    				$facade->createFloMessage($this->_member_id,$values);
    				$this->_helper->FlashMessenger( array('success' => "Added successfully :D"));
    				$form->setDefaults(array());
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
    	
    	$zend_paginator = $facade->findFloMessages($this->_member_id);
    		//nastaveni poctu stranek list
    		$zend_paginator->setItemCountPerPage(3);
    		$page = $this->_request->getParam('page', 1); 	 
    		$zend_paginator->setCurrentPageNumber($page);
    	
    	$this->view->paginator = $zend_paginator;
    	     	
    }
   

}





