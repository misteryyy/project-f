<?php
/**
 * View helper definition
 *
 * @category Forms
 * @package Twitter_Bootstrap_View
 * @subpackage Helper
 * @author Christian Soronellas <csoronellas@emagister.com>
 */

/**
 * Helper to generate a "file" element with the Twitter's Bootstrap UI
 *
 * @category Forms
 * @package Twitter_Bootstrap_View
 * @subpackage Helper
 * @author Christian Soronellas <csoronellas@emagister.com>
 */
class Twitter_Bootstrap_View_Helper_FormHtml extends Zend_View_Helper_FormElement
{
    /**
     * Generates a 'note' element.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are extracted in place of added parameters.
     *
     * @param array $attribs Attributes for the element tag.
     *
     * @return string The element XHTML.
     */
    public function formHtml($name, $value,$attribs = null)
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, id, value, attribs, options, listsep, disable

        
        // class name
        $attribs['class'] = isset($attribs['class']) ? $attribs['class'] . '  name ' : ' not nastaveno name';

        // is it disabled?
        $disabled = '';
        if ($disable) {
            $attribs['class'] .= ' disabled';
            $disabled = ' disabled="disabled"';
        }

        // XHTML or HTML end tag?
        $endTag = ' />';
        if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
            $endTag= '>';
        }

        // build the element
        $xhtml = '<div class="well"'
                . ' name="' . $this->view->escape($name) . '"'
                . ' id="' . $this->view->escape($id) . '"'
                . $disabled
                . $this->_htmlAttribs($attribs)
                . $endTag;

        return 'pepino';
    }
}
