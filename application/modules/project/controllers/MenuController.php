<?php
class Project_MenuController extends  Boilerplate_Controller_Action_Abstract
{
	public function init(){
		parent::init();
	}
		
	
	public function headerAction()
	{
	}
	
	/**
	 * Rendering the menu for helping me
	 */
	public function menuDebugAction()
	{
	}
	
	/**
	 * Menu for Creator
	 */
	public function menuCreatorAction(){
	
		$this->view->project_id = $this->_getParam("id");
	
	}
	

	
	public function breadcrumbsAction()
	{
	}
	
	
}

