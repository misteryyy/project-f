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
          
      // pr($user->getInfo());
       
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
    
    
    public function memberPictureAction()
    {
    	$member = Zend_Auth::getInstance()->getIdentity();
    	$this->view->pageTitle = $member->name . '\'s Dashboard \ Profile Picture' ;
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
    

    }
    
    
    
    
}





