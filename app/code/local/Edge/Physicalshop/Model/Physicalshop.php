<?php
/**
 * Physicalshop item model
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Model_Physicalshop extends Mage_Core_Model_Abstract
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('edge_physicalshop/physicalshop');
    }

    /**
     * If object is new adds creation date
     *
     * @return Edge_Physicalshop_Model_Physicalshop
     */
    protected function _beforeSave() {
        parent::_beforeSave();
        return $this;
    }    
}
