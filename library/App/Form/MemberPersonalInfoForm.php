<?php

namespace App\Form;

class MemberPersonalInfoForm extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
      //  $this->setIsArray(true);
       // $this->setElementsBelongTo('bootstrap'); // will make form array
       
    	$this->addElement('text', 'name', array(
    			'label' => 'Name',
    			'required' => true,
    			'filters'    => array('StringTrim'),
    			//'errorMessages' => array("Your name can't be empty"),
    			//'placeholder' => "Your name or nickname",
    			//'description' => "description",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,20)) )			
    	));
    	
    	//TODO DatePicker
    	$this->addElement('text', 'dateOfBirth', array(
    			'label' => 'Date of birth',
    			'placeholder'   => 'YYYY/MM/DD',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    		//	'errorMessages' => array("The date should be in format"),
    			'description' => "example (1988/12/31) / YYYY/MM/DD",
    			'validators' => array( array('Date',false,array('format' => 'yyyy/MM/dd'))
    					),    			 
    	));
    	
    $this->addElement('checkbox','dateOfBirthVisibility',
						array(
						'label' => 'Hide my birthday data in profile',						
						'checkedValue' => '1',
						)
						);
    
    // Getting countries
    $locale = new \Zend_Locale('en_US');
    $countries = ($locale->getTranslationList('Territory', 'en', 2));
    asort($countries, SORT_LOCALE_STRING);  // sorting countries

    // Country Select Box
    $this->addElement('select','country', array(
    		'label' => 'Counry', 
    		'value' => 'US',
    		'multiOptions' => $countries
    	
    		));
    

    	$this->addElement('text', 'phone', array(
    			'label' => 'Phone',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Contact phone number in any format you want. Max 50 letters. ",
    			'validators' => array( array('StringLength', false, array(0,50) ))
    	));
    	
    	
    	$this->addElement('text', 'skype', array(
    			'label' => 'Skype',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Your skype name. Max 50 letters.",
    			'validators' => array( array('StringLength', false, array(0,50) ))
    			 
    	));
    	
    	$this->addElement('text', 'im', array(
    			'label' => 'IM',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Your IM messengers accounts. Max 50 letters.",
    			'validators' => array( array('StringLength', false, array(0,50) ))
    	
    	));
    	
    	$this->addElement('text', 'website', array(
    			'label' => 'Website(s)',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Your websites. Max 100 letters.",
    			'validators' => array( array('StringLength', false, array(0,100) ))	 
    	));
    	
    	$this->addElement('textarea', 'description', array(
    			'label' => 'Describe yourself',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			'rows' => 5, 'cols' => 60,
    			'dimension' => 6,
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Who are you? Describe yourself in max 1000 letters.",
    			'validators' => array( array('StringLength', false, array(0,1000) ))
    	));
    	 
    	$this->addElement('text', 'fieldOfInterestTag', array(
    			'label' => 'Field of interests',
    			'required' => false,
    			'filters'    => array (array('StringTrim'), array("StringToLower")),
    			//	'errorMessages' => array("The date should be int format"),
    			'description' => "outsourcing, start ups, programming, ... ",
    			'validators' => array( array('StringLength', false, array(0,250) ),
    						//	array('alnum',false, array("allowWhiteSpace" => true)), cant use with commas
    							array('regex',false, array('/^([\+\-\#\.a-z0-9A-Z ]*[,]?)+$/') ) // 
    					)
    	));
  	
    	//Member email
    	$this->addElement('text', 'email', array(
    			'label' => 'Email',
    			'required' => false,
    			'prepend'       => '@',
    			'class'         => 'focused',
    			'description' => "Your email which is used for login. Can't be changed.",
    			'validators' => array("EmailAddress"),
    			'attribs'    => array('disabled' => 'disabled')
    	));
    	
    	$this->addElement('checkbox','emailVisibility',
    			array(
    					'label' => 'Hide my email in profile',
    					'checkedValue' => '1',
    			)
    	);
    		
        	/**
        	 * ORDERING IN FIELDSET
        	 */
         	$this->addDisplayGroup(
        			array('name',
        				  'dateOfBirth',
        					'dateOfBirthVisibility',
        					'country',
        					'email',
        					'emailVisibility'
        					,'im',
        					'skype',
        					'website'
        					,'phone',
        					'description',
        					'fieldOfInterestTag'
        					), 
         			'Personal Info',	array('legend' => 'Personal Info')
        	);
       
         	// submit button
         	$this->addElement('submit','submit',array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => "Save",
         			'escape'        => false,
         	));
         	 
         	 
         	$this->addElement('button', 'reset', array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label'         => 'Reset',
         			'type'          => 'reset'
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

