<?php
namespace App\Form\Project;

class PollForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $project = null;
	private $poll = null;
	public function __construct($project,$poll)
	{
		$this->poll = $poll; 
		$this->project = $project;
		parent::__construct();
	
	}
	
	public function init()
	{	
		// ajax call
			$this->addAttribs(array("id" => "form-poll"));
		
		 // Description of roles
		 $this->addElement('hidden', 'message', array(
		 		'description' => '<div class="alert alert-info">1 is the best. 5 is the worst.</div>',
		 		'ignore' => true,
		 		'decorators' => array(
		 				array('Description', array('escape'=>false, 'tag'=>'')),
		 		),
		 ));
		 $addGroup[] = "message";
		 	

		 $this->addElement('hidden', 'poll_id', array(
		 		'value' => $this->poll->id));
		 	
		 $addGroup[] = 'poll_id';
		 
		 // questions 
		 $arrayOptions = array(1 => 1,	2 =>2,	3 => 3,4 =>4, 5 => 5);
		 // create questions
		 
		 foreach ($this->poll->questions as $q){
		 // submit button
		 	$this->addElement('select','question_'.$q->id,array(
		 		'label' => $q->question,
		 		'dimension' => 1,
		 		'multiOptions' => $arrayOptions
		 	));
		 	$addGroup[] = "question_".$q->id;
		 
		 }
	
	
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



