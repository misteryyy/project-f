<?php
class Member_MyProjectTeamController extends  Boilerplate_Controller_Action_Abstract
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
	public function indexAction()
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
    	$form = new \App\Form\Member\TeamDisableRoleWidget();

    	// switch project widget
    	if ($this->_request->isPost()) { 		
    		if ($form->isValid($this->_request->getPost())) {
    			pr($this->_request->getPost()); 			
    			$this->_helper->FlashMessenger( array('success' => "Your answers has been updated"));	 
    		}
    	}
    	
    	//display form
    	$this->view->formDisableRoleWidget = $form;
    	$this->view->project = $this->project;
    }
    
    /**
     * Request for project
     */
    public function requestAction()
    {
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "My Projects Request" ;
    	$form = new \App\Form\Member\TeamDisableRoleWidget($this->project);
    	
    	
    	// update project survey
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			pr($this->_request->getPost());
   				$this->facadeProject->disableProjectWidget($this->_member_id, $this->project_id, $this->_request->getPost());		
    			$this->_helper->FlashMessenger( array('success' => "Saved successfuly."));
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    		}
    	}
    	
    	
    	//display form
    	$this->view->formDisableRoleWidget = $form;
    	$this->view->project = $this->project;
    	
    	
//     	// receiving paginator
//     	$facadeProjectUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
// 	    	$paginator = $facadeProjectUpdate->findProjectUpdates($this->_member_id, $this->project_id);
// 	    	$paginator->setItemCountPerPage(3);
// 	    	$page = $this->_request->getParam('page', 1);
// 	    	$paginator->setCurrentPageNumber($page);
// 	    	$this->view->paginator = $paginator;
// 	    	$this->view->project = $this->project;
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

    
}





