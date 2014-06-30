<?php

/**
 * Adminhtml report filter form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Edge_Report_Block_Adminhtml_Refresh_Statistics extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_refresh_statistics';
        $this->_blockGroup = 'edge_report';
        $this->_headerText = Mage::helper('reports')->__('Refresh Statistics');
        parent::__construct();
        $this->_removeButton('add');
    }
}
