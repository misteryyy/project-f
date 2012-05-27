<?php
namespace App\Form\Project;

class ProjectBoardForm extends \Twitter_Bootstrap_Form_Horizontal
{
	
	private $member = null;
	
	public function __construct($member,$project_id)
	{
		$this->member = $member;
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
		
		for($i=0;$i<5;$i++){
		$this->addElement('file', 'file_'.$i, array(
				'label' => 'Attach File #'.($i+1),
				
				'description' => "Max size 4MB (Allowed extenstions: pdf,doc,odt,jpeg,jpg,png)",
				'decorators' => array(
						array('File'),
						array('ElementErrors'),
						array('Description', array('tag' => 'p', 'class' => 'help-block')),
						array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
						array('Label', array('class' => 'control-label')),
						array('Wrapper')
				),
				'filters' => array(
						array('LowerCase'),
						array('ElementErrors'),
						array('Description', array('tag' => 'p', 'class' => 'help-block')),
						array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
						array('Label', array('class' => 'control-label')),
						array('Wrapper')
				)
		));
		
		}
		
		// Form section
		$this->addDisplayGroup(
				array('logged_member','content','file_0','file_1','file_2','file_3','file_4','file_5'),
				'main',
				array( 'legend' => 'add new project message')
		);
		 
		 
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "add comment",
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



