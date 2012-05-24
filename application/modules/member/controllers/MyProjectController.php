<?php
class Member_MyProjectController extends  Boilerplate_Controller_Action_Abstract
{
	
	private $project_id; // int id
	private $project;  // project object
	private $facadeComment;
	private $facadeProject;
	private $facadeProjectUpdate;

	public function init(){	
		parent::init();
		// check project existance for user and project
		$this->facadeProject = new \App\Facade\ProjectFacade($this->_em);	
		$this->facadeComment = new \App\Facade\Project\CommentFacade($this->_em);
		$this->facadeProjectUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
	}
	
	
	/**
	 * Modul for Team
	 */
	public function teamAction()
	{
		$this->checkProjectAndUser();
		$this->view->pageTitle = "Team" ;
		 
		$form = new \App\Form\Project\AddUpdateForm();
		 
		// update project survey
		if ($this->_request->isPost()) {
			if ($form->isValid($this->_request->getPost())) {
				// update survey
				$facadeProjectUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
				$facadeProjectUpdate->createProjectUpdate($this->_member_id, $this->project_id,$form->getValues());
				$this->_helper->FlashMessenger( array('success' => "New Update has been created."));
				$params = array('id' => $this->project_id);
				$this->_helper->redirector('update', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName(), $params);
				 
			}
			// not validated properly
			else {
				$this->_helper->FlashMessenger( array('error' => "Please check your input."));
			}
		}
		//display form
		$this->paginator = null;
		$this->view->form = $form;
		$this->view->project = $this->project;
	
	}
	
	/**
	 * Display Creators project for sign user
	 */
    public function surveyAction()
    {
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "My Projects Survey Admin" ;
    	// get categories for form
    	$facadeProjectSurvey = new \App\Facade\Project\SurveyFacade($this->_em);
    	$answers = $facadeProjectSurvey->findProjectSurveyAnswers($this->_member_id, $this->project_id);
    	
    	$questions = $facadeProjectSurvey->findAllProjectSurveyQuestionsArray();
    		 
    	$form = new \App\Form\Member\ProjectSurveyAdminForm($questions, $answers);

    	// update project survey
    	if ($this->_request->isPost()) { 		
    		if ($form->isValid($this->_request->getPost())) { 			
    			// update survey
    			$facadeProjectSurvey->updateProjectSurvey($this->_member_id, $this->project_id,$form->getValues());
    			$this->_helper->FlashMessenger( array('success' => "Your answers has been updated"));	 
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    		}
    	}
    	
    	// set empty answers
    	$this->view->emptyAnswers = $facadeProjectSurvey->findEmptyAnswers($this->_member_id, $this->project_id); 	 
    	//display form
    	$this->view->form = $form;
    	$this->view->project = $this->project;
    }
    
    /**
     * Update Administration / Displaying of updates
     */
    public function updateAction()
    {
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "My Projects Update" ; 
    	
    	// receiving paginator
    	$facadeProjectUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
	    	$paginator = $facadeProjectUpdate->findProjectUpdates($this->_member_id, $this->project_id);
	    	$paginator->setItemCountPerPage(3);
	    	$page = $this->_request->getParam('page', 1);
	    	$paginator->setCurrentPageNumber($page);
	    	$this->view->paginator = $paginator;
	    	$this->view->project = $this->project;
    }
     
    /**
     * 
     */
    public function updateCreateAction()
    {
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "Create Update" ;
    		 
    	$form = new \App\Form\Project\AddUpdateForm();
    	
    	// update project survey
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			// update survey
    			$facadeProjectUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
    			$facadeProjectUpdate->createProjectUpdate($this->_member_id, $this->project_id,$form->getValues());
    			$this->_helper->FlashMessenger( array('success' => "New Update has been created."));
    			$params = array('id' => $this->project_id);
    			$this->_helper->redirector('update', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName(), $params);
    			
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));		 
    		}
    	} 
    	//display form
    	$this->paginator = null;
    	$this->view->form = $form;
    	$this->view->project = $this->project;
    
    }
    
    
    public function checkUpdate(){
    	// checking update
    	$update_id = $this->_request->getParam("update_id");
    	// check id param for project
    	if(!is_numeric($update_id)){
    		$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
    		$this->_redirect('/member/error/');
    	}
    	
    	try{
    		return $this->facadeProjectUpdate->findOneUpdate($this->_member_id, $this->project_id,$update_id);	 
    	}catch(\Exception $e){
    		$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
    		$this->_redirect('/member/error/');
    	}
 
    }
    
    /**
     * Delete update for Project
     */
    public function updateDeleteAction()
    {
    	$this->checkProjectAndUser();
    	$update = $this->checkUpdate(); // returns update
    
    	try{ // update project data
    		$this->facadeProjectUpdate->deleteUpdate($this->_member_id, $this->project_id, $update->id);
    		$this->_helper->FlashMessenger( array('success' =>  "Update has been deleted"));
    		$params = array('id' => $this->project_id);
    		$this->_helper->redirector('update', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName(), $params); 
    		
    	} catch (\Exception $e){
    		$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
    	}
    	
    }
    
    /**
     * Edit update for Project
     */
    public function updateEditAction()
    {
    	$this->checkProjectAndUser();
    	$update = $this->checkUpdate(); // returns update
    	
    	$this->view->pageTitle = "Edit Update" ;	
    	$form = new \App\Form\Project\EditUpdateForm();
    	$error = false;
    	// update project survey
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			// update survey
    			$this->facadeProjectUpdate->updateProjectUpdate($this->_member_id, $this->project_id,$update->id,$form->getValues());
    			$this->_helper->FlashMessenger( array('success' => "Update has been updated."));
    			$params = array('id' => $this->project_id);
    			$this->_helper->redirector('update', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName(), $params);
    		
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
     			$error = true;
    		}
    	}
    	
    	// leave the old values, if user already sended form
    	if(!$error){
    		$data = array(
    				'title' => $update->title,
    				'content' => $update->content,
    		);
    	
    		$form->setDefaults($data);
    	}
    
    	//display form
    	$this->view->form = $form;
    	$this->view->project = $this->project;
    
    }
    
    
    
    /**
     * Edit Creator's Project
     */
    public function editProjectAction()
    {
    	$this->checkProjectAndUser();	
    	$this->view->pageTitle = "Edit project ".$this->project->getTitle();			
    	
    	$categories = $this->facadeProject->findAllProjectCategoriesArray();
    	$form = new \App\Form\Project\EditProjectForm($categories);
    		//then process your file, it's path is found by calling $upload->getFilename()
    		
    		// validate form
    		$error = false;
    		if ($this->_request->isPost()) {
    			if ($form->isValid($this->_request->getPost())) {
    				
    			try{ // update project data
    				$this->facadeProject->updateProject($this->_member_id,$this->project_id,$form->getValues());		
    				$this->_helper->FlashMessenger( array('success' =>  "Project Updated"));	
    			} catch (\Exception $e){
    				 $this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
    			}
    				
    			} 	
    			// not validated properly
       			else {
       					$this->_helper->FlashMessenger( array('error' => "Please check your input."));
       					$error = true;
       			}
    		}	
    		
    		// leave the old values, if user already sended form
    		if(!$error){
    			$data = array(
    					'title' => $this->project->title,
    					'category' => $this->project->category->id,
    					'priority' => $this->project->priority,
    					'pitch' => $this->project->pitchSentence,
    					'content' => $this->project->content,
    					'plan' => $this->project->plan,
    					'issue' => $this->project->issue,
    					'lesson' => $this->project->lesson,	
    					'project_tags' => $this->project->getTagsString()
    			);
    			 
    			$form->setDefaults($data);
    		}	
    		
    		$this->view->form = $form;
    		$this->view->project = $this->project;
    }
    
    /*
     * Check all neccessary things
     */
    public function checkProjectAndUser(){
    	$id = $this->_request->getParam("id");
    	// check id param for project
    	if(!is_numeric($id)){
   			$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
    		$this->_redirect('/member/error/');
    	}
    	try{
    		// init basic things
    		$this->project = $this->facadeProject->findProjectForUser($this->_member_id, $id);
    		$this->project_id = $id;
    	
    		
    	} catch (\Exception $e){
    		$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
    		$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
    		$this->_redirect('/member/error/');	
    	}	
    }
    
 
    
    
    /**
     * Comments for creator Section
     * Module for answering comments with higher priority
     */
    public function commentCreatorAction(){
    
    	$this->checkProjectAndUser();
    	 				
    	$this->view->pageTitle = $this->project->getTitle() . " ~ Comments for Creator" ;
    	$this->view->project = $this->project;
    	$form = new \App\Form\Project\AddCommentFromCreatorForm($this->_member,$this->project_id);	
    	$this->view->form = $form;
    	 
    	// validation and form handler
    		if ($this->_request->isPost()) {
    			if ($form->isValid($this->_request->getPost())) {
    				try{
    					$this->facadeComment->answerComment($this->_member_id,$this->project_id,$form->getValues());
    					$this->_helper->FlashMessenger( array('success' =>  "Comment has been added."));
    					$form->reset();
    				} catch (\Exception $e){
    					$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
    				}
    			}
    			// not validated properly
    			else {
    				$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    			}
    		}
    		
		// displaing comments
    	try{
    			// receiving comments for this project
    			$zendPaginator = $this->facadeComment->findUnasweredCommentsForProject($this->project_id);
    			$zendPaginator->setItemCountPerPage(1);
    			$zendPaginator->setCurrentPageNumber($this->_request->getParam('page', 1));
    			$this->view->paginator = $zendPaginator;
    				
    	}catch(\Exception $e){
    			$this->_helper->FlashMessenger( array('error' => $e->getMessage()));
    	}	
    }
    /**
     * Edit Creator's Project Picture
     */
    public function editProjectPictureAction()
    {
    	$this->checkProjectAndUser();	
    	$this->view->project = $this->project;
    }
    
    /**
     * Display Creators project for sign user
     */
    public function detailAction()
    {
    	$this->view->pageTitle = "My Projects Detail" ;
    	// get categories for form
    	$facadeProject = new \App\Facade\ProjectFacade($this->_em);
    	$projects = $facadeProject->findAllProjectsForUser($this->_member_id);
    	$this->view->projects = $projects;
    }
    

    /**
     * Display Creators project for sign user
     */
    public function indexAction()
    {
    	$this->view->pageTitle = "My Projects" ;
    	// get categories for form
    	$facadeProject = new \App\Facade\ProjectFacade($this->_em);
    	$projects = $facadeProject->findAllProjectsForUser($this->_member_id);
    	$this->view->projects = $projects;

    }
    
    
}





