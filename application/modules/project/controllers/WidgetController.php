<?php
/**
 * Widget for public project page
 * @author misteryyy
 *
 */
class Project_WidgetController extends  Boilerplate_Controller_Action_Abstract
{
	private $project_id = null;
	private $project = null;
	private $facadeProject;
	
	public function init(){
		parent::init();
		$this->facadeProject = new \App\Facade\ProjectFacade($this->_em);
		//$this->checkProject();
	}
	
	/*
	 * Check all neccessary things
	*/
	public function checkProject(){
		$id = $this->_request->getParam("id");
		// check id param for project
		if(!is_numeric($id)){
			$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
			$this->_redirect('/member/error/');
		}
		try{
			// init basic things
			$this->project = $this->facadeProject->findOneProject($id);
			$this->project_id = $id;
			$this->view->pageTitle = $this->project->title;
			$this->view->project = $this->project;
	
		} catch (\Exception $e){
			$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
			$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
			$this->_redirect('/member/error/');
		}
	}
	
    /**
	 * New Applicants module
	 */ 
    public function applicationAction(){
		$this->checkProject();
    	$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);
    	$questions = $facadeTeam->findAllProjectRoleWidgetQuestions($this->project_id);
    	$form = new \App\Form\Project\AddProjectApplicationForm($this->_member, $this->project, $questions);
    	$this->view->form = $form;
    	
    }
    
    /**
     * Ajax Handling for Applications
     */
    public function ajaxApplicationAction(){
    	$this->ajaxify();
    	$this->checkProject();
    	if($this->_request->isPost() || $this->_request->isGet()){
    		switch ($this->_request->getParam("_method")){
    			//  create new question
    			case 'create' :	
					// checking form
	   				$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);
    				$questions = $facadeTeam->findAllProjectRoleWidgetQuestions($this->project_id);
    				$form = new \App\Form\Project\AddProjectApplicationForm($this->_member, $this->project, $questions);   
    				
    				// validation data
    				if(!$form->isValid($this->_request->getParams())){
    					$this->_helper->FlashMessenger(array('error' => 'Something is wrong with the form data.'));
    					$this->_redirect('/project/index/index/id/'.$this->project_id);	
    				} 
    				try{
    					// sending the application
    					$facadeTeam->createProjectApplication($this->_member_id, $this->project_id,$form->getValues());
    					// saving data and getting back to project
    					$this->_helper->FlashMessenger(array('success' => "You application has been sent."));
    					$this->_redirect('/project/index/index/id/'.$this->project_id); // go back to the project
    						
    				}catch (\Exception $e){
    					$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
    					$this->_redirect('/project/index/index/id/'.$this->project_id); // go back to the project
    					    
    				}
    			  }
    	} else {
    		$this->_response->setHttpResponseCode(503); // echo error
    	
    	}
    	
    	
    
    }
    
}

