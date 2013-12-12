<?php
/**
 * @category   IntegerNet
 * @package    IntergerNet_Haendlerbund
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software Licence 3.0 (OSL-3.0)
 * @author     Soeren Zorn <sz@integer-net.de>
 */
class IntegerNet_Haendlerbund_Model_System_Config_Source_Haendlerbund_CmsSites
{
    /**
     * Retrieve option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = array();
        $options[] = array(
            'label' => 'Nicht verwenden',
            'value' => 0,
        );
        $cmsPagesOptions = array();
        $cmsPages = Mage::getModel('cms/page')->getCollection();
        foreach($cmsPages as $cmsPage) {
            $cmsPagesOptions[] = array(
                'label' => $cmsPage->getTitle(),
                'value' => 'page_'.$cmsPage->getId(),
            );
        }
        $cmsBlocksOptions = array();
        $cmsBlocks = Mage::getModel('cms/block')->getCollection();
        foreach($cmsBlocks as $cmsBlock) {
            $cmsBlocksOptions[] = array(
                'label' => $cmsBlock->getTitle(),
                'value' => 'block_'.$cmsBlock->getId(),
            );
        }
        $options[] = array(
            'label' => 'CMS Pages',
            'value' => $cmsPagesOptions,
        );
        $options[] = array(
            'label' => 'CMS Blocks',
            'value' => $cmsBlocksOptions,
        );
        return $options;
    }
}
