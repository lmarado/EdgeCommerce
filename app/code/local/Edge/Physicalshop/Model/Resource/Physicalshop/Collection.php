<?php
/**
 * Physicalshop collection
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Model_Resource_Physicalshop_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define collection model
     */
    protected function _construct() {
        $this->_init('edge_physicalshop/physicalshop');
    }
}
