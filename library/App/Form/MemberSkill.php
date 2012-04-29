<?php

namespace App\Form;

use App\Entity\UserRole;

class MemberSkill extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
    	
    $arrayRoles = array(array("name" => UserRole::MEMBER_ROLE_STARTER, ),
    					array("name" => UserRole::MEMBER_ROLE_LEADER),
    					array("name" => UserRole::MEMBER_ROLE_BUILDER),
    					array("name" => UserRole::MEMBER_ROLE_GROWER),
    					array("name" => UserRole::MEMBER_ROLE_ADVISER)
    		);	
    
    $addList = array(); // saving name for element group

    
    foreach($arrayRoles as $role){
    
    	$addList[] = "role_".$role['name'];
    	$addList[] = "role_".$role['name'].'_tags';
    	 
    	$this->addElement('checkbox','role_'.$role['name'],
    			array(
    					'label' => $role['name'],
    			)
    	);
    	
    	$this->addElement('text', 'role_'.$role['name'].'_tags', array(
    			'label' => 'Be more specific',
    			'required' => false,
    			'filters'    => array (array('StringTrim'), array("StringToLower")),
    			//	'errorMessages' => array("The date should be int format"),
    			'description' => "outsourcing, start ups, programming, ... ",
    			'validators' => array( array('StringLength', false, array(0,250) ),
    					array('regex',false, array('/^([\+\-\#\.a-z0-9A-Z ]*[,]?)+$/') ) //
    			)
    	));	 	
    }
    		
        	/**
        	 * ORDERING IN FIELDSET
        	 */
         	$this->addDisplayGroup(
        			$addList, 
         			'memberskills',
         			array('legend' => 'Member skills')
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

