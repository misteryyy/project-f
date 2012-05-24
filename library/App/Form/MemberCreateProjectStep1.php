<?php
namespace App\Form;

class MemberCreateProjectStep1 extends \Twitter_Bootstrap_Form_Horizontal
{
	
	protected $categories; // Array of categories from DB
	
	public function __construct($categories)
	{
		$this->categories = $categories;
		parent::__construct();
	}
	
	
	public function init()
	{
		// $this->setIsArray(true);
		// $this->setElementsBelongTo('bootstrap'); // will make form array
		$this->_addClassNames('well');
		
		$this->addElement('text', 'title', array(
				'label' => 'Project Name',
				'required' => true,
				'filters' => array('StringTrim'),
				//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
				'description' => "name of your project",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(1,100)) )
		));
	
		
		
		// Priority
		$this->addElement('select','category', array(
				'label' => 'Category',
				'multiOptions' => $this->categories,	 
		));
		
		for($i = 1; $i <=10;$i++){
			$priority[$i] = $i;
		}
		// Passion Bar
		$this->addElement('select','priority', array(
				'label' => 'Priority',
				'description' => "how serious you are with this project?",
				'multiOptions' => $priority
		));
			
		
		$this->addElement('text', 'pitch', array(
				'label' => 'Sentence Pitch',
				'class' => 'span6',
				'required' => true,
				'errorMessages' => array("You should have sentence pitch which will simply describe your goal."),
				'description' => "description",
				'validators' => array("NotEmpty"),
		));

		// TinyMCE configuration in the phtml file
		$this->addElement('textarea', 'content', array(
				'label' => 'Description',
				'required' => true,
				'errorMessages' => array("You should have descripton of your project."),
				'description' => "description",
				'class' => 'span10',
				'validators' => array("NotEmpty"),
				'disableLoadDefaultDecorators' => true,
		));
		
		$this->addElement('textarea', 'plan', array(
				'label' => 'plans',
				'class' => 'span10',
				'rows' => '3',
				'required' => false,
				'description' => "description",
		));
		
		$this->addElement('textarea', 'issue', array(
				'label' => 'issues',
				'class' => 'span10',
				'rows' => '3',
				'required' => false,
				'description' => "description",
		));
		
		$this->addElement('textarea', 'lesson', array(
				'label' => 'lessons',
				'class' => 'span10',
				'rows' => '3',
				'required' => false,
				'description' => "description",
		));
		
		$this->addElement('text', 'project_tags', array(
				'label' => 'Tags',
				'required' => false,
				'filters'    => array (array('StringTrim'), array("StringToLower")),
				//	'errorMessages' => array("The date should be int format"),
				'description' => "design, performance, ... ",
				'validators' => array( array('StringLength', false, array(0,250) ),
						array('regex',false, array('/^([\+\-\#\.a-z0-9A-Z ]*[,]?)+$/') ) //
				)
		));

		$this->addDisplayGroup(
				array('title','category','priority','pitch','content','plan','issue','lesson','project_tags'), 'Create Project - General Information', array('legend' => 'Step 1')
		);

		
		// submit button
		$this->addElement('submit','submit',array(
				'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
				'label' => "Continue",
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



