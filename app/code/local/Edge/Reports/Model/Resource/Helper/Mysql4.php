<?php
/**
 * Sales Mysql resource helper model
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Edge_Reports_Model_Resource_Helper_Mysql4 extends Mage_Core_Model_Resource_Helper_Mysql4
    implements Edge_Reports_Model_Resource_Helper_Interface
{
    /**
     * Update rating position
     *
     * @param string $aggregation One of Mage_Sales_Model_Resource_Report_Bestsuppliers::AGGREGATION_XXX constants
     * @param array $aggregationAliases
     * @param string $mainTable
     * @param string $aggregationTable
     * @return Mage_Sales_Model_Resource_Helper_Abstract
     */
    public function getTopsuppliersReportUpdateRatingPos($aggregation, $aggregationAliases,
        $mainTable, $aggregationTable
    ) {
        /** @var $reportsResourceHelper Mage_Reports_Model_Resource_Helper_Interface */
        $reportsResourceHelper = Mage::getResourceHelper('edge_reports');

        if ($aggregation == $aggregationAliases['monthly']) {
            $reportsResourceHelper
                ->updateReportRatingPos('month', 'qty_ordered', $mainTable, $aggregationTable);
        } elseif ($aggregation == $aggregationAliases['yearly']) {
            $reportsResourceHelper
                ->updateReportRatingPos('year', 'qty_ordered', $mainTable, $aggregationTable);
        } else {
            $reportsResourceHelper
                ->updateReportRatingPos('day', 'qty_ordered', $mainTable, $aggregationTable);
        }

        return $this;
    }
    
    /**
     * Update rating position
     *
     * @param string $type day|month|year
     * @param string $column
     * @param string $mainTable
     * @param string $aggregationTable
     * @return Mage_Core_Model_Resource_Helper_Mysql4
     */
    public function updateReportRatingPos($type, $column, $mainTable, $aggregationTable) {
        $adapter         = $this->_getWriteAdapter();
        $periodSubSelect = $adapter->select();
        $ratingSubSelect = $adapter->select();
        $ratingSelect    = $adapter->select();

        switch ($type) {
            case 'year':
                $periodCol = $adapter->getDateFormatSql('t.period', '%Y-01-01');
                break;
            case 'month':
                $periodCol = $adapter->getDateFormatSql('t.period', '%Y-%m-01');
                break;
            default:
                $periodCol = 't.period';
                break;
        }

        $columns = array(
            'period'             => 't.period',
            'store_id'           => 't.store_id',
            'supplier_id'          => 't.supplier_id',
            'product_id'         => 't.product_id',
            'social_designation' => 't.social_designation',
            'product_price'      => 't.product_price',
        );

        if ($type == 'day') {
            $columns['id'] = 't.id';  // to speed-up insert on duplicate key update
        }

        $cols = array_keys($columns);
        $cols['total_qty'] = new Zend_Db_Expr('SUM(t.' . $column . ')');
        $periodSubSelect->from(array('t' => $mainTable), $cols)
            ->group(array('t.store_id', $periodCol, 't.product_id'))
            ->order(array('t.store_id', $periodCol, 'total_qty DESC'));

        $cols = $columns;
        $cols[$column] = 't.total_qty';
        $cols['rating_pos']  = new Zend_Db_Expr(
            "(@pos := IF(t.`store_id` <> @prevStoreId OR {$periodCol} <> @prevPeriod, 1, @pos+1))");
        $cols['prevStoreId'] = new Zend_Db_Expr('(@prevStoreId := t.`store_id`)');
        $cols['prevPeriod']  = new Zend_Db_Expr("(@prevPeriod := {$periodCol})");
        $ratingSubSelect->from($periodSubSelect, $cols);

        $cols               = $columns;
        $cols['period']     = $periodCol;
        $cols[$column]      = 't.' . $column;
        $cols['rating_pos'] = 't.rating_pos';
        $ratingSelect->from($ratingSubSelect, $cols);

        $sql = $ratingSelect->insertFromSelect($aggregationTable, array_keys($cols));
        $adapter->query("SET @pos = 0, @prevStoreId = -1, @prevPeriod = '0000-00-00'");

        $adapter->query($sql);

        return $this;
    }
}
