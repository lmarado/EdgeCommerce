<?php
/**
 * Physicalshop Data helper
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Path to store config if front-end output is enabled
     *
     * @var string
     */
    const XML_PATH_ENABLED            = 'physicalshop/view/enabled';

    /**
     * Path to store config where count of news posts per page is stored
     *
     * @var string
     */
    const XML_PATH_ITEMS_PER_PAGE     = 'physicalshop/view/items_per_page';
    
    /**
     * Physicalshop Item instance for lazy loading
     *
     * @var Edge_Physicalshop_Model_Supplier
     */
    protected $_physicalshopItemInstance;
    
    /**
     * Checks whether news can be displayed in the frontend
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return boolean
     */
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ENABLED, $store);
    }

    /**
     * Return the number of items per page
     *
     * @param integer|string|Mage_Core_Model_Store $store
     * @return int
     */
    public function getPhysicalshopPerPage($store = null)
    {
        return abs((int)Mage::getStoreConfig(self::XML_PATH_ITEMS_PER_PAGE, $store));
    }
    
    /**
     * Return current physicalshop item instance from the Registry
     *
     * @return Edge_Physicalshop_Model_Supplier
     */
    public function getPhysicalshopItemInstance()
    {
        if (!$this->_physicalshopItemInstance) {
            $this->_physicalshopItemInstance = Mage::registry('physicalshop_item');

            if (!$this->_physicalshopItemInstance) {
                Mage::throwException($this->__('Physical Shop item instance does not exist in Registry'));
            }
        }

        return $this->_physicalshopItemInstance;
    }
}
