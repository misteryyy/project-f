<?php
/**
 * Form for new applications in different levels
 * @author misteryyy
 *
 */
namespace App\Form\Project;
use App\Entity\UserRole;

class AddProjectApplicationLevel2Form extends \Twitter_Bootstrap_Form_Horizontal
{
	// object for form
	private $member;
	private $project; 
	private $freeRoles; // questions for applicants
	private $role;
	
	public function __construct($member,$project,$freeRoles,$role)
	{	
		$this->member = $member;
		$this->project = $project;
		$this->freeRoles = $freeRoles;
		$this->role = $role;
		parent::__construct();
	}
	
	/**
	 * Initialization 
	 * @see Zend_Form::init()
	 */
	public function init()
	{
		// ajax call
		$this->setAction("/project/widget/ajax-application/id/".$this->project->id."/_method/create-level-2");
		$this->addAttribs(array("id" => "form-application-level-2-".$this->role));
		// header for modal window
		$this->generateHeader();		
		$this->generateContent(); 
		// The same for every level
		$this->generateFooter();

	}

	/**
	 * In Level 2, Choose the role with description and write why are you appliing.
	 */
	private function generateContent(){
	
		// maximum 5 question
		$addToGroup = 	array('logged_member','level','role');
		// Notification about level
		$this->addElement('hidden', 'hr', array(
				'description' => '<hr />',
				'ignore' => true,
				'decorators' => array(
						array('Description', array('escape'=>false, 'tag'=>'')),
				),
		)); 
		
		foreach($this->freeRoles as $r){
			// filter descriptions
			if($r->name === $this->role){
				$arrayDescription[$r->id] = $r->description;
			}
		}
		
		$addToGroup[] = 'role_name';
		$this->addElement('text', 'role_name', array(
				'label' => 'Role',
				'value' => $this->role,
				'required' => true,
				'disabled' => true,
				'filters'    => array('StringTrim'),
				'description' => "Position you are applying for.",
				'validators' => array( array('StringLength', false, array(0,100) ))));

		$addToGroup[] = 'role_id'; 
		// Country Select Box
		$this->addElement('select','role_id', array(
				'label' => 'Choose specific position',
				'multiOptions' => $arrayDescription
					
		));
		
		
		
		// For whic level are we applying?
		$this->addElement('hidden','level', array(
				'value' => 2
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



