<?php
namespace App\Form\Project;

class UpdateForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $member = null;
	
	public function __construct($member)
	{
		parent::__construct();
	}
	
	public function init()
	{	
 
		$this->addElement('text', 'title', array(
				'label' => 'Project Name',
				'required' => true,
				'filters' => array('StringTrim'),
				//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
				'description' => "name of your project",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,100)) )
		));
		
		
		// TinyMCE configuration in the phtml file
		$this->addElement('textarea', 'content', array(
				'label' => 'message',
				'required' => true,
				'rows' => 4,
				'class' => "span7",
				'errorMessages' => array("You missing content of your comment."),
				'description' => "description",
				'validators' => array("NotEmpty"),
		));
	
		// Form section
		$this->addDisplayGroup(
				array('title','content'),
				'main',
				array( 'legend' => 'add new comment')
		);
		 
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "add comment",
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



