<?php
namespace App\Form\Site;

class SignupForm extends \Twitter_Bootstrap_Form_Horizontal
{
	public function init()
	{	
	
		$this->addAttribs(array("id" => "form-sign-up"));
		$this->addElement('text', 'name', array(
				'label' => 'Name',
				'required' => true,
				'filters' => array('StringTrim'),
				//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
				//'description' => "name description",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,100)) )
		));
			
		$this->addElement('text', 'email', array(
				'label' => 'Email',
				'required' => true,
				'errorMessages' => array("You should have emailll which will simply describe your goal."),
				//'description' => "description",
				'validators' => array("emailAddress"),
		));

		$this->addElement('text', 'email_verification', array(
				'label' => 'Email verification',
				'required' => true,
				'errorMessage' => "Email is not the same as previous one.",
				//'description' => "description",
				'validators' => array(array("emailAddress"),
									  array('Identical', true, array('token' => 'email') )
				)
		));
		
		$this->addElement('password', 'password', array(
				'label' => 'Password',
				'required' => true,
				//'description' => "description",
				'validators' => array( array('StringLength',array(5,20)))
				));
		
		$this->addElement('password', 'password_verification', array(
				'label' => 'Password verification',
				'required' => true,
				'errorMessages' => array("Password is not the same as previous one."),
				//'description' => "description",
				'validators' => array(
						array('Identical', true, array('token' => 'password') ),
						array('StringLength',array(5,20)
						)
				)
		));
		
		
		
		// Passion Bar
		$this->addElement('radio','verification', array(
				'label' => 'Select second value.',
				'required' => true,
				'errorMessages' => array("You have choose second value. Which is second :)"),
				//'description' => "description",
				'multiOptions' => array("Three",'One',"Two"),
				'validators' => array(
						array('Between',true,array('min' => 1, 'max' => 1),
						)
				)
				
		));
		
		
// 		$radio->setLabel('Choose green color box:')
// 		->setMultiOptions(array('1' => PHP_EOL . 'Green', '2' => PHP_EOL . 'Blue','3' => PHP_EOL . 'Red','4' => PHP_EOL . 'Black'))
// 		->setRequired(true)
// 		->addValidator('Between',true, array('min' => 1, 'max' => 1)); // value one
		
		

		$this->addElement('checkbox', 'accept', array(
				'label'=>'Do you agree with <a href="/index/rules">rules</a>?',
				'uncheckedValue'=> '',
				'checkedValue' => 'I Agree',
				'validators' => array(
						array('notEmpty', true, array(
								'messages' => array(
										'isEmpty'=>'You must agree to the terms.'
								)
						))
				),
				'decorators' => array(
						array('FieldSize'),
						array('ViewHelper'),
						array('Addon'),
						array('ElementErrors'),
						array('Description', array('tag' => 'p', 'class' => 'help-block')),
						array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
						array('Label', array('class' => 'control-label','escape' => false)),
						array('Wrapper')
						),		
				'required'=>true,
		));
		

		$this->addDisplayGroup(
				array('name','email','email_verification','password','password_verification','verification','accept'), 'Sign Up', array('legend' => 'Sign up')
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



