<?php

namespace App\Form;

class MemberChangeProfilePicture extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {

      	$this->addElement('file', 'file_picture', array(
    			'label' => 'Choose Picture',
      			'destination' => APPLICATION_PATH . '/../public/storage/users/',
    		//	'required' => false,
    		//	'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
    			'description' => "Max size 4MB (jpg,jpeg,png)",
    			'decorators' => array(   
    							array('File'),
    							array('ElementErrors'),
    							array('Description', array('tag' => 'p', 'class' => 'help-block')),
    							array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
    							array('Label', array('class' => 'control-label')),
    							array('Wrapper')
    					),
      			'filters' => array(
      					array('LowerCase'),
      					array('ElementErrors'),
      					array('Description', array('tag' => 'p', 'class' => 'help-block')),
      					array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
      					array('Label', array('class' => 'control-label')),
      					array('Wrapper')
      			),
      					
    			'validators' => array( 
    					array('Count', false, array("min" => 1, "max" => 2) ),
    					array('Size', false, 4*10*102400), // 4MB maximum
    					array('Extension', false, 'jpg,jpeg,gif')
    					)
    			));
  
         	$this->addDisplayGroup(
        			array('file_picture'), 'Change Picture',	array('legend' => 'Change Picture')
        	);
       
         	// submit button
         	$this->addElement('submit','submit',array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => "Change Picture",
         			'escape'        => false,
         	));
         	 
         	// Action Section
        	$this->addDisplayGroup(
        			array('submit'),
        			'actions',
        			array(
        					'disableLoadDefaultDecorators' => true,
        					'decorators' => array('Actions')
        			)
        	);
        	   
        	   
    }
}


