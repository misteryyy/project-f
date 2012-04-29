<?php

class Member_DashboardController extends  Boilerplate_Controller_Action_Abstract
{

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
   

}





