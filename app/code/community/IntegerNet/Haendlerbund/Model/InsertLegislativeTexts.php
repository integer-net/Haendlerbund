<?php

/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 */

class IntegerNet_Haendlerbund_Model_InsertLegislativeTexts extends Mage_Core_Model_Abstract
{
	public function run()
    {
        $apiKey = Mage::getStoreConfig('integernet_haendlerbund/rechtstexte/api_key');
        $accessToken = Mage::getStoreConfig('integernet_haendlerbund/rechtstexte/access_token');
        $textKeys = array(
            'allgemeine_geschaeftsbedingungen'      => '12766C46A8A',
            'rueckgaberecht_fuer_verbraucher'       => '12766C4A6BE',
            'widerrufsbelehrung'                    => '12766C53647',
            'bedingungen_fuer_zahlung_und_versand'  => '12766C58F26',
            'datenschutzerklaerung'                 => '12766C5E204',
            'impressum'                             => '1293C20B491',
            'batteriehinweise'                      => '134CBB4D101',
        );
        foreach($textKeys as $identifier => $textKey) {
            $id = $textKeys[Mage::getStoreConfig('integernet_haendlerbund/rechtstexte/'.$identifier)];
            if($id != 0) {
                $uri = 'https://www.hbintern.de/www/hbm/api/live_rechtstexte.htm?APIkey='.$apiKey.'&did='.$textKey.'&AccessToken='.$accessToken;
                $client = new Zend_Http_Client($uri);
                $response = $client->request();
                if(stristr($id,'page')) {
                    $id = str_replace('page_','',$id);
                    $model = Mage::getModel('cms/page')->load($id);
                }
                else {
                    $id = str_replace('block_','',$id);
                    $model = Mage::getModel('cms/page')->load($id);
                }
                $model->setContent($response);
                $model->save();
            }
        }
    }
}
