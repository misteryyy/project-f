<?php
/**
 * Actions which are only under project
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
    	
    	
    	
    }
    
}

