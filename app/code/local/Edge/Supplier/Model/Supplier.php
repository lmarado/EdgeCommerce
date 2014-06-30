<?php
/**
 * Supplier item model
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Model_Supplier extends Mage_Core_Model_Abstract
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('edge_supplier/supplier');
    }

    /**
     * If object is new adds creation date
     *
     * @return Edge_Supplier_Model_Supplier
     */
    protected function _beforeSave() {
        parent::_beforeSave();
        return $this;
    }    
}
