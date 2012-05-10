<?php
namespace App\Form;

class MemberCreateProjectStep2 extends \Twitter_Bootstrap_Form_Horizontal
{
	public function init()
	{
		// $this->setIsArray(true);
		// $this->setElementsBelongTo('bootstrap'); // will make form array
		$this->_addClassNames('well');
			
		$this->addElement('file', 'file_1', array(
				'label' => 'Choose Picture',
				'id' => 'project_picture',
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
				array('file_1'), 'Create Project Choose Profile Photo', array('legend' => 'Step 2 / Choose Picture')
		);
		 
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Continue to roles",
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



