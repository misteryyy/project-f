<?php

namespace App\Form\Member;

class EditNofificationAndNewsletterForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	protected $user; // user entity
	public function __construct($user)
	{
		$this->user = $user;	
		parent::__construct();
	}
	
   public function init()
    {
    	
    // Description for Newsletters
    $this->addElement('hidden', 'newsletter_info', array(
    			'description' => '<div class="alert alert-info"> <span class="label label-info">Info</span> BLABLABL INFO</div>',
    			'ignore' => true,
    			'decorators' => array(
    					array('Description', array('escape'=>false, 'tag'=>'')),
    			),
    	));
    	
    if($this->user->emailNewsletter){
    		$optionsN = array('yes','no');
    }else {
    		$optionsN = array('no','yes');
    }
    
      // Country Select Box
    $this->addElement('select','newsletter', array(
    		'label' => 'Do you want newsletters?', 
    		'multiOptions' => $optionsN
    	
    		));
  
    // Description for Newsletters
    $this->addElement('hidden', 'notification_info', array(
    		'description' => '<div class="alert alert-info"> <span class="label label-info">Info</span> BLABLABL INFO</div>',
    		'ignore' => true,
    		'decorators' => array(
    				array('Description', array('escape'=>false, 'tag'=>'')),
    		),
    ));
    
    if($this->user->emailNotification){
    	$options = array('yes','no');
    }else {
    	$options = array('no','yes');
    }
    
    // Country Select Box
    $this->addElement('select','notification', array(
    		'label' => 'Do you want notification?',
    		'multiOptions' => $options
    		 
    ));
    
     	
		 	
 			/**
        	 * ORDERING IN FIELDSET
        	 */
         	$this->addDisplayGroup(
        			array('newsletter_info','newsletter',
        				  'notification_info','notification',
        				
        					), 
         			'Member Newsletter & Notification Settings',	array('legend' => 'Newsletter & Notification Settings')
        	);
       
         	// submit button
         	$this->addElement('submit','submit',array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => "Save",
         			'escape' => false,
         	));
         	 
         	$this->addElement('button', 'reset', array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => 'Reset',
         			'type' => 'reset'
         	));
         		
         	// Action Section
         	$this->addDisplayGroup(
         			array('submit', 'reset'),
         			'actions',
         			array(
         					'disableLoadDefaultDecorators' => true,
         					'decorators' => array('Actions')
         			)
         	);
    
        	     	   
    }
}

