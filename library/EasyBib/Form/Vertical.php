<?php


abstract class EasyBib_Form_Vertical extends EasyBib_Form
{
    /**
     * Class constructor override.
     *
     * @param null $options
     */
    public function __construct($options = null)
    {
//         $this->setElementDecorators(array(
//             array('FieldSize'),
//             array('ViewHelper'),
//             array('ElementErrors'),
//             array('Description', array('tag' => 'p', 'class' => 'help-block')),
//             array('Addon')
//         ));

//         $this->setDecorators(array(
//             'FormElements',
//             'Form'
//         ));
        
        parent::__construct($options);
    }
}
