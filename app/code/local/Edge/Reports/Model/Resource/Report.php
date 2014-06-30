<?php
/**
 * Supplier module observer
 *
 * @author Luís André Franco Marado
 */
class Edge_Report_Model_Resource_Report extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Resource initialization
     *
     */
    protected function _construct()
    {
        
    }

    /**
     * Set main table and idField
     *
     * @param string $table
     * @param string $field
     * @return Mage_Sales_Model_Resource_Report
     */
    public function init($table, $field = 'id')
    {
        $this->_init($table, $field);
        return $this;
    }
}
