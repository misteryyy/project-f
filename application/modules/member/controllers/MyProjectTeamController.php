<?php
class Member_MyProjectTeamController extends  Boilerplate_Controller_Action_Abstract
{
	private $project_id; // int id
	private $project;  // project object
	private $facadeComment;
	private $facadeProject;
	private $facadeProjectUpdate;
	private $facadeProjectTeam;
	
	public function init(){	
		parent::init();
		// check project existance for user and project
		$this->facadeProject = new \App\Facade\ProjectFacade($this->_em);	
		$this->facadeComment = new \App\Facade\Project\CommentFacade($this->_em);
		$this->facadeProjectUpdate = new \App\Facade\Project\UpdateFacade($this->_em);
		$this->facadeProjectTeam = new \App\Facade\Project\TeamFacade($this->_em);
		
	}

	/**
	 * Modul for Team
	 */
	public function indexAction()
	{
		$this->checkProjectAndUser();
		$this->view->pageTitle = "Team" ;	
		
		$this->view->creatorRoles = $this->facadeProjectTeam->findCreatorRolesForProject($this->project_id);
		$this->view->project = $this->project;

	}

	
	/**
	 * Request for project
	 */
	public function ajaxIndexAction()
	{
		$this->ajaxify();
		$this->checkProjectAndUser();
	
		$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);
		$applications = $facadeTeam->findApplications($this->_member_id, $this->project_id);
	
		if($this->_request->isPost() || $this->_request->isGet()){
			switch ($this->_request->getParam("_method")){
		
					//  create new question
				case 'findAllProjectRoles':
					try{
						$applications = $facadeTeam->findApplications($this->_member_id,$this->project_id,array('state' =>\App\Entity\ProjectApplication::APPLICATION_ACCEPTED));
						$roles = $facadeTeam->findProjectRolesForProject($this->project_id);
						$data = array(); // data for sending to the script
						foreach($roles as $a){
							$data[] = $a->toArray();
						}
							
						$respond = array("respond" => "success",
								"message" => "Data loaded successfully.",
								"data" => $data);
						$this->_response->setBody(json_encode($respond));
						break;
					}catch(Exception $e){
						$respond = array("respond" => "error","message" => $e->getMessage());
						$this->_response->setBody(json_encode($respond));
					}
					 
					break;
					
				case 'delete' :
						try{
							$facadeTeam->deleteProjectRole($this->_member_id, $this->project_id, $this->_request->getParam("role_id"));
							$respond = array("respond" => "success",'message' => "Position has been deleted.");
							$this->_response->setBody(json_encode($respond));	
						}catch(Exception $e){
							$respond = array("respond" => "error","message" => $e->getMessage());
							$this->_response->setBody(json_encode($respond));
						}
						break;
				//  create new role
				case 'update' :
						try{
							$facadeTeam->updateProjectRole($this->_member_id, $this->project_id,$this->_request->getParam("role_id"),$this->_request->getParams());
							$respond = array("respond" => "success",'message' => "Role was updated.");
							$this->_response->setBody(json_encode($respond));
						}catch(Exception $e){
							$respond = array("respond" => "error","message" => $e->getMessage());
							$this->_response->setBody(json_encode($respond));
						}
					
						break;
			
			}
		} else {
			$this->_response->setHttpResponseCode(503); // echo error
			 
		}
		 
	}
	
	/**
	 * Display Creators project for sign user
	 */
    public function questionAction()
    {
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "Questions for new Members" ;
    	$this->view->project = $this->project;
    }
    /**
     * Ajax Handling for Question
     */
    public function ajaxQuestionAction(){
    	$this->ajaxify();
    	$this->checkProjectAndUser();
    	$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);
    	 
    	if($this->_request->isPost() || $this->_request->isGet()){
    		switch ($this->_request->getParam("_method")){
    			case 'findAll' :
    				$questions = $facadeTeam->findAllProjectRoleWidgetQuestions($this->project_id);	
    				$data = array(); // data for sending to the script
    				foreach($questions as $q){
    					$data[] = $q->toArray();
    				}
    				$respond = array("respond" => "success",
    								 "message" => "Data loaded successfully.",
    								 "data" => $data);
    				$this->_response->setBody(json_encode($respond));
    				break;
    			
    			//  create new question
    			case 'create' :
    					try{
    						$facadeTeam->createProjectWidgetQuestion($this->_member_id,$this->project_id, $this->_request->getParams());
    						$respond = array("respond" => "success",'message' => "Question was added.");
    						$this->_response->setBody(json_encode($respond));
    					}catch(Exception $e){
    						$respond = array("respond" => "error","message" => $e->getMessage());
    						$this->_response->setBody(json_encode($respond));
    					}
    				
    					break;
                case 'update' :
                        try{
                            $facadeTeam->updateProjectWidgetQuestion($this->_member_id,$this->project_id,$this->_request->getParam('question_id'),$this->_request->getParams());
                            $respond = array("respond" => "success",'message' => "Question was updated.");
                            $this->_response->setBody(json_encode($respond));
                        }catch(Exception $e){
                            $respond = array("respond" => "error","message" => $e->getMessage());
                            $this->_response->setBody(json_encode($respond));
                        }
                    
                        break;
    				
    			case 'delete' :
    					try{
                            $facadeTeam->deleteProjectRoleWidgetQuestion($this->_member_id,$this->project_id,$this->_request->getParam('question_id'));
                            $respond = array("respond" => "success",'message' => "Question was deleleted.");
                            $this->_response->setBody(json_encode($respond));
                        }catch(Exception $e){
                            $respond = array("respond" => "error","message" => $e->getMessage());
                            $this->_response->setBody(json_encode($respond));
                        }
    					break;
    		} 	
    	} else {
    		$this->_response->setHttpResponseCode(503); // echo error
    		
    	}
  
    }
    
    /**
     * Request for project
     */
    public function requestAction()
    {
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "My Projects Request" ;
    	$this->view->project = $this->project;
    }
     
    
    /**
     * Request for project
     */
    public function ajaxRequestAction()
    {	$this->ajaxify();
    	$this->checkProjectAndUser();
    
    	$facadeTeam = new \App\Facade\Project\TeamFacade($this->_em);
    	$applications = $facadeTeam->findApplications($this->_member_id, $this->project_id);
    	 
    	if($this->_request->isPost() || $this->_request->isGet()){
    		switch ($this->_request->getParam("_method")){
    			case 'findSurvey' :   				
    				$application = $facadeTeam->findOneApplication($this->_member_id,$this->project_id,$this->_request("application_id"));
    				$data[] = $application;
    				$respond = array("respond" => "success",
    						"message" => "Data loaded successfully.",
    						"data" => $data);
    				$this->_response->setBody(json_encode($respond));
    				break;
    				 
    			//  create new question
    			case 'findAllNewApplications' :
    				try{
    					$applications = $facadeTeam->findApplications($this->_member_id,$this->project_id,array('level' => 1,'state' =>\App\Entity\ProjectApplication::APPLICATION_NEW));
    					$data = array(); // data for sending to the script
    					foreach($applications as $a){
    						$data[] = $a->toArray();
    					}
    					
    					$respond = array("respond" => "success",
    						"message" => "Data loaded successfully.",
    						"data" => $data);
    					$this->_response->setBody(json_encode($respond));
    					break;
    				}catch(Exception $e){
    					$respond = array("respond" => "error","message" => $e->getMessage());
    					$this->_response->setBody(json_encode($respond));
    				}
    	
    				break;
    				
    				//  create new question
    				case 'findAllFreeProjectRoles' :
    				
    					try{
       						$roles = $facadeTeam->findFreeProjectRolesForProject($this->project_id);
    						$data = array(); // data for sending to the script
    						foreach($roles as $a){
    							$data[] = $a->toArray();
    						}
    							
    						$respond = array("respond" => "success",
    								"message" => "Data loaded successfully.",
    								"data" => $data);
    						$this->_response->setBody(json_encode($respond));
    						break;
    					}catch(Exception $e){
    						$respond = array("respond" => "error","message" => $e->getMessage());
    						$this->_response->setBody(json_encode($respond));
    					}
    					
    					break;
    					
    					
    			// accept application
    			case 'accept' :
    				try{
						$facadeTeam->acceptApplication($this->_member_id, $this->project_id, $this->_request->getParam("application_id"));
    					$respond = array("respond" => "success",'message' => "Member was accepted to your team.");
    					$this->_response->setBody(json_encode($respond));
    					
    				}catch(Exception $e){
    					$respond = array("respond" => "error","message" => $e->getMessage());
    					$this->_response->setBody(json_encode($respond));
    				}
    	
    				break;
    	
    			// not ajax
    			case 'deny':		
    				try {
    						// SUCCESS
    						$facadeTeam->denyApplication($this->_member_id, $this->project_id, $this->_request->getParam("application_id"),$_POST);
    						$this->_helper->FlashMessenger ( array ('success' => "Member was denied." ) );
    						$params = array('id' => $this->project_id);
							$this->_helper->redirector('request', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName(), $params);
							//$respond = array("respond" => "success",'message' => "Question was deleleted.");
    						//$this->_response->setBody(json_encode($respond));
    				}catch(Exception $e){
    					$this->_helper->FlashMessenger ( array ('error' => $e->getMessage () ) );
    						//$respond = array("respond" => "error","message" => $e->getMessage());
    						//$this->_response->setBody(json_encode($respond));
    				}
    				break;
    			//  create new role
    			case 'create' :
    					try{
    						$facadeTeam->createProjectRole($this->_member_id, $this->project_id,$this->_request->getParams());
    						$respond = array("respond" => "success",'message' => "New position was created.");
    						$this->_response->setBody(json_encode($respond));
    					}catch(Exception $e){
    						$respond = array("respond" => "error","message" => $e->getMessage());
    						$this->_response->setBody(json_encode($respond));
    					}		
    					break;
    			// delete position with all applications		
    			case 'delete' :
    						try{
    							$facadeTeam->deleteProjectRole($this->_member_id, $this->project_id, $this->_request->getParam("role_id"));
    							$respond = array("respond" => "success",'message' => "Position has been deleted.");
    							$this->_response->setBody(json_encode($respond));
    						}catch(Exception $e){
    							$respond = array("respond" => "error","message" => $e->getMessage());
    							$this->_response->setBody(json_encode($respond));
    						}
    						break;
    					
    		
    	} 
    	} else {
    		$this->_response->setHttpResponseCode(503); // echo error
    	}
    	
    }
    
    
    /**
     * Setting for new collaborations
     */
    public function settingAction(){
    	$this->checkProjectAndUser();
    	$this->view->pageTitle = "Settings" ;
    	$form = new \App\Form\Project\TeamDisableRoleWidget($this->project);
    	
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





