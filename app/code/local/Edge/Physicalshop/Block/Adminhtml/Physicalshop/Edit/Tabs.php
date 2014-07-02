<?php
/**
 * Physicalshop List admin edit form tabs block
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Adminhtml_Physicalshop_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setTitle(Mage::helper('edge_physicalshop')->__('Physical Shop Item Info'));
    }
}
