<?php
/**
 * Supplier List admin edit form tabs block
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Block_Adminhtml_Supplier_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize tabs and define tabs block settings
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('edge_supplier')->__('Supplier Item Info'));
    }
}
