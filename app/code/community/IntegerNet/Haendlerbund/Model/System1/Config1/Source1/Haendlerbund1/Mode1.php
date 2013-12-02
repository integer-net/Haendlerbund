<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 */
class IntegerNet_Haendlerbund_Model_System_Config_Source_Haendlerbund_Mode
{
    /**
     * Retrieve option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array(
            array(
                'label' => 'Standard',
                'value' => 'default',
            ),
            array(
                'label' => 'Plain',
                'value' => 'plain',
            ),
            array(
                'label' => 'Classes',
                'value' => 'classes',
            ),
            array(
                'label' => 'Classes_head',
                'value' => 'classes_head',
            ),
        );
        return $options;
    }
}
