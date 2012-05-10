<?php
/**
 * A form file definition
 *
 * @category Forms
 * @package Twitter_Bootstrap_Form
 * @subpackage Element
 * @author Christian Soronellas <csoronellas@emagister.com>
 */

/**
 * A form file element
 *
 * @category Forms
 * @package Twitter_Bootstrap_Form
 * @subpackage Element
 * @author Christian Soronellas <csoronellas@emagister.com>
 */
class Twitter_Bootstrap_Form_Element_Html extends Zend_Form_Element_Xhtml
{
	
	
	/**
	 * Default form view helper to use for rendering
	 * @var string
	 */
	public $helper = 'formHtml';
	
	public function loadDefaultDecorators ()
	{
		parent::loadDefaultDecorators ();
		$this->removeDecorator ('Label');
		$this->removeDecorator ('HtmlTag');
	
		$this->addDecorator('HtmlTag', array (
				'tag'   => 'span',
				'class' => 'help-element-form',
		));
	}
	
 
}