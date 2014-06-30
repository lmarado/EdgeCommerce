<?php
/**
 * Supplier item resource model
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Model_Resource_Seller extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize connection and define main table and primary key
     */
    protected function _construct()
    {
        $this->_init('edge_supplier/supplier', 'supplier_id');
        $this->_isPkAutoIncrement = false;
    }
}
