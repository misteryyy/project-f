<?php

class Site_FileController extends Boilerplate_Controller_Action_Abstract
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em = null;

 
    public function init()
    {
    	parent::init();
        $this->_em = Zend_Registry::get('em');
       
        if (Zend_Controller_Action_HelperBroker::hasHelper('layout')) {
        	$this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(true);
    }
 
    public function indexAction()
    {
        
    }
      
    
}