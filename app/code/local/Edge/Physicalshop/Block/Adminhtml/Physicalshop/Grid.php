<?php
/**
 * Physicalshop List admin grid
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Adminhtml_Physicalshop_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Init Grid default properties
     *
     */
    public function __construct() {
        parent::__construct();
        $this->setId('physicalshop_list_grid');
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection for Grid
     *
     * @return Edge_Supplier_Block_Adminhtml_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('edge_physicalshop/physicalshop')->getResourceCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare Grid columns
     *
     * @return Mage_Adminhtml_Block_Catalog_Search_Grid
     */
    protected function _prepareColumns() {
        $this->addColumn('physicalshop_id', array(
            'header'    => Mage::helper('edge_physicalshop')->__('ID'),
            'width'     => '50px',
            'index'     => 'supplier_id',
        ));

        $this->addColumn('social_designation', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Social Designation'),
            'index'     => 'social_designation',
        ));

        $this->addColumn('telephone', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Telephone'),
            'index'     => 'telephone',
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Mobile'),
            'index'     => 'mobile',
        ));
        
        $this->addColumn('created_at', array(
            'header'   => Mage::helper('edge_physicalshop')->__('Created'),
            'sortable' => true,
            'width'    => '170px',
            'index'    => 'created_at',
            'type'     => 'datetime',
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('edge_physicalshop')->__('Action'),
                'width'     => '100px',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(array(
                    'caption' => Mage::helper('edge_physicalshop')->__('Edit'),
                    'url'     => array('base' => '*/*/edit'),
                    'field'   => 'id'
                )),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'physicalshop',
        ));

        return parent::_prepareColumns();
    }

    /**
     * Return row URL for js event handlers
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Grid url getter
     *
     * @return string current grid url
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
