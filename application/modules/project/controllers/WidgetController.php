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
	 * New Applicantions Level 1
	 */ 
    public function applicationAction(){
		$this->checkProject();
		// check if application has been sent
		if($this->facadeAcl->projectApplicationHasBeenSent($this->_member_id, $this->project_id)) {
			$this->view->aclPermissionDenied = true;
			//return;
		} 
			$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);
			$questions = $facadeTeam->findAllProjectRoleWidgetQuestions($this->project_id);
			$form = new \App\Form\Project\AddProjectApplicationForm($this->_member, $this->project, $questions);
			$this->view->form = $form;			
    }
    
    /**
     * New Applicantions Level 2
     */
    public function applicationLevel2Action(){
    	$this->checkProject();
    	// check if application has been sent
    	if($this->facadeAcl->projectApplicationHasBeenSent($this->_member_id, $this->project_id)) {
    		$this->view->aclPermissionDenied = true;
    		//return;
    	}
    	$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);

    	// free positions
    	$freePositions = $facadeTeam->findFreeProjectRolesForProject($this->project_id,array("role"=>"all"));
    	$this->view->freePositions = $freePositions;
 
    	// todo create forms for applying for all roles
    	$form = new \App\Form\Project\AddProjectApplicationLevel2Form($this->_member, $this->project, $freePositions, \App\Entity\ProjectRole::PROJECT_ROLE_STARTER);
    	$this->view->member = $this->_member;
    	$this->view->form = $form;
    	 		
    }
    
    
    
    /**
     * Module for tasks and levels
     */
    public function taskAction(){
    	$this->checkProject();
    	$facadeTask = new \App\Facade\Project\TaskFacade($this->_em);
    	
    	// return all task ordered by id and level
    	$tasks = $facadeTask->findTasksForProject($this->project_id);
    	$this->view->tasks = $tasks;
    	
    	 	 
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
    				break;
    				case 'create-level-2' :
    					// checking form
    					
    					//$form = new \App\Form\Project\AddProjectApplicationForm($this->_member, $this->project, $questions);
    					// validation data
    					if(trim($this->_request->getParam("content")) == ''){
    						$this->_helper->FlashMessenger(array('error' => 'Something is wrong with the form data. Have you filled all data in form?'));
    						$this->_redirect('/project/index/index/id/'.$this->project_id);
    					}
    					
    					try{
    						// sending the application
    						$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);	
    						$facadeTeam->createProjectApplication($this->_member_id, $this->project_id, $_POST);
    						// saving data and getting back to project
    						$this->_helper->FlashMessenger(array('success' => "You application has been sent."));
    						$this->_redirect('/project/index/index/id/'.$this->project_id); // go back to the project
    				
    					}catch (\Exception $e){
    						$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
    						$this->_redirect('/project/index/index/id/'.$this->project_id); // go back to the project
    							
    					}
    					break;
    				
    				
    			  }
    	} else {
    		$this->_response->setHttpResponseCode(503); // echo error
    	
    	}
    	
    	
    
    }
    
}

