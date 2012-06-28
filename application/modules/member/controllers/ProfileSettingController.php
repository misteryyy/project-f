<?php

class Member_ProfileSettingController extends  Boilerplate_Controller_Action_Abstract
{

	private $facadeUser;
	
	/**
	 * Initialization
	 * @see Boilerplate_Controller_Action_Abstract::init()
	 */
	public function init(){
		parent::init();
		// user facade
		$this->facadeUser =  new \App\Facade\UserFacade($this->_em);
	}
	
	
    public function indexAction()
    {
  			$this->_helper->redirector('member-info', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName());	
    }
    
    /**
     *  Member info Settings
     */
    public function memberInfoAction()
    {
  
     $error = false;
      $this->view->pageTitle = "Info Setting" ;
      $form = new \App\Form\MemberPersonalInfoForm();
    
       if ($this->_request->isPost()) {
       	if ($form->isValid($this->_request->getPost())) {
       		$facadeUser = new \App\Facade\UserFacade($this->_em);	
       		// fetch values
       		$values = $form->getValues();
       		// storing data
       		try{
       			$facadeUser->updateInfo($this->_member_id,$values);
       			$this->_helper->FlashMessenger( array('success' => "Updated successfully :D"));
       		}
       		catch (Exception $e){
       			   $this->_helper->FlashMessenger( array('error' => $e->getMessage()));  		
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
       $facadeUser = new \App\Facade\UserFacade($this->_em); 
       // fetch values
       $values = $form->getValues();	      
       // retriving data for form
        $user = $facadeUser->findUserSettings($this->_member_id);
        // if its not initialize
        ($user->getDateOfBirth() != null) ?  $dateOfBirth = $user->getDateOfBirth()->format('Y/m/d') : $dateOfBirth = '';
        
       $data = array(
       		'name' => $user->getName(),
       		'email' => $user->getEmail(),
       		'emailVisibility' => $user->getEmailVisibility(),
       		'im' => $user->getUserInfo()->getIm(),
       		'country' => $user->getCountry(),
       		'dateOfBirth'=> $dateOfBirth, 
       		'dateOfBirthVisibility'=> $user->getDateOfBirthVisibility(),
       		'skype' => $user->getUserInfo()->getSkype(),
       		'website' => $user->getUserInfo()->getWebsite(),
       		'phone' => $user->getUserInfo()->getPhone(),
       		'fieldOfInterestTag' => $user->getUserFieldOfInterestTagsString()
     	);
       
      	$form->setDefaults($data);
       }
      $this->view->form = $form;
         
    }
    
    /**
     * Change profile picture
     */
    public function memberPictureAction()
    {
    	$this->view->pageTitle = $this->_member['name'] . '\'s Dashboard \ Profile Picture' ;
    	$form = new \App\Form\MemberChangeProfilePicture(); 	
    	//then process your file, it's path is found by calling $upload->getFilename()
    	$this->view->form = $form;
    	// Checking the file
    	
    	if($this->_request->isPost()){	
    		
    			$adapter = new Zend_File_Transfer_Adapter_Http();
    			$config = new Zend_Config(Zend_Registry::get('config'));
    			$uploadDir = $config->app->storage->profile;
    			
    			
    			// setting upload file
    			$adapter->setDestination($uploadDir);
    			$adapter->addValidator('Size', false, 4*10*102400)
    			->addValidator('Count', false, 1)
    			->addValidator('Extension', false, 'jpg,jpeg,png')
    			->addValidator('IsImage', false);

    			$i= 1;
    			foreach ($adapter->getFileInfo() as $file => $info) {
    				
    				// check if uploaded
    				if (!$adapter->isUploaded($file)) {
    					$errorMessage = "You haven't choose the file. Try it again :D.";
    					$this->_helper->FlashMessenger($errorMessage);
    					break;
    				}
		
    				// validators are ok ?
    				if (!$adapter->isValid($file)) {
    					$errorMessage = "Please check the file: ".$info["name"] . ". \n<br />";
    					$errorMessage .= implode("\n<br\>", $adapter->getMessages());
    					$this->_helper->FlashMessenger( array('error' =>  $errorMessage));
    					break;
    				}
    			
    			// rename the file	
    			$ext = substr(strrchr($info['name'],'.'), 1);
    			$fileName = 'profile'.sha1("s@4d".$this->_member_id);
    			
    			// resolution path
    			$path = $uploadDir.$fileName.'.'.$ext;	 
    			$web_path = $this->_users_web_folder_path.$fileName.'.'.$ext;
    			
    			
    			$adapter->addFilter('Rename', 
     								array('target' => $path,	
    										'overwrite' => true));				
    			
    			// receiving files
    			if(!$adapter->receive($file)){
     					debug($adapter->getMessages());	
    					$this->_helper->FlashMessenger( array('error' => "Can't upload image to the server."));   
    					break;
    				}	
    				
     			$i++;	
     		
    			// Add Profile Picture and process picture
    			$facadeUser = new \App\Facade\UserFacade($this->_em);
    			$facadeUser->updateProfilePicture($this->_member_id,$path); // default 3 resolution

    			$this->_helper->FlashMessenger( array('success' => "Profile picture has been changed."));
    			$this->_redirect('/member/profile-setting/member-picture');
    			
    			
    	} // end foreach through all files
	    
    	}// end if post
    
    }
   
    
    /**
     * Change Password Settings
     */
    public function changePasswordAction()
    {
    	$this->view->pageTitle = "Change password" ;
    	
    	
    }
    
    /**
     * Notification Settings
     */
    public function notificationAction()
    {
    	$this->view->pageTitle = "Member / Notification" ;     	 
    	// initialization of form
    	$form =  new \App\Form\Member\EditNofificationAndNewsletterForm($this->facadeUser->findOneUser($this->_member_id));

    	// newsletter and notifivation
    	if ($this->_request->isPost()) {
    		if ($form->isValid($this->_request->getPost())) {
    			$this->_helper->FlashMessenger( array('success' => "Settings save successfully."));
    			// update survey
    			$this->_helper->redirector('notification', $this->getRequest()->getControllerName(), $this->getRequest()->getModuleName());
    		}
    		// not validated properly
    		else {
    			$this->_helper->FlashMessenger( array('error' => "Please check your input."));
    		}
    	}
    	
    	//display form
    	$this->view->form = $form;	 
    }
    
    /**
     * Administration of Member Skills
     */
    public function memberSkillsAction()
    {
    	$this->view->pageTitle = "Member skills" ;
    	$form = new \App\Form\MemberSkill();
     	$this->view->form = $form;
     	$error = false;
     	if ($this->_request->isPost()) {
     		if ($form->isValid($this->_request->getPost())) {
     			$facadeUser = new \App\Facade\UserFacade($this->_em);
     			// fetch values
     			$values = $form->getValues();
     			// storing data
     			try{
     				$facadeUser->updateSkills($this->_member_id,$values);
     				$this->_helper->FlashMessenger( array('success' => "Updated successfully :D"));
     			}
     			catch (Exception $e){
     				$this->_helper->FlashMessenger( array('error' => $e->getMessage()));
     			} 
     		}
     		// not validated properly
     		else {
     			$this->view->messages = array('error', 'Please control your input!'); // extra message on top
     			$error = true;
     		}
     		 
     	}
     	 
     	// leave the old values, if user already sended form
     	if(!$error){
     		$facadeUser = new \App\Facade\UserFacade($this->_em);
     		// fetch values
     		$values = $form->getValues();
     		// retriving data for form
     		$user = $facadeUser->findUserSettings($this->_member_id);
     		// filling up form with data	
     		$arrayRoles = array(array("name" => \App\Entity\UserRole::MEMBER_ROLE_STARTER, ),
     				array("name" => \App\Entity\UserRole::MEMBER_ROLE_LEADER),
     				array("name" => \App\Entity\UserRole::MEMBER_ROLE_BUILDER),
     				array("name" => \App\Entity\UserRole::MEMBER_ROLE_GROWER),
     				array("name" => \App\Entity\UserRole::MEMBER_ROLE_ADVISER)
     		);
     		 $data = array();
      		 foreach($arrayRoles as $role){
        			//if specific role is set, add it to the user
      		 		$specRole = $user->getSpecificRole($role['name']);
      		 	 
         			if($specRole){
         				// getting the value
         				$data ["role_".$role['name']] = "1" ;
      					$data ["role_".$role['name']."_tags"] = $specRole->getTagsString(); 
      			}
    		} 
     		$form->setDefaults($data);
     	}
    }
    
    
    
    
}





