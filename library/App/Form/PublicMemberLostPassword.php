<?php

namespace App\Form;

class PublicMemberLostPassword extends \EasyBib_Form
{
	public function init()
	{
		
		$this->setMethod('post');
		$this->setAttrib('class', 'form-horizontal');
		 
		$mail = new \Zend_Form_Element_Text('email');
		// config elements
		$mail->setLabel('Email:')
		->setRequired(true)
		->setAttrib('size', 35)
		->addErrorMessage('Please provide a valid e-mail address')
		->setDescription('To this email address will be send information about lost password.')
		->addValidator('emailAddress');
		 
		$check  = new \Zend_Form_Element_Checkbox(('check'));
		$check->setRequired(true)
				->addErrorMessage('You have to agree with sending the email')
				->setDescription('Check this to aprove that you really want to send new password');
	
		// submit
		$submit = new \Zend_Form_Element_Button('submit');
		$submit->setLabel('Request new password')
		->setAttrib('type', 'submit');
		 
		// cancel
		$cancel = new \Zend_Form_Element_Button('cancel');
		$cancel->setLabel('Cancel');
		 
		// add elements
		$this->addElements(array(
				$mail, $check,$submit, $cancel
		));
		 
		// add display group
		$this->addDisplayGroup(
				array( 'email','check' ,'submit', 'cancel'),
				'lost-password'
		);
		 
		// set decorators
		\EasyBib_Form_Decorator::setFormDecorator($this, \EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');

	}

	public function isValid($data)
	{
		if (!is_array($data)) {
			require_once 'Zend/Form/Exception.php';
			throw new \Zend_Form_Exception(__METHOD__ . ' expects an array');
		}
		return parent::isValid($data);
	}
}


