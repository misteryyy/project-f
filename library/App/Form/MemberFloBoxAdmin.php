<?php

namespace App\Form;

class MemberFloBoxAdmin extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
  
    // type of FloMessage
    $options = array( 
    		\App\Entity\UserFloBoxMessage::MESSAGE_TYPE_CHOICE => \App\Entity\UserFloBoxMessage::MESSAGE_TYPE_CHOICE,
    		\App\Entity\UserFloBoxMessage::MESSAGE_TYPE_PROBLEM => \App\Entity\UserFloBoxMessage::MESSAGE_TYPE_PROBLEM,
    		\App\Entity\UserFloBoxMessage::MESSAGE_TYPE_INTEREST => \App\Entity\UserFloBoxMessage::MESSAGE_TYPE_INTEREST,
    		);
    
    
    // Country Select Box
    $this->addElement('select','type', array(
    		'label' => 'Type', 
    		'multiOptions' => $options
    	
    		));
    
    $this->addElement('text', 'typeDetail', array(
    		'label' => 'Specicify your idea',
    		'required' => true,
    		'filters'    => array('StringTrim'),
    		//'errorMessages' => array("Your name can't be empty"),
    		//'placeholder' => "Your name or nickname",
    		//'description' => "description",
    		'validators' => array(array('StringLength', false, array(1,100)) )
    ));
     
    
    $this->addElement('text', 'title', array(
    			'label' => 'Title',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Title. Max 50 letters.",
    			'validators' => array( array('StringLength', false, array(0,50) ))));
    			 

    	
 	$this->addElement('textarea', 'message', array(
    			'label' => 'Text',
    			'required' => false,
    			'filters'    => array('StringTrim'),
    			'rows' => 5, 'cols' => 60,
    			'dimension' => 6,
    			//	'errorMessages' => array("The date should be in format"),
    			'description' => "Describe your idea in max 250 letters.",
    			'validators' => array( array('StringLength', false, array(0,250) ))
    	));

 	

 	 
 			/**
        	 * ORDERING IN FIELDSET
        	 */
         	$this->addDisplayGroup(
        			array('type',
        				  'typeDetail',
        					'title',
        					'message',
        					'submit'
        					), 
         			'FLO~Box Idea',	array('legend' => 'FLO~Box Idea Admin')
        	);
       
    
         	 
         	// submit button
         	$this->addElement('submit','submit',array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => "Submit",
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

