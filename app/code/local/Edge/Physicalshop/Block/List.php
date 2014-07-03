<?php
/**
 * Physical Shop List block
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_List extends Mage_Core_Block_Template
{
    /**
     * Physical Shop collection
     *
     * @var Edge_Physicalshop_Model_Resource_Physicalshop_Collection
     */
    protected $_physicalshopCollection = null;

    /**
     * Retrieve Physical Shop collection
     *
     * @return Edge_Physicalshop_Model_Resource_Physicalshop_Collection
     */
    protected function _getCollection()
    {
        return  Mage::getResourceModel('edge_physicalshop/physicalshop_collection');
    }

    /**
     * Retrieve prepared Physical Shop collection
     *
     * @return Edge_Physicalshop_Model_Resource_Physicalshop_Collection
     */
    public function getCollection()
    {
        if (is_null($this->_physicalshopCollection)) {
            $this->_physicalshopCollection = $this->_getCollection();
            $this->_physicalshopCollection->prepareForList($this->getCurrentPage());
        }

        return $this->_physicalshopCollection;
    }

    /**
     * Return URL to item's view page
     *
     * @param Edge_Physicalshop_Model_Physicalshop $physicalshopItem
     * @return string
     */
    public function getItemUrl($physicalshopItem)
    {
        return $this->getUrl('*/*/view', array('id' => $physicalshopItem->getId()));
    }
    
    /**
     * Fetch the current page for the news list
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->getData('current_page') ? $this->getData('current_page') : 1;
    }

    /**
     * Get a pager
     *
     * @return string|null
     */
    public function getPager()
    {
        $pager = $this->getChild('physicalshop_list_pager');
        if ($pager) {
            $physicalshopPerPage = Mage::helper('edge_physicalshop')->getPhysicalshopPerPage();
            $pager->setAvailableLimit(array($physicalshopPerPage => $physicalshopPerPage));
            $pager->setTotalNum($this->getCollection()->getSize());
            $pager->setCollection($this->getCollection());
            $pager->setShowPerPage(true);

            return $pager->toHtml();
        }

        return null;
    }
}