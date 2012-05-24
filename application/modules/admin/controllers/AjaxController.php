<?php

class Admin_AjaxController extends  Boilerplate_Controller_Action_Abstract
{

	public function init() {
		//parent::init();
		
		$this->_em = Zend_Registry::get ( 'em' );
		if (Zend_Controller_Action_HelperBroker::hasHelper('layout')) {
			$this->_helper->layout->disableLayout();
		}
		$this->_helper->viewRenderer->setNoRender(true);

		$this->_response->setHeader('Content-type', 'application/json', true);
	
		
	}

    public function indexAction()
    {
    	$user = $this->_em->getRepository ('\App\Entity\User')->find(1);
    	pr($user->name);
    }
    
    
    /**
     * Ban Member
     */
    public function banUserAction(){
    	//pr($this->_getAllParams());
    	$id = $this->_getParam("id");
    	if(is_numeric($id)){
    		$user = $this->_em->getRepository ('\App\Entity\User')->findOneById ( $id );
    		if($user){
    				
    			$user->ban = ! $user->ban;
    			$this->_em->flush();
    			$this->_response->setHttpResponseCode(200);
    			$this->_response->setBody(json_encode(array("ban" => $user->ban)));
    		} else{
    			$this->_response->setHttpResponseCode(503);
    		}
    	}else {
    		$this->_response->setHttpResponseCode(503);
    		 
    	}    	
    }
    
    
    /**
     * Ban Project
     */
    public function banProjectAction(){
    	//pr($this->_getAllParams());
    	$id = $this->_getParam("id");
    	if(is_numeric($id)){
    		$project = $this->_em->getRepository ('\App\Entity\Project')->findOneById ( $id );
    		if($project){
    
    			$project->ban = ! $project->ban;
    			$this->_em->flush();
    			$this->_response->setHttpResponseCode(200);
    			$this->_response->setBody(json_encode(array("ban" => $project->ban)));
    		} else{
    			$this->_response->setHttpResponseCode(503);
    		}
    	}else {
    		$this->_response->setHttpResponseCode(503);
    		 
    	}
    }
    
    
 
   

}





