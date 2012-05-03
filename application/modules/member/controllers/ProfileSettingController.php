<?php

class Member_ProfileSettingController extends  Boilerplate_Controller_Action_Abstract
{

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $_em = null;
	
	/**
	 * @var \sfServiceContainer
	 */
	protected $_sc = null;
	
	/**
	 * @var \App\Service\RandomQuote
	 * @InjectService RandomQuote
	 */
	protected $_randomQuote = null;
	
	
	
	public function init()
	{
		parent::init();
		$this->_em = Zend_Registry::get('em');
	}
	

    public function indexAction()
    {
    	//$member = Zend_Auth::getInstance()->getIdentity();
    	//$this->view->pageTitle = $member->name . '\'s Dashboard \  ' ;
    }
    
    /**
     * 
     */
    public function memberInfoAction()
    {
    	$id = 1;
    	$error = false;
    	//$member = Zend_Auth::getInstance()->getIdentity();
    	//$this->view->pageTitle = $member->name . '\'s Dashboard \ Member settings' ;
      	 $form = new \App\Form\MemberPersonalInfoForm();
    
       if ($this->_request->isPost()) {
       	if ($form->isValid($this->_request->getPost())) {
       		$facadeUser = new \App\Facade\UserFacade($this->_em);	
       		// fetch values
       		$values = $form->getValues();
       		// storing data
       		try{
       			$facadeUser->updateInfo($id,$values);
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
        $user = $facadeUser->findUserSettings($id);
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
    		
    		if ($form->isValid($this->_request->getPost())) {	
    			
    			//$form->file_picture->setFile("New nazev.jpg");
    			
    			// uploading the picture to the dir
     			if (!$form->file_picture->receive()) {
     				$this->_helper->FlashMessenger( array('error' => "Can't upload image to the server."));   
     				
     				$message .=  'filename: '. $form->file_picture->getFileName();
     				$this->_helper->FlashMessenger( array('success' => $message));
     			
     			
     			}

     			
    		 	$this->_helper->FlashMessenger( array('success' => "Image is uploaded "));
	
    
    		} else {		
    			$this->_helper->FlashMessenger( array('error' => "Something is wrong. Please check if you really have right picture."));   
    		
    		}
    	
    	}
    	
    	
    	
    }
 
    
    public function memberPasswordAction()
    {
    	$member = Zend_Auth::getInstance()->getIdentity();
    	$this->view->pageTitle = $member->name . '\'s Dashboard \ Change password' ;
    }
    
    
    
    /**
     * Administration of Member Skills
     */
    public function memberSkillsAction()
    {
    	
    	$this->view->pageTitle = $this->_member['name'] . '\'s Dashboard \ Member skills' ;
    	$form = new \App\Form\MemberSkill();
     	$this->view->form = $form;
 	
     	$id = 1;
     	$error = false;

     	if ($this->_request->isPost()) {
     		if ($form->isValid($this->_request->getPost())) {
     			$facadeUser = new \App\Facade\UserFacade($this->_em);
     			// fetch values
     			$values = $form->getValues();
     			// storing data
     			try{
     				$facadeUser->updateSkills($id,$values);
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
     		$user = $facadeUser->findUserSettings($id);
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





