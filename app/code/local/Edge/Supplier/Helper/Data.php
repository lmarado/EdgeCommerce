<?php
/**
 * Supplier Data helper
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Supplier Item instance for lazy loading
     *
     * @var Edge_Supplier_Model_Supplier
     */
    protected $_supplierItemInstance;

    /**
     * Return current seller item instance from the Registry
     *
     * @return Edge_Supplier_Model_Supplier
     */
    public function getSupplierItemInstance()
    {
        if (!$this->_supplierItemInstance) {
            $this->_supplierItemInstance = Mage::registry('supplier_item');

            if (!$this->_supplierItemInstance) {
                Mage::throwException($this->__('Supplier item instance does not exist in Registry'));
            }
        }

        return $this->_supplierItemInstance;
    }
}
