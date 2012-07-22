<?php
class Project_IndexController extends  Boilerplate_Controller_Action_Abstract
{
	private $project_id = null;
	private $project = null;
	private $isCreator = false;
	private $isCollaborator = false;
	
	private $facadeProject;
	private $facadeACL;
	
	/*
	 * Check all neccessary things
	*/
	public function checkProject(){
		$id = $this->_request->getParam("id");
		// check id param for project
		if(!is_numeric($id)){
			echo $id . "is not numeric";
			$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
			$this->_redirect('/project/error/');
		}
		
		try{
			// init basic things
			$this->project = $this->facadeProject->findOneProject($id);
			$this->project_id = $id;
			
			// acl setting
			
			// is creator
			$this->isCreator = $this->facadeACL->isCreator($this->_member_id, $this->project_id);
			$this->view->isCreator = $this->isCreator; 
			
			// is collaborator
			$this->isCollaborator = $this->facadeACL->isCollaborator($this->_member_id, $this->project_id);
			$this->view->isCollaborator = $this->isCollaborator;
				
			
			$this->view->pageTitle = $this->project->title;
			$this->view->project = $this->project;
	
		} catch (\Exception $e){
			$this->_helper->FlashMessenger(array('error' => 'This project is not found, are you trying to hack us? :D '));
			$this->_helper->FlashMessenger(array('error' => $e->getMessage()));
			$this->_redirect('/member/error/');
		}
	}
	
	
	public function init(){
		parent::init();
		$this->facadeProject = new \App\Facade\ProjectFacade($this->_em);
		$this->facadeACL = new \App\Facade\ACLFacade($this->_em);
		
		$this->checkProject();
		
	}
	
	/**
	 * Main Project Page Section
	 */ 
    public function indexAction(){
    	$this->view->pageTitle .=  "~ Main ";  
    }
 
    /**
     * Update Section in Project Page
     */
    public function updateAction(){
    	
    	$facadeUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
    	$paginator = $facadeUpdate->findUpdatesForProjectPaginator($this->project_id);
    	$paginator->setItemCountPerPage(10);
    	$paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
    	$this->view->paginator = $paginator;
    	
    }
    
    /**
     * Survey Section in Project Page
     */
    public function surveyAction(){
    	 
    	$facadeSurvey = new \App\Facade\Project\SurveyFacade($this->_em);
    	$paginator = $facadeSurvey->findProjectSurveyAnswersPaginator($this->project_id);
    	$paginator->setItemCountPerPage(50);
    	$paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
    	$this->view->paginator = $paginator;
    	 
    }
    
    /**
     * Team Section in Project Page
     */
    public function teamAction(){
    
    	$this->view->pageTitle .=  "~ Team ";
    		$facadeSurvey = new \App\Facade\Project\SurveyFacade($this->_em);
    		$paginator = $facadeSurvey->findProjectSurveyAnswersPaginator($this->project_id);
    		$paginator->setItemCountPerPage(50);
    		$paginator->setCurrentPageNumber($this->_request->getParam('page', 1));
    	$this->view->paginator = $paginator;
    
    }
    
    /**
     * Project Section
     */
    public function projectBoardAction(){
    	 // TODO check if in the team 
    	$this->view->pageTitle .=  "Project Board";
 
    	$facadeProjectBoard = new \App\Facade\Project\ProjectBoardFacade($this->_em);
    	 
    	$form = new \App\Form\Project\ProjectBoardForm($this->_member, $this->project_id);

    	// validation
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {				
     			try{
     					$fileManager = new Boilerplate_Util_FileManager($this->project,"storage/projects/".$this->project->dir, "filename.jpg");
     					// uploading all files to the server
     					$files = $fileManager->uploadFileFromPost();	
     					$facadeProjectBoard->addComment($this->_member_id, $this->project_id,$form->getValues(),$files);
     				$this->_helper->FlashMessenger( array('success' =>  "Comment has been added."));
     			
     			} catch (\Exception $e){
     				$this->_helper->FlashMessenger( array('error' =>  $e->getMessage()));
     			}
    		}
    		else {
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    		}
    	}
    
    	$this->view->form = $form;
    	
    	// Displaying of comments
    	try{
    		// receiving comments for this project
    		$zendPaginator = $facadeProjectBoard->findCommentsForProject($this->project_id);
    		$zendPaginator->setItemCountPerPage(10);
    		$zendPaginator->setCurrentPageNumber($this->_request->getParam('page', 1));
    		$this->view->paginator = $zendPaginator;
    	}catch(\Exception $e){
    		$this->_helper->FlashMessenger( array('error' => "Error with receiving comments."));
    	}
    }
    
    
    /**
     * Comments Section
     */
    public function commentAction(){
    	
    	$this->view->pageTitle .=  "~ Comments ";
    	$form = new \App\Form\Project\AddCommentForm($this->_member,$this->project_id);
    	$facadeProject = new \App\Facade\Project\CommentFacade($this->_em);
    	// validation
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			try{
    				$values = $form->getValues();
    				$facadeProject->addComment($this->_member_id,$this->project_id,$values);
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

    	$this->view->form = $form;
		
    	try{	
	    	// receiving comments for this project
	    	$zendPaginator = $facadeProject->findCommentsForProject($this->project_id);
	    	//$zendPaginator = $facadeProject->findUnasweredCommentsForProject($this->project_id);
	    	
	    	$zendPaginator->setItemCountPerPage(3);
	    	$zendPaginator->setCurrentPageNumber($this->_request->getParam('page', 1));
	    	$this->view->paginator = $zendPaginator;
    	}catch(\Exception $e){
    		$this->_helper->FlashMessenger( array('error' => "Error with receiving comments."));
    	}
    }
}

