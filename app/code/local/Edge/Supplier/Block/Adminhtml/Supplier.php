<?php
/**
 * Seller List admin grid container
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Block_Adminhtml_Supplier extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct() {
        $this->_blockGroup = 'edge_supplier';
        $this->_controller = 'adminhtml_supplier';
        $this->_headerText = Mage::helper('edge_supplier')->__('Manage Suppliers');
        
        parent::__construct();

        if (Mage::helper('edge_supplier/admin')->isActionAllowed('save')) {
            $this->_updateButton('add', 'label', Mage::helper('edge_supplier')->__('Add New Supplier'));
        } else {
            $this->_removeButton('add');
        }
    }
}