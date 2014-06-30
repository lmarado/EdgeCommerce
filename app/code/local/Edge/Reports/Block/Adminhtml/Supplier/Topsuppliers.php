<?php
/**
 * Top Suppliers List admin grid
 *
 * @author Luís André Franco Marado
 */
class Edge_Report_Block_Adminhtml_Supplier_Topsuppliers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_supplier_topsuppliers';
        $this->_blockGroup = 'edge_report';
        $this->_headerText = Mage::helper('edge_report')->__('Top Suppliers Report');
        parent::__construct();
        $this->setTemplate('report/grid/container.phtml');
        $this->_removeButton('add');
        $this->addButton('filter_form_submit', array(
            'label'     => Mage::helper('reports')->__('Show Report'),
            'onclick'   => 'filterFormSubmit()'
        ));
    }

    public function getFilterUrl()
    {
        $this->getRequest()->setParam('filter', null);
        return $this->getUrl('*/*/topsuppliers', array('_current' => true));
    }
}
