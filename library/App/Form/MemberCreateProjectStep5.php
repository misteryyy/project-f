<?php
namespace App\Form;

/**
 * Survey
 * @author misteryyy
 *
 */
class MemberCreateProjectStep5 extends \Twitter_Bootstrap_Form_Horizontal
{

	public function __construct()
	{
		parent::__construct();
	}

	public function init()
	{
		// Widget Setting
		$this->addElement('checkbox','publish_project_accepted',
				array(  'missingMessage' => "Field '%field%' is required by rule '%rule%', dawg!",
						'required' => true,
						'label' => "Accept terms",
						'description' => 'Please read what will happen if you will disable role widget.',
						'validators' => array(array('GreaterThan', false, array(0)))
				)
		);
		
		$this->addDisplayGroup(
				array('publish_project_accepted'),'accepted',null);
		
		
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Publish Project",
				'escape' => false,
		));
		// Action Section
		$this->addDisplayGroup(
				array('submit',),
				'actions',
				array(
						'disableLoadDefaultDecorators' => true,
						'decorators' => array('Actions')
				)
		);




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



