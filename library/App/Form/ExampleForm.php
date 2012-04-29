<?php

namespace App\Form;

class ExampleForm extends \Twitter_Bootstrap_Form_Horizontal
{
   public function init()
    {
      //  $this->setIsArray(true);
       // $this->setElementsBelongTo('bootstrap'); // will make form array

    	$this->addElement('text', 'title', array(
    			'label' => 'Project Name',
    			'required' => true,
    			'filters'    => array('StringTrim'),
    			//'errorMessages' => array("You have to have project title. You can use just letters and numbers"),
    			//'description' => "description",
				'validators' => array( array('alnum',false, array("allowWhiteSpace" => true)), array('StringLength', false, array(6,20)) )			
    	));
    	
    	$this->addElement('hidden',"id",array(	'disableLoadDefaultDecorators' => true));
    	
    	$this->addElement('text', 'pitch', array(
    			'label' => 'Sentence Pitch',
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
        	 		'validators' => array("NotEmpty"),
        	 		'disableLoadDefaultDecorators' => true,
        	 		
        			
         	));

        
         
        	
         	$this->addDisplayGroup(
        			array('title','pitch','content','email','password'), 'Create Project',	array('legend' => 'Lost Password')
        	);
       
         	
         	// submit button
         	$this->addElement('submit','submit',array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label' => "Create Project",
         			'escape'        => false,
         	));
         	 
         	 
         	$this->addElement('button', 'reset', array(
         			'buttonType' => \Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY,
         			'label'         => 'Reset',
         			'type'          => 'reset'
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




// class ExampleForm extends \EasyBib_Form
// {
//     public function init()
//     {

//         // create elements
//         $userId      = new \Zend_Form_Element_Hidden('id');
//         $mail        = new \Zend_Form_Element_Text('email');
//         $name        = new \Zend_Form_Element_Text('name');
//         $radio       = new \Zend_Form_Element_Radio('radio');
//         $file        = new \Zend_Form_Element_File('file');
//         $multi       = new \Zend_Form_Element_MultiCheckbox('multi');
//         $captcha     = new \Zend_Form_Element_Captcha('captcha', array('captcha' => 'Figlet'));
//         $submit      = new \Zend_Form_Element_Button('submit');
//         $cancel      = new \Zend_Form_Element_Button('cancel');
        
        

//         // config elements

//         $mail->setLabel('Mail:')
//             ->setAttrib('placeholder', 'data please!')
//             ->setRequired(true)
//             ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fringilla purus eget ante ornare vitae iaculis est varius.')
//             ->addValidator('emailAddress');

//         $name->setLabel('Name:')
//             ->setRequired(true);

//         $radio->setLabel('Radio:')
//             ->setMultiOptions(array('1' => PHP_EOL . 'test1', '2' => PHP_EOL . 'test2'))
//             ->setRequired(true);

//         $file->setLabel('File:')
//             ->setRequired(true)
//             ->setDescription('Check file upload');

//         $multiOptions = array(
//             'view'    => PHP_EOL . 'view',
//             'edit'    => PHP_EOL . 'edit', 
//             'comment' => PHP_EOL . 'comment'
//         );
//         $multi->setLabel('Multi:')
//             ->addValidator('Alpha')
//             ->setMultiOptions($multiOptions)
//             ->setRequired(true);

//         $captcha->setLabel('Captcha:')
//             ->setRequired(true)
//             ->setDescription("This is a test");

//         $submit->setLabel('Save')
//             ->setAttrib('type', 'submit');
//         $cancel->setLabel('Cancel');

//         // add elements
//         $this->addElements(array(
//             $userId, $mail, $name, $radio, $file, $captcha, $multi, $submit, $cancel
//         ));

//         // add display group
//         $this->addDisplayGroup(
//             array('email', 'name', 'radio', 'multi', 'file', 'captcha', 'submit', 'cancel'),
//             'users'
//         );

//         // set decorators
//         \EasyBib_Form_Decorator::setFormDecorator($this, \EasyBib_Form_Decorator::BOOTSTRAP, 'submit', 'cancel');

//     }

