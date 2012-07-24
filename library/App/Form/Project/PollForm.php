<?php
namespace App\Form\Project;

class PollForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $project = null;
	private $poll = null;
	private $answers = null;
	public function __construct($project,$poll,$answers = null)
	{
		$this->poll = $poll; 
		$this->project = $project;
		$this->answers = $answers; // if user has voted
		parent::__construct();
	
	}
	
	
	
	
	public function init()
	{	
		// ajax call
			$this->addAttribs(array("id" => "form-poll","class" => ""));

		// header
		$this->addElement('hidden', 'created', array(
					'description' => '<p class="fl-feedback-date">This poll was created on '.$this->poll->created->format('Y/m/d').'</p>',
					'ignore' => true,
					'decorators' => array(
							array('Description', array('escape'=>false, 'tag'=>'')),
					),
			));
		$addGroup[] = 'created';
			
		
		 $this->addElement('hidden', 'poll_id', array(
		 		'value' => $this->poll->id));
		 	
		 $addGroup[] = 'poll_id';
		 
		 // questions 
		 $arrayOptions = array(1 => 1,	2 =>2,	3 => 3,4 =>4, 5 => 5);
		 // create questions

		 // decorator for radios
		 $decors = array(
		 		'ViewHelper',
		 		array('HtmlTag',array('tag'=>'div','class'=>"fl-feedback-answer")),
		 		//array('HtmlTag', array('tag' => 'dd')),
		 		array( array('labelDivClose' => 'HtmlTag'), array('tag' => 'div', 'closeOnly' => true, 'placement' => 'prepend')),
		 		'Label',
		 		array(array('labelDivOpen' => 'HtmlTag'), array('tag' => 'div', 'openOnly' => true, 'placement' => 'prepend', 'class' => 'fl-feedback-question')),
		 		array(array('labelLiOpen' => 'HtmlTag'), array('tag' => 'li', 'openOnly' => true, 'placement' => 'prepend')),
		 
		 		 
		 );
		 
		 if($this->answers == null) {
			 foreach ($this->poll->questions as $q){
			 
			 	$this->addElement('radio','question_'.$q->id,array(
			 			'label' => $q->question,
			 			'multiOptions' => $arrayOptions,
			 			'disableLoadDefaultDecorators' => true,
			 			'decorators' => $decors,
			 			'value' => 1
			 	
			 	));
			 	$addGroup[] = "question_".$q->id;
			 	
			 	$submitLabel = "Vote";
			 }
		 } else {
		 	
		 	$i = 0;
		 	foreach ($this->poll->questions as $q){
		 		$this->addElement('radio','question_'.$q->id,array(
		 				'label' => $q->question,
		 				'value' => $this->answers[$i]->answer,
		 				'multiOptions' => $arrayOptions,
		 				'disableLoadDefaultDecorators' => true,
		 				'decorators' => $decors
		 			
		 		));
		 		
		 		$addGroup[] = "question_".$q->id;
		 		$i++;
		 	}
		 	
		 	$submitLabel = "Change Vote";
		 }
		
		 // information about change
		 $this->addElement('hidden', 'change', array(
		 		'description' => '<p class="fl-feedback-info">You can change your answers later.</p>',
		 		'ignore' => true,
		 		'decorators' => array(
		 				array('Description', array('escape'=>false, 'tag'=>'')),
		 		),
		 ));
		 $addGroup[] = 'change';
		 	
		 //	submit button
		 $this->addElement('submit','submit',array(
		 		//'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
		 		'label' => $submitLabel,
		 		'escape' => false,
		 		'class' => "btn btn-primary right",
		 		'disableLoadDefaultDecorators' => true,
		 		'decorators' => array("ViewHelper")
		 ));
		 
		 $addGroup[] = 'submit';
		 	
		 
		// Form section
		$this->addDisplayGroup(
				$addGroup,
				'main',
				array(  array('legend' => "Leave feedback - help out", 'class' => 'hide' ),
						'disableLoadDefaultDecorators' => true,
						'decorators' => array(
								array('FormElements'),
								array('HtmlTag',array('tag'=>'ul','class'=>"fl-feedback-poll")),
								
								array('Fieldset')
									))
		);
		 
	
	




	}
}



