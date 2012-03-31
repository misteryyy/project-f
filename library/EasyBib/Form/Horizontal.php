<?php
/**
 * An "horizontal" Twitter Bootstrap's UI form
 *
 * @category Forms
 * @package Twitter_Bootstrap
 * @subpackage Form
 * @author misteryyy <j.kortan@gmail.com >
 */
abstract class EasyBib_Form_Horizontal extends Twitter_Bootstrap_Form_Vertical
{
    public function __construct($options = null)
    {
//         $this->setDisposition(self::DISPOSITION_HORIZONTAL);

//         $this->setElementDecorators(array(
//             array('FieldSize'),
//             array('ViewHelper'),
//             array('Addon'),
//             array('ElementErrors'),
//             array('Description', array('tag' => 'p', 'class' => 'help-block')),
//             array('HtmlTag', array('tag' => 'div', 'class' => 'controls')),
//             array('Label', array('class' => 'control-label')),
//             array('Wrapper')
//         ));
        
        parent::__construct($options);
    }
}
