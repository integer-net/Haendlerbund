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
class IntegerNet_Haendlerbund_Adminhtml_Integernethaendlerbund_ApplyController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Insert legislative texts
     *
     * @return void
     */
    public function insertAction()
    {
        $body = '';
        try {
            $errors = Mage::getModel('integernet_haendlerbund/import')->run();

            if($errors) {
                $body .= '<div id="messages"><ul class="messages"><li class="error-msg"><ul>';
                foreach($errors as $error) {
                    $body .= '<li><span>' . $error . '</span></li>';
                }
                $body .= '</ul></li></ul></div>';
            } else {
                $body .= '<div id="messages"><ul class="messages"><li class="success-msg"><ul><li><span>' . Mage::helper('integernet_haendlerbund')->__('Import legal text success') . '</span></li></ul></li></ul></div>';
            }
        } catch(Exception $e) {
            $body .= '<div id="messages"><ul class="messages"><li class="error-msg"><ul><li><span>' . Mage::helper('integernet_haendlerbund')->__($e->getMessage()) . '</span></li></ul></li></ul></div>';
        }

        $this->getResponse()->setBody($body);
    }
}
