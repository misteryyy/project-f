<?php
namespace App\Form\Project;
use App\Entity\UserRole;

class TeamSurveyQuestion extends \Twitter_Bootstrap_Form_Horizontal
{
	
	protected $questions; // Array of categories from DB
	
	
	public function __construct($questions)
	{
		$this->questions = $questions;
		parent::__construct();
	}
	
	
	public function init()
	{		
		
		$warning_message =  <<<EOT
	<div class="alert alert-info">
		<span class="label label-info">Info</span>
		What is survey for.What is survey for.What is survey for.What is survey for.What is survey for.What is survey for.
		What is survey for.What is survey for.What is survey for.What is survey for.What is survey for.What is survey for.
	</div>
EOT;

		$this->addElement('hidden', 'warning_survey', array(
				'description' => $warning_message,
				'ignore' => true,
				'decorators' => array(
						array('Description', array('escape'=>false, 'tag'=>'')),
				),
		));
				
		foreach ($this->questions as $q){
			
			echo $q->id;
		}
		exit;
		
		// Adding Survey
		$addQuestion [] = 'warning_survey';		
		// generation questions for the project
		for($i = 1;$i <= 5; $i++){
			$addQuestion [] = "question_".$i;
			
			$this->addElement('text', 'question_'.$i, array(
					'label' => 'Question '.$i,
					'required' => false,
					'filters' => array('StringTrim'),
					'validators' => array(array('StringLength', false, array(1,100)) )
			));
		}
			
		$this->addDisplayGroup(
				$addQuestion,
				'role_widget_survey',
				array('legend' => 'Questions for project')
		);
		
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Save",
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



