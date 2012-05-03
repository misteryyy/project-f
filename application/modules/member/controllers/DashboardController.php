<?php

class Member_DashboardController extends  Boilerplate_Controller_Action_Abstract
{
	
	
		/**
		 * @var Doctrine\ORM\EntityManager
		 */
		protected $_em = null;
	
		public function init()
		{
			parent::init();
			$this->_em = Zend_Registry::get('em');
		}

    public function indexAction()
    {
    	$member = Zend_Auth::getInstance()->getIdentity();
    	$this->view->pageTitle = $member['name'] . '\'s Dashboard ' ;
    }
    
    /*
     * Generates user menu if is logged
     * TODO possible attack
     */
    public function memberMenuAction(){
    		
    }
    
    
    /**
     * Maybe Ajax Adding of The data
     */
    public function floBoxAddMessage(){
    	
    	if (Zend_Controller_Action_HelperBroker::hasHelper('layout')) {
    		$this->_helper->layout->disableLayout();
    	}
    	$this->_helper->viewRenderer->setNoRender(true);
    }
     
    /**
     * FloBox Administration
     */
    public function floBoxAction(){
    	    	
    	$this->view->pageTitle = $this->_member['name'] . '\'s FLO~ Box / Administration' ;	
    	$form = new \App\Form\MemberFloBoxAdmin();
    	$this->view->form = $form;
    	    	
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			// storing data
    			try{
    				$facade = new \App\Facade\FloBoxFacade($this->_em);
    				$values = $form->getValues();
    				$facade->createFloMessage($this->_member_id,$values);
    				$this->_helper->FlashMessenger( array('success' => "Updated successfully :D"));
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
   

}





