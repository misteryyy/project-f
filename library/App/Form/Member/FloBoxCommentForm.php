<?php
namespace App\Form\Member;

class FloBoxCommentForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $member = null;
	private $flobox_id = null; // id for hidden element
	
	public function __construct($member,$flobox_id)
	{
		$this->member = $member;
		$this->flobox_id = $flobox_id;
		parent::__construct();
	}

	public function init()
	{	
		// Description of roles
		 $this->addElement('hidden', 'logged_member', array(
		 					'description' => '<div class="alert alert-info">Logged as: <strong>'.$this->member['name'].'</strong></div>',
		 					'ignore' => true,
		 					'decorators' => array(
		 							array('Description', array('escape'=>false, 'tag'=>'')),
		 					),
		 			));
		 
		 // Description of roles
		 $this->addElement('hidden', 'flobox_id', array('value'=>$this->flobox_id));

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
				array('logged_member','content','comment_id'),
				'main',
				array( 'legend' => 'Answer')
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



