<?php
/**
 * Top Supplier List admin grid
 *
 * @author Luís André Franco Marado
 */
class Edge_Report_Block_Adminhtml_Supplier_Topsuppliers_Grid extends Mage_Adminhtml_Block_Report_Grid_Abstract
{
    protected $_columnGroupBy = 'period';

    public function __construct() {
        parent::__construct();
        $this->setCountTotals(true);
    }

    public function getResourceCollectionName() {
        return 'edge_report/topsuppliers_collection';
    }

    protected function _prepareColumns() {
        $this->addColumn('period', array(
            'header'        => Mage::helper('edge_reports')->__('Period'),
            'index'         => 'period',
            'width'         => 100,
            'sortable'      => false,
            'period_type'   => $this->getPeriodType(),
            'renderer'      => 'adminhtml/report_sales_grid_column_renderer_date',
            'totals_label'  => Mage::helper('adminhtml')->__('Total'),
            'html_decorators' => array('nobr'),
        ));

        $this->addColumn('social_designation', array(
            'header'    => Mage::helper('edge_report')->__('Supplier Social Designation'),
            'index'     => 'social_designation',
            'type'      => 'string',
            'sortable'  => false
        ));

        if ($this->getFilterData()->getStoreIds()) {
            $this->setStoreIds(explode(',', $this->getFilterData()->getStoreIds()));
        }
        $currencyCode = $this->getCurrentCurrencyCode();

        $this->addColumn('product_price', array(
            'header'        => Mage::helper('edge_report')->__('Price'),
            'type'          => 'currency',
            'currency_code' => $currencyCode,
            'index'         => 'product_price',
            'sortable'      => false,
            'rate'          => $this->getRate($currencyCode),
        ));

        $this->addColumn('qty_ordered', array(
            'header'    => Mage::helper('edge_report')->__('Quantity Ordered'),
            'index'     => 'qty_ordered',
            'type'      => 'number',
            'total'     => 'sum',
            'sortable'  => false
        ));


        $this->addExportType('*/*/exportTopCsv', Mage::helper('adminhtml')->__('CSV'));
        $this->addExportType('*/*/exportTopExcel', Mage::helper('adminhtml')->__('Excel XML'));

        return parent::_prepareColumns();
    }
}
