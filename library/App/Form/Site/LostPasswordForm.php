<?php

namespace App\Form\Site;

class LostPasswordForm extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
    	

  
    	//Member email
    	$this->addElement('text', 'email', array(
    			'label' => 'Email',
    			'required' => true,
    		//	'prepend'       => '@',
    			'class'         => 'focused',
    			'description' => "Entre email where the recovery password will be send.",
    			'validators' => array("EmailAddress")
    	));
    	
    	
    	
        	/**
        	 * ORDERING IN FIELDSET
        	 */
         	$this->addDisplayGroup(
        			array("email","password"), 
         			'login',
         			array('legend' => 'Login')
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

