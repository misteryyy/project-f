<?php
/*
 * 
 */

namespace App\Form;

class PublicMemberLogin extends \EasyBib_Form
{
    public function init()
    {
        $this->setMethod('post');
    	$this->setAttrib('class', 'form-horizontal');

    	$mail = new \Zend_Form_Element_Text('email');
    	$password = new \Zend_Form_Element_Password('password');
       	$submit = new \Zend_Form_Element_Button('submit');
    	$cancel = new \Zend_Form_Element_Button('cancel');

    	

    	// config elements
    	$mail->setLabel('Email:')
    	->setRequired(true)
    	->addValidator('emailAddress');
    	
    	$password->setLabel("Password:")
    	->setRequired(true);
    
    	
    	$submit->setLabel('Login')
    	->setAttrib('type', 'submit');
    	$cancel->setLabel('Cancel');
    	
    	// add elements
    	$this->addElements(array(
    			$mail, $password, $submit, $cancel
    	));
    	
    	// add display group
    	$this->addDisplayGroup(
    			array( 'email','password', 'submit', 'cancel'),
    			'login'
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