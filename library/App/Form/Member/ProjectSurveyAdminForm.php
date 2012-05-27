<?php
namespace App\Form\Member;

/**
 * Survey
 * @author misteryyy
 *
 */
class ProjectSurveyAdminForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	protected $questions; // Array of categories from DB
	protected $answers; // Array of answers from DB
	
	public function __construct($questions,$answers)
	{
		$this->questions = $questions;
		$this->answers = $answers;
		parent::__construct();
	}
	
	
	public function init()
	{	$this->addAttribs(array("id" => "step")); // for jquery stepy plugin
		
		// GENERATE QUESTIONS
		foreach($this->questions as $index => $q){	
			$answerObj = $this->answers[$index-1];
			$this->addElement('textarea', 'answer_'.$answerObj->id, array(
					'label' => 'Your answer:',
					'value' => $answerObj->answer, // displaing answers
					'required' => false,
					'class' => 'span10',
					'rows' => 3,
					'filters' => array('StringTrim'),
					'description' => "max 250 letters",
					'validators' => array(array('StringLength', false, array(1,250)) )
			));
			
			$this->addDisplayGroup(
					array('answer_'.$answerObj->id), 'Q'.$index, array('legend' => $q,'title'=>"Q".$index)
			);
		}
		

		// SUBMIT SECTION / works with jquery in view
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
				array('submit','reset'),
				'actions',
				array(
						'disableLoadDefaultDecorators' => true,
						'decorators' => array('Actions')
				)
		);




	}
}



