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
 * Class IntegerNet_Haendlerbund_Model_Import
 */
class IntegerNet_Haendlerbund_Model_Import
{


    /**
     * @var IntegerNet_Haendlerbund_Helper_Data
     */
    protected $_helper;

    /**
     *
     */
    protected $_cache = array();


    /**
     *
     */
    public function __construct()
    {
        $this->_helper = Mage::helper('integernet_haendlerbund');
    }


    /**
     * @param Mage_Cron_Model_Schedule $cron
     *
     * @return $this
     */
    public function schedulingRun(Mage_Cron_Model_Schedule $cron)
    {
        $messages = array();

        foreach (Mage::app()->getStores() as $store) {
            if ($this->_helper->getScheduling($store)) {
                $errors = $this->run(array($store));
                $messages = array_merge($messages, $errors);
            }
        }

        if ($messages) {
            $messages = implode("\n", $messages);
            $cron->setMessages($messages);
            Mage::log(sprintf("%s\n%s", __METHOD__, $messages));
        }

        return $this;
    }


    /**
     * @param array $stores
     *
     * @return array
     */
    public function run(array $stores = null)
    {
        if ($stores === null) {
            $stores = Mage::app()->getStores();
        }

        $errors = array();
        $apiUri = $this->_helper->getApiUrl();
        $apiKey = $this->_helper->getApiKey();

        foreach ($stores as $store) {

            if ($this->_helper->getIsActive($store)) {
                if ($accessToken = $this->_helper->getAccessToken($store)) {

                    if ($maps = $this->_helper->getMapping($store)) {

                        foreach ($maps as $map) {

                            $map = new Varien_Object($map);

                            $requestKey = sprintf('request_%s', md5($accessToken . $map->getLegalText() . $map->getMode()));
                            $updateKey = sprintf('update_%s', md5($accessToken . $map->getLegalText() . $map->getMode() . $map->getDestination()));

                            if (!array_key_exists($requestKey, $this->_cache)) {

                                try {
                                    $this->_cache[$requestKey] = $this->_request($apiUri, $apiKey, $accessToken, $map->getLegalText(), $map->getMode());
                                } catch (Exception $s) {
                                    $errors[] = $this->_helper->__('[Store Id: %s] %s', Mage::app()->getStore($store)->getId(), $s->getMessage());
                                }
                            }

                            if (array_key_exists($requestKey, $this->_cache) && !array_key_exists($updateKey, $this->_cache)) {

                                try {
                                    $this->_updateDestination($map->getDestination(), $this->_cache[$requestKey]);
                                    $this->_cache[$updateKey] = true;
                                } catch (Exception $s) {
                                    $errors[] = $this->_helper->__('[Store Id: %s] %s', Mage::app()->getStore($store)->getId(), $s->getMessage());
                                }
                            }
                        }
                    } else {
                        $errors[] = $this->_helper->__('[Store Id: %s] Mapping is undefined.', Mage::app()->getStore($store)->getId());
                    }
                } else {
                    $errors[] = $this->_helper->__('[Store Id: %s] Access Token is undefined.', Mage::app()->getStore($store)->getId());
                }
            }
        }

        return $errors;
    }


    /**
     * @param string $apiUri
     * @param string $apiKey
     * @param string $accessToken
     * @param string $legalText
     * @param string $mode
     *
     * @return string
     */
    protected function _request($apiUri, $apiKey, $accessToken, $legalText, $mode)
    {
        $uri = sprintf($apiUri, $apiKey, $accessToken, $legalText, $mode);
        $client = new Zend_Http_Client(sprintf($apiUri, $apiKey, $accessToken, $legalText, $mode));
        $response = $client->request();

        $legalTextLabel = $this->_helper->getLegalTextOptions();
        $legalTextLabel = $legalTextLabel[$legalText];

        $body = trim($response->getBody());

        if ($response->getStatus() != 200) {
            Mage::throwException($this->_helper->__('Request error for URL: "%s"', $uri));
        } elseif ($body == 'DOCUMENT_NOT_AVAILABLE') {
            Mage::throwException($this->_helper->__('Document "%s" (%s) not available', $legalTextLabel, $legalText));
        } elseif ($body == 'WRONG_API_KEY') {
            Mage::throwException($this->_helper->__('Wrong API key: "%s"', $apiKey));
        } elseif ($body == 'SHOP_NOT_FOUND') {
            Mage::throwException($this->_helper->__('Shop not found for Access Token: "%s"', $accessToken));
        } elseif (strlen($body) == 0) {
            Mage::throwException($this->_helper->__('Empty response for: "%s" (%s)', $legalTextLabel, $legalText));
        }

        return $body;
    }


    /**
     * @param string $destination
     * @param string $content
     *
     * @return $this
     */
    protected function _updateDestination($destination, $content)
    {
        $destination = explode('#', $destination);
        $modelClass = array_shift($destination);
        $entityId = array_shift($destination);

        $model = Mage::getModel($modelClass);
        $model->load($entityId);

        if ($model->getId()) {
            if ($modelClass == 'cms/page') {
                $model->setData('content', $content);
                $model->setData('stores', $model->getData('store_id'));
                $model->save();
            } elseif ($modelClass == 'cms/block') {
                $model->setData('content', $content);
                $model->save();
            } elseif ($modelClass == 'checkout/agreement') {
                $model->setData('content', $content);
                $model->save();
            } else {
                Mage::throwException($this->_helper->__('Unknown model: "%s"', $model));
            }
        } else {
            Mage::throwException($this->_helper->__('Unknown model entity: "%s" (%s)', $entityId, $model));
        }

        return $this;
    }
}
