<?php
/**
 * Widget for public project page
 * @author misteryyy
 *
 */
class Site_WidgetController extends  Boilerplate_Controller_Action_Abstract
{

	private $facadeProject;
	
	public function init(){
		parent::init();
		$this->facadeProject = new \App\Facade\Site\ProjectFacade($this->_em);
		//$this->checkProject();
	}
	
	
	
    /**
	 * Categories
	 */ 
    public function categoryAction(){
    	$this->view->categories = $this->facadeProject->findAllProjectCategories();
    }

    /**
     * Slideshow widget
     */
    public function topProjectAction(){
    	
    	// Feeding Slideshow
    	$facadeSlideshow = new \App\Facade\Admin\SlideshowFacade($this->_em);
    	$this->view->slideshow = $facadeSlideshow->findSlideshow();
    	
    }
    
    /**
     * Ajax Handling for Applications
     */
    public function ajaxCategoryAction(){
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

