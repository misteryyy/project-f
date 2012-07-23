<?php
namespace App\Form\Project;

class AddPollForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	public function init()
	{	
		// ajax call
		$this->addAttribs(array("id" => "form-poll-create"));

		 $warning_message =  <<<EOT
	<div class="alert alert-info">
		<span class="label label-info">Info</span>
		How this works. How this works. How this works.
	</div>
EOT;
		 
		 $this->addElement('hidden', 'warning_survey', array(
		 		'description' => $warning_message,
		 		'ignore' => true,
		 		'decorators' => array(
		 				array('Description', array('escape'=>false, 'tag'=>'')),
		 		),
		 ));
		 
		 // Adding Survey
		 $addGroup[] = 'warning_survey';
		 $this->addElement('text', 'title', array(
		 		'label' => "Poll's name",
		 		'required' => true,
		 		'filters' => array('StringTrim'),
		 		//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
		 		'description' => "name of your new poll",
		 		'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,100)) )
		 ));
		 
		 $addGroup[] = 'title';
		 
		 // Notification about level
		 $this->addElement('hidden', 'hr', array(
		 		'description' => '<hr />',
		 		'ignore' => true,
		 		'decorators' => array(
		 				array('Description', array('escape'=>false, 'tag'=>'')),
		 		),
		 ));
		 $addGroup[] = 'hr'; // make separator
		 	
		 
		 // generation questions for the project
		 for($i = 1;$i <= 5; $i++){
		 	$addGroup[] = "question_".$i;
		 
		 	$this->addElement('text', 'question_'.$i, array(
		 			'label' => 'Question '.$i,
		 			'required' => false,
		 			'dimension' => 5,
		 			'filters' => array('StringTrim'),
		 			'validators' => array(array('StringLength', false, array(1,100)) )
		 	));
		 }
		 

		// Form section
		$this->addDisplayGroup(
				$addGroup,
				'main',
				array( 'legend' => 'Create new poll')
		);
		 
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "create poll",
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



