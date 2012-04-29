<?php

class Member_AjaxController extends  Boilerplate_Controller_Action_Abstract
{

	/**
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em = null;
	
	/**
	 *
	 * @var \sfServiceContainer
	 */
	protected $_sc = null;
	
	/**
	 *
	 * @var \App\Service\RandomQuote @InjectService RandomQuote
	 */
	protected $_randomQuote = null;
	
	public function init() {
		$this->_em = Zend_Registry::get ( 'em' );
		if (Zend_Controller_Action_HelperBroker::hasHelper('layout')) {
			$this->_helper->layout->disableLayout();
		}
		$this->_helper->viewRenderer->setNoRender(true);
	}

    public function indexAction()
    {
    	$user = $this->_em->getRepository ('\App\Entity\User')->find(1);
    	pr($user->name);
    	
    	
    	
    }
    
 
   

}





