<?php

class Site_PlaygroundController extends  Boilerplate_Controller_Action_Abstract
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em = null;

    /**
     * @var \sfServiceContainer
     */
    protected $_sc = null;

    /**
     * @var \App\Service\RandomQuote
     * @InjectService RandomQuote
     */
    protected $_randomQuote = null;

    
    
    public function init()
    {
    	parent::init();
        $this->_em = Zend_Registry::get('em');
    }

   

    
    public function indexAction()
    {
    	//$this->_helper->layout()->disableLayout();
    	
    	try{
  		throw new Exception("Password already exists");
    	} catch (Exception $e){
    		/*
    		 * Exception message
    		*/
    		$this->_helper->FlashMessenger( array('error' => 	$e->getMessage())
    		);		
    	}
    	/*
    	 * Error message
    	*/
    	$this->_helper->FlashMessenger(
    			array('error' => 'There was a problem with your form submission.')
    	);
    	 
    	/*
    	 * Success message
    	*/
    	$this->_helper->FlashMessenger(
    			array('success' => 'This is just suxxess, that everything is all right.')
    	);
    	 
    	/*
    	 * Info message
    	*/
    	$this->_helper->FlashMessenger(
    			array('info' => 'This is just notification, that everything is all right.')
    	);
    	
    	
    	
    	$testForm = new \App\Form\PublicMemberSignUp();
    	$this->view->form = $testForm;
    	
    	if ($this->_request->isPost()) {
    		if ($testForm->isValid($this->_request->getPost())) {
    	
    			// fetch values
    			$values = $testForm->getValues();
    	
    			// ... do some stuff
    		}
    	
    		// print error
    		else {
    			$testForm->buildBootstrapErrorDecorators();
    			
    			$this->view->messages = array('error', 'Please control your input!'); // extra message on top
    		}
    	}
    	
    	pr($this->_getAllParams() );
    	
    }

}