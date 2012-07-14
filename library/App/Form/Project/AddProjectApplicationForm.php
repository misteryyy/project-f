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
		// ajax call
		$this->setAction("/project/widget/ajax-application/id/".$this->project->id."/_method/create");
		$this->addAttribs(array("id" => "form-application"));
		// header for modal window
		$this->generateHeader();
		// changes with different levels
		if($this->project->level == 1){
			$this->generateLevel1(); 
		}

		// The same for every level
		$this->generateFooter();

	}

	/**
	 * Look for LEVEL 2 / Max 5 questoins plus one compulsory question
	 */
	private function generateLevel1(){
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
		
		// For whic level are we applying?
		$this->addElement('hidden','level', array(
				'value' => 1
		));
	
		// maximum 5 question
		$addToGroup = 	array('logged_member','level','role');
		$index = 1;
		foreach($this->questions as $q){
			
			// For whic level are we applying?
			$this->addElement('hidden','question_'.$index, array(
					'value' => $this->project->level
			));
			
			$this->addElement('textarea', 'answer_'.$index, array(
				'label' => $q->question,
				'required' => true,
				'rows' => 4,
				'errorMessages' => array("You should have descripton of your project."),
				'description' => "description",
				'validators' => array("NotEmpty"),
				'disableLoadDefaultDecorators' => true,
			));
			// add to group
			$addToGroup[] = 'question_'.$index;
			$addToGroup[] = 'answer_'.$index;
			$index++;
		} 

		// Notification about level
		$this->addElement('hidden', 'hr', array(
				'description' => '<hr />',
				'ignore' => true,
				'decorators' => array(
						array('Description', array('escape'=>false, 'tag'=>'')),
				),
		));
		$addToGroup[] = 'hr'; // make separator
			
		$addToGroup[] = 'content'; // make separator
		$this->addElement('textarea', 'content', array(
				'label' => 'What can you offer for this project?',
				'required' => true,
				'rows' => 4,
				'errorMessages' => array("You should have descripton of your project."),
				'description' => "description",
				'validators' => array("NotEmpty"),
				'disableLoadDefaultDecorators' => true,
		));
	
		
		/**
		 * Group addition 
		 */
		$this->addDisplayGroup(
			$addToGroup, 'application_group',
				array(
						'disableLoadDefaultDecorators' => true,
						'decorators' => array(
								array('FormElements'),
								array('Fieldset'),
								array('HtmlTag',array('tag'=>'div','class'=>"modal-body")) // pack for the modal window
						)
				)
		);
	}
	
	/**
	 * Generates header for modal window
	 */
	private function generateHeader(){
	
		// Notification about level
		$this->addElement('hidden', 'header', array(
				'description' => '<div class="modal-header"><button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Application for level '.$this->project->level.'</h3></div>',
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
	
	}
	
	/**
	 * Generates footer for forms
	 */
	private function generateFooter(){
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



