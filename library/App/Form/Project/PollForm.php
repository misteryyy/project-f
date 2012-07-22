<?php
namespace App\Form\Project;

class PollForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $member = null;
	private $project = null;
	
	public function __construct($member,$project)
	{
		$this->member = $member;
		$this->project = $project;
		parent::__construct();
	
	}
	
	public function init()
	{	
		// ajax call
		$this->setAction("/project/widget/ajax-poll/id/".$this->project->id."/_method/create");
		$this->addAttribs(array("id" => "form-poll"));
		
		// Description of roles
		 $this->addElement('hidden', 'logged_member', array(
		 					'description' => '<div class="alert alert-info">Logged as: <strong>'.$this->member['name'].'</strong></div>',
		 					'ignore' => true,
		 					'decorators' => array(
		 							array('Description', array('escape'=>false, 'tag'=>'')),
		 					),
		 			));
		 $addGroup[] = "logged_member";
		 
		 // Description of roles
		 $this->addElement('hidden', 'message', array(
		 		'description' => '<div class="alert alert-success">1 is the best. 5 is the worst.</div>',
		 		'ignore' => true,
		 		'decorators' => array(
		 				array('Description', array('escape'=>false, 'tag'=>'')),
		 		),
		 ));
		 $addGroup[] = "message";
		 	
		 
		 // questions 
		 $arrayOptions = array(1 => 1,	2 =>2,	3 => 3,4 =>4, 5 => 5);
		 // submit button
		 $this->addElement('select','question_1',array(
		 		'label' => "Question number one?",
		 		'multiOptions' => $arrayOptions
		 ));
		 $addGroup[] = "question_1";
		 
		 
	
	
		// Form section
		$this->addDisplayGroup(
				$addGroup,
				'main',
				array( 'legend' => 'Creators poll')
		);
		 
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Vote",
				'escape' => false,
		));
		  
		// Action Section
		$this->addDisplayGroup(
				array('submit'),
				'actions',
				array(
						'disableLoadDefaultDecorators' => true,
						'decorators' => array('Actions')
				)
		);




	}
}



