<?php

class Member_ProfileController extends  Boilerplate_Controller_Action_Abstract
{
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em = null;
	
	/**
	 * @var \sfServiceContainer
	 */
	protected $sc = null;
	
	
	public function init()
	{
		parent::init();
		$this->_em = Zend_Registry::get('em');
	}
    /**
     * Public Profile for Everybody
     */
    public function indexAction()
    {	 	
    	//try{
			$id = $this->_request->getParam("id");
    		if(is_numeric($id)){
    			$user = $this->_em->getRepository ('\App\Entity\User')->findOneById ( $id  );
    			$this->view->user = $user;
    			$this->view->pageTitle = $user->getName() ." 's Profile " ;
    			
    		} else {
    			$this->view->messages = array('error', 'This member is not found, are you trying to hack us? :D '); // extra message on top
    			    
    		}		 
    	
    	//}
    	//catch (Exception $e){
   // 		$this->_helper->FlashMessenger( array('error' => $e->getMessage()));
    //	}
   
    	//$member = Zend_Auth::getInstance()->getIdentity();
		
    	
    	
    	
    }
    
}





