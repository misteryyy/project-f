<?php
namespace App\Form\Admin;

class SlideshowForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $project= null;
	private $slot = null;
	
	public function __construct($project,$slot)
	{
		$this->project = $project; 
		$this->slot = $slot;
		parent::__construct();
	}
	
	public function init()
	{		
		if($this->project){
			$message =  '<div class="alert alert-info">SLOT '.$this->slot.'<strong> current project > '.$this->project->title.'</strong></div>';
			$value = $this->project->id;
		} else {
			$message =  '<div class="alert alert-info">SLOT '.$this->slot.'<strong> is empty </strong></div>';
			$value = null;
		}
		
		// Description of roles
		 $this->addElement('hidden', 'info', array(
		 					'description' => $message,
		 					'ignore' => true,
		 					'decorators' => array(
		 							array('Description', array('escape'=>false, 'tag'=>'')),
		 					),
		 			));
		 
		 $this->addElement('hidden', 'slot_position', array('value'=> $this->slot));
		 $this->addElement('text', 'project_id', array(
		 		'label' => 'Project ID',
		 		'value' => $value,
		 		'dimension' => 1,
		 		'required' => true,
		 		'filters' => array('StringTrim'),
		 		'description' => "id",
		 		'validators' => array( array('Int',false, array(""))) 
		 ));
 	
		// Form section
		$this->addDisplayGroup(
				array('info','slot_position','project_id'),
				'main',
				array( 'legend' => 'SLOT '.$this->slot)
		);
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Update Slot ".$this->slot,
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



