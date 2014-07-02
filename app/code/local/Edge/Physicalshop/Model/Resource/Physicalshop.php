<?php
/**
 * Physicalshop item resource model
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Model_Resource_Physicalshop extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize connection and define main table and primary key
     */
    protected function _construct()
    {
        $this->_init('edge_physicalshop/physicalshop', 'physicalshop_id');
        $this->_isPkAutoIncrement = false;
    }
}
