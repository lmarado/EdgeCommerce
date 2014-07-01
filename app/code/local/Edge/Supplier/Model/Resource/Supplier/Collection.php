<?php
/**
 * Supplier collection
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Model_Resource_Supplier_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define collection model
     */
    protected function _construct() {
        $this->_init('edge_supplier/supplier');
    }
}
