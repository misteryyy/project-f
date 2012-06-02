<?php
namespace App\Form\Launch;

class SignupForm extends \Twitter_Bootstrap_Form_Horizontal
{
	

	public function init()
	{
		// $this->setIsArray(true);
		// $this->setElementsBelongTo('bootstrap'); // will make form array
		$this->_addClassNames('well');
		
		$this->addElement('text', 'name', array(
				'label' => 'First Name',
				'required' => true,
				'filters' => array('StringTrim'),
				//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
				'description' => "name of your project",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,100)) )
		));
	
		$this->addElement('text', 'surname', array(
				'label' => 'Last Name',
				'required' => true,
				'filters' => array('StringTrim'),
				//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
				'description' => "name of your project",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,100)) )
		));

		
		$this->addElement('text', 'email', array(
				'label' => 'Email',
				'class' => 'span6',
				'required' => true,
				'errorMessages' => array("You should have emailll which will simply describe your goal."),
				'description' => "description",
				'validators' => array("emailAddress"),
		));

		$this->addElement('text', 'email_verification', array(
				'label' => 'Email verification',
				'class' => 'span6',
				'required' => true,
				'errorMessages' => array("Email is not the same as previous one."),
				'description' => "description",
				'validators' => array(array("emailAddress"),
									  array('Identical', true, array('token' => 'email') )
							)
		));
		
		
		// Passion Bar
		$this->addElement('select','location', array(
				'label' => 'Do you reside in Prague?',
				'description' => "description",
				'multiOptions' => array("yes",'no')
		));
			
		
		// Widget Setting
		$this->addElement('checkbox','accept',
				array(  'missingMessage' => "Field '%field%' is required by rule '%rule%', dawg!",
						'required' => true,
						'label' => "Accept terms",
						'description' => 'Please read what will happen if you will disable role widget.',
						'validators' => array(array('GreaterThan', false, array(0)))
				)
		);


		$this->addDisplayGroup(
				array('name','surname','email','email_verification','location','accept'), 'Sign Up', array('legend' => 'Sign up')
		);

		
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Sign up",
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



