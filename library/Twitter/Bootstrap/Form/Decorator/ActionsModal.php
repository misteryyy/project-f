<?php
/**
 * Decorator definition for the submit buttons
 *
 * @category Forms
 * @package Twitter_Bootstrap_Form
 * @subpackage Decorator
 * @author Christian Soronellas <csoronellas@emagister.com>
 */

/**
 * A decorator to render the submit form buttons
 *
 * @category Forms
 * @package Twitter_Bootstrap_Form
 * @subpackage Decorator
 * @author Christian Soronellas <csoronellas@emagister.com>
 */
class Twitter_Bootstrap_Form_Decorator_ActionsModal extends Zend_Form_Decorator_Abstract
{
    /**
     * Render all the buttons
     *
     * @return string
     */
    public function buildButtons()
    {
        $output = '';
        foreach ($this->getElement() as $element) {
            $element->setDecorators(array(
                array('ViewHelper')
            ));

            $output .= $element->render();
        }

        return $output;
    }

    /**
     * Renders the content
     *
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        return '<div class="modal-footer">	
                    ' . $this->buildButtons() . '
                 <a href="#" class="btn" data-dismiss="modal">Close</a>
        		 </div>';
    }
}