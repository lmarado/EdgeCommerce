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
     * @return Edge_Physicalshop_Block_Adminhtml_Grid
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
            'index'     => 'physicalshop_id',
        ));

        $this->addColumn('country', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Country'),
            'index'     => 'country',
        ));
        
        $this->addColumn('locale', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Locale'),
            'index'     => 'locale',
        ));

        $this->addColumn('address', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Address'),
            'index'     => 'address',
        ));
        
        $this->addColumn('postal_code', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Postal Code'),
            'index'     => 'postal_code',
        ));

        $this->addColumn('telephone', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Telephone'),
            'index'     => 'telephone',
        ));
        
        $this->addColumn('free_parking', array(
            'header'    => Mage::helper('edge_physicalshop')->__('Free Parking'),
            'index'     => 'free_parking',
        ));
        
        $this->addColumn('gps', array(
            'header'    => Mage::helper('edge_physicalshop')->__('GPS'),
            'index'     => 'gps',
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
