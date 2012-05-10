<?php
namespace App\Form;

class ExampleForm extends \Twitter_Bootstrap_Form_Horizontal
{
	public function init()
	{
		// $this->setIsArray(true);
		// $this->setElementsBelongTo('bootstrap'); // will make form array

		$this->addElement('text', 'title', array(
				'label' => 'Project Name',
				'required' => true,
				'filters' => array('StringTrim'),
				//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
				//'description' => "description",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(6,20)) )
		));

		$this->addElement('hidden',"id",array( 'disableLoadDefaultDecorators' => true));

		$this->addElement('text', 'pitch', array(
				'label' => 'Sentence Pitch',
				'required' => true,
				'errorMessages' => array("You should have sentence pitch which will simply describe your goal."),
				'description' => "description",
				'validators' => array("NotEmpty"),
		));

		// TinyMCE configuration in the phtml file
		$this->addElement('textarea', 'content', array(
				'label' => 'Description',
				'required' => true,
				'errorMessages' => array("You should have descripton of your project."),
				'description' => "description",
				'validators' => array("NotEmpty"),
				'disableLoadDefaultDecorators' => true,


		));

		$this->addDisplayGroup(
				array('title','pitch','content','email','password'), 'Create Project', array('legend' => 'Playground')
		);
		 
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Create Project",
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



