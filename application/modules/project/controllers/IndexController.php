<?php
class Project_IndexController extends  Boilerplate_Controller_Action_Abstract
{
	private $project_id = null;
	public function init(){
		parent::init();
		$id = $this->_request->getParam("id");
		if(!is_numeric($id)){
			$this->_helper->FlashMessenger(array('error', 'This project is not found, are you trying to hack us? :D '));
			$this->_redirect('/project/error/');
		}
		// getting project
		try{
			$project = $this->_em->getRepository ('\App\Entity\Project')->findOneById($id );
			$this->view->pageTitle = $project->getTitle() ;
			$this->view->project = $project;		
			$this->project_id = $id; 
			
		}catch (\Exception $e){
			$this->_helper->FlashMessenger( array('error' =>  "This project doesn't exists."));
		}	
	}
	
	/**
	 * Main Project Page Section
	 */ 
    public function indexAction(){
    	$this->view->pageTitle .=  "~ Main ";  
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

