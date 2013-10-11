<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 */

class IntegerNet_Haendlerbund_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getConfig()
    {
        Mage::getStoreConfig('haendlerbung/rechtstexte/rechtstext');
    }
}