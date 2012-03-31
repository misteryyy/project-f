<?php

abstract class Custom_Controller_Action_Abstract extends Zend_Controller_Action {
   
	
 public function init(){
  $uri = $this->_request->getPathInfo();           
  $activeNav = $this->view->navigation()->findByUri($uri);
  $activeNav->active = true;
 
 
 } 


}