<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 */
class IntegerNet_Haendlerbund_Block_Adminhtml_System_Config_Insertlegislativetexts extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Set template to itself
     *
     * @return Mage_Adminhtml_Block_Customer_System_Config_Validatevat
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('integer_net/haendlerbund/insertlegislativetexts.phtml');
        }
        return $this;
    }

    /**
     * Unset some non-related element parameters
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $originalData = $element->getOriginalData();
        $this->addData(array(
            'button_label' => Mage::helper('integernet_haendlerbund')->__($originalData['button_label']),
            'html_id' => $element->getHtmlId(),
            'ajax_url' => Mage::getSingleton('adminhtml/url')->getUrl('*/insertlegislativetexts/insert')
        ));

        return $this->_toHtml();
    }
}