<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @copyright  Copyright (c) 2013-2014 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     integer_net GmbH <info@integer-net.de>
 * @author     Soeren Zorn <sz@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */


/**
 * Class IntegerNet_Haendlerbund_Block_Adminhtml_System_Config_Form_Field_Mapping
 */
class IntegerNet_Haendlerbund_Block_Adminhtml_System_Config_Form_Field_Mapping extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{


    /**
     *
     */
    public function __construct()
    {
        /** @var $helper IntegerNet_Haendlerbund_Helper_Data */
        $helper = Mage::helper('integernet_haendlerbund');

        $this->addColumn('legal_text', array(
            'label'    => Mage::helper('integernet_haendlerbund')->__('Legal Text'),
            'style'    => 'width:250px',
            'renderer' => Mage::app()->getLayout()->createBlock('integernet_haendlerbund/adminhtml_system_config_form_renderer_select')->setOptions($helper->getLegalTextOptions()),
        ));

        $this->addColumn('destination', array(
            'label'    => Mage::helper('integernet_haendlerbund')->__('Destination'),
            'style'    => 'width:250px',
            'renderer' => Mage::app()->getLayout()->createBlock('integernet_haendlerbund/adminhtml_system_config_form_renderer_selectGroup')->setOptions($helper->getDestinationOptions()),
        ));

        $this->addColumn('mode', array(
            'label'    => Mage::helper('integernet_haendlerbund')->__('Mode'),
            'style'    => 'width:150px',
            'renderer' => Mage::app()->getLayout()->createBlock('integernet_haendlerbund/adminhtml_system_config_form_renderer_select')->setOptions($helper->getModeOptions()),
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('integernet_haendlerbund')->__('Add Row');

        parent::__construct();
    }


    /**
     * @return array
     */
    public function getArrayRows()
    {
        if (null !== $this->_arrayRowsCache) {
            return $this->_arrayRowsCache;
        }

        $result = array();
        /** @var Varien_Data_Form_Element_Abstract */
        $element = $this->getElement();

        if ($element->getValue() && is_array($element->getValue())) {
            foreach ($element->getValue() as $rowId => $row) {
                foreach ($row as $key => $value) {
                    if ($key == 'legal_text') {
                        $row['legal_text_' . $value] = 'selected="selected"';
                    } else if ($key == 'destination') {
                        $row['destination_' . $value] = 'selected="selected"';
                    } elseif ($key == 'mode') {
                        $row['mode_' . $value] = 'selected="selected"';
                    }
                }
                $row['_id'] = $rowId;
                $result[$rowId] = new Varien_Object($row);
            }
        }

        $this->_arrayRowsCache = $result;

        return $this->_arrayRowsCache;
    }


    /**
     * @return array
     */
    protected function _getOptions()
    {
        $options = array();
        foreach (Mage::app()->getWebsites() as $website) {
            $options[$website->getCode()] = $website->getName();
        }

        return $options;
    }
}
