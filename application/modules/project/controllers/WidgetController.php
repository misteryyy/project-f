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
     * Author widget
     */
    public function authorAction(){
    	$this->checkProject();
    	
    	
    	// find users collaboration
    	$facadeCollaboration = new \App\Facade\Project\CollaborationFacade($this->_em);
    	$applications = $facadeCollaboration->findApplications($this->project->user->id, array('state'=>\App\Entity\ProjectApplication::APPLICATION_ACCEPTED ));
    	$this->collaborations = $applications;
    }
    
    /**
     * Poll Widget
     */
    public function pollAction(){
    	$this->checkProject();
    	$facadePoll = new \App\Facade\Project\PollFacade($this->_em);
    	
    	// check if there is any poll
    	try{
    		$poll = $facadePoll->findTheLastPollForProject($this->project_id);
    		$this->isPoll = true;
    	} catch (\Exception $e){
    		// there is no poll awailable
    		$this->form = null;
    		$this->isPoll = false;
    	}
    	
    	
    	// check if application has been sent
    	// try to check if the user has already voted
    		$answers = $facadePoll->findAllAnswersForUser($this->project_id, $this->_member_id, $poll->id);
    		if($answers){
	    		$this->view->answers = $answers;
	    		$form = new \App\Form\Project\PollForm($this->project,$poll,$answers);
	    		$this->view->form = $form;
	    		$this->view->countOfVotedMembers = count($poll->questions[0]->answers); // there must be always at least one question
	    		$this->view->hasVoted = true;
	    	} else {
	    		$form = new \App\Form\Project\PollForm($this->project,$poll);
	    		$this->view->form = $form;
	    		$this->view->hasVoted = false;	
    		}

    	// handle new voting
    	if($this->_request->isPost()){
	    	// validation data
	    	if($form->isValid($this->_request->getParams())){	
	    	 $facadePoll->answerPoll($this->project_id, $this->_member_id, $form->getValue("poll_id"),$form->getValues());
	    		$this->_helper->FlashMessenger(array('success' => 'You have answered the poll.'));
	    		$this->_redirect('/project/index/index/id/'.$this->project_id);
	    	} else {
	    		
	    		$this->_helper->FlashMessenger(array('error' => 'Something is wrong with the form data.'));
	    		$this->_redirect('/project/index/index/id/'.$this->project_id);
	    		 
	    	}
	    	
    	
    	}
    
    }
    
    /**
     * Simmilar projects Widget
     */
    public function similarAction(){
    	$this->checkProject();
    	// check if application has been sent
    }

    
    /**
     * Ajax Respond for polls
     */
    public function ajaxPollAction(){
    	$this->ajaxify();
    	$this->checkProject();

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
    	$this->view->member = $this->_member;
    	
    	 		
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

