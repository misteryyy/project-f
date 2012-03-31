<?php
/*
 * 
 */

namespace App\Form;

class PublicMemberSignUp extends \EasyBib_Form
{
    public function init()
    {
    	$this->setMethod('POST');
    	$this->setAttrib('class', 'form-horizontal');
    	
    	// create elements
    	$name = new \Zend_Form_Element_Text('name'); 
    	$mail = new \Zend_Form_Element_Text('email');
    	$password = new \Zend_Form_Element_Password('password');
    	$password_verify = new \Zend_Form_Element_Password('password_verify');
    	$radio = new \Zend_Form_Element_Radio('radio');
       	$submit = new \Zend_Form_Element_Button('submit');
    	$cancel = new \Zend_Form_Element_Button('cancel');

    	
    	$name->setLabel('Name:')
    	->setRequired(true)
    	->addValidator('Alnum', true, array('allowWhiteSpace' => true));
    	
    	// config elements
    	$mail->setLabel('Email:')
    	->setRequired(true)
    	->setDescription('is used like a login name')
    	->addValidator('emailAddress');
    	
    	$password->setLabel("Password:")
    	->setRequired(true)
    	->setDescription('Password has to be min 5 letters long')
    	->addValidator('Between',true, array('min' => 5, 'max' => 20)); // password bettween 5-20 letters
    	
    	$password_verify->setLabel("Password verification:")
    	->setRequired(true)
    	->addValidator('Identical', true, array('token' => 'password'))
    	->addValidator('Between',true, array('min' => 5, 'max' => 20)); // password bettween 5-20 letters
    	
    	
    	$radio->setLabel('Choose green color box:')
    	->setMultiOptions(array('1' => PHP_EOL . 'Yellow', '2' => PHP_EOL . 'Blue','3' => PHP_EOL . 'Red','4' => PHP_EOL . 'Black'))
    	->setRequired(true);
    	
    	$submit->setLabel('Sign up')
    	->setAttrib('type', 'submit');
    	$cancel->setLabel('Cancel');
    	
    	// add elements
    	$this->addElements(array(
    			$name, $mail, $password, $password_verify, $radio, $submit, $cancel
    	));
    	
    	// add display group
    	$this->addDisplayGroup(
    			array('name', 'email','password','password_verify', 'radio', 'submit', 'cancel'),
    			'sign-up'
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