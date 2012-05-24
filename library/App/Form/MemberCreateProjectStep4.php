<?php
namespace App\Form;

/**
 * Survey
 * @author misteryyy
 *
 */
class MemberCreateProjectStep4 extends \Twitter_Bootstrap_Form_Horizontal
{
	
	protected $questions; // Array of categories from DB
	
	public function __construct($questions)
	{
		$this->questions = $questions;
		parent::__construct();
	}
	
	
	public function init()
	{
	//	 $this->setIsArray(true);
		// $this->setElementsBelongTo('survey'); // will make form array

		$this->addAttribs(array("id" => "step")); // for jquery stepy plugin
		
		// GENERATE QUESTIONS
		foreach($this->questions as $index => $q){	
			$this->addElement('textarea', 'question_'.$index, array(
					'label' => 'Your answer:',
					'required' => false,
					'class' => 'span10',
					'rows' => 3,
					'filters' => array('StringTrim'),
					'description' => "max 250 letters",
					'validators' => array(array('StringLength', false, array(1,250)) )
			));
			
			$this->addDisplayGroup(
					array('question_'.$index), 'Q'.$index, array('legend' => $q,'title'=>"Q".$index)
			);
		}
		

		// SUBMIT SECTION / works with jquery in view
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Continue",
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
}



