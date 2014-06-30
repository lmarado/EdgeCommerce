<?php
/**
 * Sales resource helper interface
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
interface Edge_Reports_Model_Resource_Helper_Interface
{
    /**
     * Update rating position
     *
     * @param string $aggregation One of Mage_Sales_Model_Resource_Report_Bestsellers::AGGREGATION_XXX constants
     * @param array $aggregationAliases
     * @param string $mainTable
     * @param string $aggregationTable
     * @return Mage_Sales_Model_Resource_Helper_Abstract
     */
    public function getTopsuppliersReportUpdateRatingPos($aggregation, $aggregationAliases,
        $mainTable, $aggregationTable
    );
    
    public function updateReportRatingPos($type, $column, $mainTable, $aggregationTable);
}
