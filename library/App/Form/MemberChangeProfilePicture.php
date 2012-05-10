<?php

namespace App\Form;

class MemberChangeProfilePicture extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {

      	$this->addElement('file', 'file_1', array(
    			'label' => 'Choose Picture',	
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
      			)
    			));
  
         	$this->addDisplayGroup(
        			array('file_1'), 'Change Picture',	array('legend' => 'Change Picture')
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


