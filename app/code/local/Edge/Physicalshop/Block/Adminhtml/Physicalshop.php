<?php
/**
 * Physicalshop List admin grid container
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Adminhtml_Physicalshop extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Block constructor
     */
    public function __construct() {
        $this->_blockGroup = 'edge_physicalshop';
        $this->_controller = 'adminhtml_physicalshop';
        $this->_headerText = Mage::helper('edge_physicalshop')->__('Manage Physical Shop');
        
        parent::__construct();

        if (Mage::helper('edge_physicalshop/admin')->isActionAllowed('save')) {
            $this->_updateButton('add', 'label', Mage::helper('edge_physicalshop')->__('Add New Physical Shop'));
        } else {
            $this->_removeButton('add');
        }
    }
}