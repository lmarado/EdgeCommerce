<?php
/**
 * Supplier Report controller
 *
 * @author Luís André Franco Marado
 */
class Edge_Reports_Adminhtml_Report_SupplierController extends Mage_Adminhtml_Controller_Report_Abstract
{
    /**
     * Add report/sales breadcrumbs
     *
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function _initAction()
    {
        parent::_initAction();
        $this->_addBreadcrumb(Mage::helper('edge_reports')->__('Supplier'), Mage::helper('edge_reports')->__('Supplier'));
        return $this;
    }
    
    /**
     * top supplier report action
     */
    public function topsuppliersAction() {
        $this->_title($this->__('Reports'))->_title($this->__('Supplier'))->_title($this->__('Top Suppliers'));

        $this->_showLastExecutionTime(Edge_Reports_Model_Flag::REPORT_TOPSUPPLIERS_FLAG_CODE, 'topsuppliers');

        $this->_initAction()
            ->_setActiveMenu('report/supplier/topsuppliers')
            ->_addBreadcrumb(Mage::helper('edge_reports')->__('Top Suppliers Report'), Mage::helper('edge_report')->__('Top Suppliers Report'));

        $gridBlock = $this->getLayout()->getBlock('adminhtml_supplier_topsuppliers.grid');
        $filterFormBlock = $this->getLayout()->getBlock('grid.filter.form');

        $this->_initReportAction(array(
            $gridBlock,
            $filterFormBlock
        ));

        $this->renderLayout();
    }

    /**
     * Export bestsuppliers report grid to CSV format
     */
    public function exportTopsuppliersCsvAction()
    {
        $fileName   = 'topsuppliers.csv';
        $grid       = $this->getLayout()->createBlock('edge_reports/adminhtml_supplier_topsuppliers_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     * Export bestsuppliers report grid to Excel XML format
     */
    public function exportTopsuppliersExcelAction()
    {
        $fileName   = 'topsuppliers.xml';
        $grid       = $this->getLayout()->createBlock('edge_reports/adminhtml_supplier_topsuppliers_grid');
        $this->_initReportAction($grid);
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    /**
     * Retrieve array of collection names by code specified in request
     *
     * @deprecated after 1.4.0.1
     * @return array
     */
    protected function _getCollectionNames()
    {
        return array();
    }

    /**
     * Refresh statistics for last 25 hours
     *
     * @deprecated after 1.4.0.1
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function refreshRecentAction()
    {
        return $this->_forward('refreshRecent', 'report_statistics');
    }

    /**
     * Refresh statistics for all period
     *
     * @deprecated after 1.4.0.1
     * @return Mage_Adminhtml_Report_SalesController
     */
    public function refreshLifetimeAction()
    {
        return $this->_forward('refreshLifetime', 'report_statistics');
    }

    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'topsuppliers':
                return $this->_getSession()->isAllowed('supplier/report/topsuppliers');
                break;
            default:
                return $this->_getSession()->isAllowed('supplier/report');
                break;
        }
    }
}
