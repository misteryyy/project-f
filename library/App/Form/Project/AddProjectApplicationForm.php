<?php
/**
 * Form for new applications in different levels
 * @author misteryyy
 *
 */
namespace App\Form\Project;
use App\Entity\UserRole;

class AddProjectApplicationForm extends \Twitter_Bootstrap_Form_Horizontal
{
	// object for form
	private $member;
	private $project; 
	private $questions; // questions for applicants
	public function __construct($member,$project,$questions)
	{	
		$this->member = $member;
		$this->project = $project;
		$this->questions = $questions;
	
		parent::__construct();
	}
	
	/**
	 * Initialization 
	 * @see Zend_Form::init()
	 */
	public function init()
	{
		// Notification about level
		$this->addElement('hidden', 'level', array(
				'description' => '<div class="alert alert-info">Application for level <strong>'.$this->level.'</strong></div>',
				'ignore' => true,
				'decorators' => array(
						array('Description', array('escape'=>false, 'tag'=>'')),
				),
		));
		
		// Currently Logged Applicant
		$this->addElement('hidden', 'logged_member', array(
				'description' => '<div class="alert alert-info">Logged as: <strong>'.$this->member['name'].'</strong></div>',
				'ignore' => true,
				'decorators' => array(
						array('Description', array('escape'=>false, 'tag'=>'')),
				),
		));
		
		$name = "role";
		$arrayRoles = array(
				UserRole::MEMBER_ROLE_STARTER => UserRole::MEMBER_ROLE_STARTER,
				UserRole::MEMBER_ROLE_LEADER => UserRole::MEMBER_ROLE_LEADER,
				UserRole::MEMBER_ROLE_BUILDER => UserRole::MEMBER_ROLE_BUILDER,
				UserRole::MEMBER_ROLE_GROWER => UserRole::MEMBER_ROLE_GROWER,
				UserRole::MEMBER_ROLE_ADVISER => UserRole::MEMBER_ROLE_ADVISER,
				
		);
		
		// Country Select Box
		$this->addElement('select','role', array(
				'label' => 'Choose role',
				'multiOptions' => $arrayRoles
				 
		));
	
		$this->addElement('textarea', 'content', array(
				'label' => 'What can you offer for this project?',
				'required' => true,
				'rows' => 4,
				'errorMessages' => array("You should have descripton of your project."),
				'description' => "description",
				'validators' => array("NotEmpty"),
				'disableLoadDefaultDecorators' => true,
		));

		
		
		$this->addElement('textarea', 'question_1', array(
				'label' => 'What can you offer for this project?',
				'required' => true,
				'rows' => 4,
				'errorMessages' => array("You should have descripton of your project."),
				'description' => "description",
				'validators' => array("NotEmpty"),
				'disableLoadDefaultDecorators' => true,
		));
		
		
		$this->addDisplayGroup(
				array('logged_member','level','role','question','content'), 'Application', array()
		);
		

		
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Send Application",
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
						'decorators' => array('ActionsModal')
				)
		);

	}
}



