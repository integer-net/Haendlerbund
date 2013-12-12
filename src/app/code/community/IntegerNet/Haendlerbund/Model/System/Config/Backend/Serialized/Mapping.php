<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @copyright  Copyright (c) 2012-2013 integer_net GmbH (http://www.integer-net.de/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 * @author     Viktor Franz <vf@integer-net.de>
 */

/**
 * Enter description here ...
 */
class IntegerNet_Haendlerbund_Model_System_Config_Backend_Serialized_Mapping extends Mage_Adminhtml_Model_System_Config_Backend_Serialized
{
    /**
     *
     */
    protected function _beforeSave()
    {
        $value = $this->getValue();
        $valueSorted = array();

        if (is_array($value)) {
            foreach (Mage::helper('integernet_haendlerbund')->getLegalTextOptions() as $legalText => $_) {
                foreach ($value as $key => $row) {
                    if (is_array($row) && array_key_exists('legal_text', $row) && $row['legal_text'] == $legalText) {
                        $valueSorted[$key] = $row;
                    }
                }
            }
        }

        $this->setValue($valueSorted);

        parent::_beforeSave();
    }
}
