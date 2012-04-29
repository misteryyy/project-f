<?php

abstract class Boilerplate_Controller_Action_Abstract extends Zend_Controller_Action {

   protected $_member = array(); 
	
 public function init(){
 	
  // Setting up the instance for user who is logged or not
     	
  	if(Zend_Auth::getInstance()->hasIdentity()){
    	
    		$this->_member = Zend_Auth::getInstance()->getIdentity();
  	}else {
    		
    		$userArray = array();
    		$userArray["name"] = "Anonymous Visitor";
    		$userArray["email"] = "unregistred@now.lula";
    		$userArray["id"] = -1; 
    		$this->_member = $userArray;	 
    }
    	
   $this->view->member = $this->_member;
 	
  $uri = $this->_request->getPathInfo();           
  $activeNav = $this->view->navigation()->findByUri($uri);
  $activeNav->active = true;
 
 
 } 


}