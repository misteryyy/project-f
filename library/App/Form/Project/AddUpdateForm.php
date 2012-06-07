<?php

namespace App\Form\Project;

class AddUpdateForm extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
  
    $this->addElement('text', 'title', array(
    			'label' => 'Title',
    			'required' => true,
    			'filters'    => array('StringTrim'),
    			'description' => "Title. Max 50 letters.",
    			'validators' => array( array('StringLength', false, array(0,100) ))));

 	$this->addElement('textarea', 'content', array(
    			'label' => 'Text',
    			'required' => true,
    			'filters'    => array('StringTrim'),
    			'rows' => 5, 'cols' => 60,
    			'dimension' => 6,
    			'description' => "Describe your update in max 1000 letters.",
    			'validators' => array( array('StringLength', false, array(0,1000) ))
    	));

 	
 			/**
        	 * ORDERING IN FIELDSET
        	 */
         	$this->addDisplayGroup(
        			array('title',
        					'content',
        					), 
         			'update-create',	array('legend' => 'Create Update')
        	);
         	
         	
         	// submit button
         	$this->addElement('submit','submit',array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => "Create",
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

