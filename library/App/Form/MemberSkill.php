<?php

namespace App\Form;

class MemberSkill extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
        $this->setIsArray(true);
       // $this->setElementsBelongTo('bootstrap'); // will make form array
         
    $this->addElement('checkbox','role1',
						array(
						'label' => '',						
						'checkedValue' => '1',
						)
						);
    
    	$this->addElement('text', 'userTag', array(
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
        			array('dateOfBirthVisibility',
        					'emailVisibility',
        					'userTag'
        					), 
         			'Member skills',	array()
         			//array('legend' => 'Member skills')
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

