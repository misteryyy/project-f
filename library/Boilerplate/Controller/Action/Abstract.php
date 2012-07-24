<?php

abstract class Boilerplate_Controller_Action_Abstract extends Zend_Controller_Action {

   protected $_member = array(); 
   protected $_member_id = 1;
   protected $facadeAcl;
   
   /**
    * @var Doctrine\ORM\EntityManager
    */
   protected $_em = null;
   
   /**
    * @var \sfServiceContainer
    */
   protected $_sc = null;
   
   /**
    * @var \App\Service\RandomQuote
    * @InjectService RandomQuote
    */
   protected $_randomQuote = null;
      
 /**
  * Disable layout, prepare for Ajax
  */ 
 public function ajaxify(){
 	
 	if (Zend_Controller_Action_HelperBroker::hasHelper('layout')) {
 		$this->_helper->layout->disableLayout();
 	}
 	$this->_helper->viewRenderer->setNoRender(true);
 }  
   
 public function dPr($var){
 	\Doctrine\Common\Util\Debug::dump($var);
 }
 
 public function init(){

  // Setting up the instance for user who is logged or not
 	$this->_em = Zend_Registry::get('em');

 	$config = Zend_Registry::get('config');
 	$profilePhotoPathWeb = $config['app']['storage']['profile_web'];
     	
  	if(Zend_Auth::getInstance()->hasIdentity()){
    		$this->_member = Zend_Auth::getInstance()->getIdentity();	
    		$this->_member_id = $this->_member['id'];
  	}else {
    		
  			// load the first user, TODO delete on production	
  			$user = $this->_em->getRepository ('\App\Entity\User')->findOneById ( 1 );
  			if ($user) {
  				$userArray = array();
  				$userArray["name"] =$user->getName();
  				$userArray["email"] =$user->getEmail();
  				$userArray["id"] =$user->getId();
  				$userArray["roles"] =$user->getRolesArray();
  				$userArray["profile_picture_200"] = $profilePhotoPathWeb.$user->getProfilePicture(); 
  				$userArray["profile_picture_100"] = $profilePhotoPathWeb.$user->getProfilePicture(\App\Entity\User::PROFILE_PHOTO_RESOLUTION_100);
  				$userArray["profile_picture_50"] =  $profilePhotoPathWeb.$user->getProfilePicture(\App\Entity\User::PROFILE_PHOTO_RESOLUTION_50);  					
  			}
    		$this->_member = $userArray;	 
    		
    		$this->view->userWebStorage = '/storage/users/';
   }
    	
   $this->view->member = $this->_member;
   
   // for permission checking
   $this->facadeAcl = new \App\Facade\ACLFacade($this->_em);
   
   
  // Navigation settings
  $uri = $this->_request->getPathInfo();           
  $activeNav = $this->view->navigation()->findByUri($uri);
  $activeNav->active = true;
 
 
 } 


}