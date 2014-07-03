<?php
/**
 * Physical Shop Item block
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Item extends Mage_Core_Block_Template
{
    /**
     * Current Physical Shop item instance
     *
     * @var Edge_Physicalshop_Model_Physicalshop
     */
    protected $_item;

    /**
     * Return parameters for back url
     *
     * @param array $additionalParams
     * @return array
     */
    protected function _getBackUrlQueryParams($additionalParams = array())
    {
        return array_merge(array('p' => $this->getPage()), $additionalParams);
    }

    /**
     * Return URL to the news list page
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/', array('_query' => $this->_getBackUrlQueryParams()));
    }

}