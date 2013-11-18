<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 */
class IntegerNet_Haendlerbund_Adminhtml_InsertlegislativetextsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Insert legislative texts
     *
     * @return void
     */
    public function insertAction()
    {
        Mage::getModel('integernet_haendlerbund/insertLegislativeTexts')->run(true);
        $this->getResponse()->setBody(1);
    }

}
