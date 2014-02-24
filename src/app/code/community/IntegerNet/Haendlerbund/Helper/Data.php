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
 * Class IntegerNet_Haendlerbund_Helper_Data
 */
class IntegerNet_Haendlerbund_Helper_Data extends Mage_Core_Helper_Abstract
{


    /**
     * @param null $store
     *
     * @return bool
     */
    public function getScheduling($store = null)
    {
        return Mage::getStoreConfigFlag('integernet_haendlerbund/setting/scheduling', $store);
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiUrl($store = null)
    {
        return trim(Mage::getStoreConfig('integernet_haendlerbund/setting/api_uri', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getApiKey($store = null)
    {
        return trim(Mage::getStoreConfig('integernet_haendlerbund/setting/api_key', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getAccessToken($store = null)
    {
        return trim(Mage::getStoreConfig('integernet_haendlerbund/setting/access_token', $store));
    }


    /**
     * @param null $store
     *
     * @return string
     */
    public function getMapping($store = null)
    {
        $mapping = trim(Mage::getStoreConfig('integernet_haendlerbund/setting/mapping', $store));
        $mapping = @unserialize($mapping);

        return is_array($mapping) ? $mapping : array();
    }


    /**
     * @return array
     */
    public function getLegalTextOptions()
    {
        return array(
            '12766C46A8A' => $this->__('Allgemeine Geschaeftsbedingungen'),
            '12766C4A6BE' => $this->__('Rückgaberecht für Verbraucher'),
            '12766C53647' => $this->__('Widerrufsbelehrung'),
            '12766C58F26' => $this->__('Bedingungen für Zahlung und Versand'),
            '12766C5E204' => $this->__('Datenschutzerklärung'),
            '1293C20B491' => $this->__('Impressum'),
            '134CBB4D101' => $this->__('Batteriehinweise'),
        );
    }


    /**
     * @return array
     */
    public function getModeOptions()
    {
        return array(
            'default' => $this->__('Standard'),
            'plain'   => $this->__('Plain'),
            'classes' => $this->__('Classes'),
            //'classes_head' => $this->__('Head Classes'),
        );
    }


    /**
     * @return array
     */
    public function getDestinationOptions()
    {
        $options = array();

        $options['cms_page'] = array('label' => $this->__('CMS Pages'));

        foreach (Mage::getResourceModel('cms/page_collection')->setOrder('page_id', 'ASC') as $item) {
            $options['cms_page']['value'][] = array(
                'label' => sprintf('%s | %s', $item->getId(), $item->getTitle()),
                'value' => sprintf('cms/page#%s', $item->getId()),
            );
        }

        $options['cms_block'] = array('label' => $this->__('CMS Blocks'));

        foreach (Mage::getResourceModel('cms/block_collection')->setOrder('block_id', 'ASC') as $item) {
            $options['cms_block']['value'][] = array(
                'label' => sprintf('%s | %s', $item->getId(), $item->getTitle()),
                'value' => sprintf('cms/block#%s', $item->getId()),
            );
        }

        $options['agreement'] = array('label' => $this->__('Agreements'));

        foreach (Mage::getResourceModel('checkout/agreement_collection')->setOrder('agreement_id', 'ASC') as $item) {
            $options['agreement']['value'][] = array(
                'label' => sprintf('%s | %s', $item->getId(), $item->getName()),
                'value' => sprintf('checkout/agreement#%s', $item->getId()),
            );
        }

        return $options;
    }
}
