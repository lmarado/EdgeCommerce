<?php
/**
 * Supplier installation script
 *
 * @author Luís André Franco Marado
 */

/**
 * @var $installer Mage_Core_Model_Resource_Setup
 */
$installer = $this;

/**
 * Create table 'edge_reports/topsuppliers_aggregated_daily'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('edge_reports/topsuppliers_aggregated_daily'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('period', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'Period')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        ), 'Store Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Product Id')
    ->addColumn('supplier_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Supplier Id')
    ->addColumn('social_designation', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Social Designation')
    ->addColumn('supplier_sales', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Supplier Sales')
    ->addColumn('qty_ordered', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Qty Ordered')
    ->addColumn('rating_pos', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Rating Pos')
    ->addIndex(
        $installer->getIdxName(
            'edge_reports/topsuppliers_aggregated_daily',
            array('period', 'store_id', 'supplier_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('period', 'store_id', 'supplier_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_daily', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_daily', array('product_id')),
        array('product_id'))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_daily', array('supplier_id')),
        array('supplier_id'))
    ->addForeignKey($installer->getFkName('edge_reports/topsuppliers_aggregated_daily', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_daily',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_daily',
            'supplier_id',
            'edge_reports/supplier',
            'supplier_id'
        ),
        'supplier_id', $installer->getTable('edge_reports/supplier'), 'supplier_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Suppliers Top Aggregated Daily');
$installer->getConnection()->createTable($table);

/**
 * Create table 'edge_reports/topsuppliers_aggregated_monthly'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('edge_reports/topsuppliers_aggregated_monthly'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('period', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'Period')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        ), 'Store Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Product Id')
    ->addColumn('supplier_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Supplier Id')
    ->addColumn('social_designation', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Social Designation')
    ->addColumn('supplier_sales', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Supplier Sales')
    ->addColumn('qty_ordered', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Qty Ordered')
    ->addColumn('rating_pos', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Rating Pos')
    ->addIndex(
        $installer->getIdxName(
            'edge_reports/topsuppliers_aggregated_monthly',
            array('period', 'store_id', 'supplier_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('period', 'store_id', 'supplier_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_monthly', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_monthly', array('product_id')),
        array('product_id'))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_monthly', array('supplier_id')),
        array('supplier_id'))
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_monthly',
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_monthly',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_monthly',
            'supplier_id',
            'edge_reports/supplier',
            'supplier_id'
        ),
        'supplier_id', $installer->getTable('edge_reports/supplier'), 'supplier_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Suppliers Top Aggregated Monthly');
$installer->getConnection()->createTable($table);

/**
 * Create table 'edge_reports/topsuppliers_aggregated_yearly'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('edge_reports/topsuppliers_aggregated_yearly'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('period', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
        ), 'Period')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        ), 'Store Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Product Id')
    ->addColumn('supplier_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Supplier Id')
    ->addColumn('social_designation', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => true,
        ), 'Social Designation')
    ->addColumn('supplier_sales', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Supplier Sales')
    ->addColumn('qty_ordered', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Qty Ordered')
    ->addColumn('rating_pos', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Rating Pos')
    ->addIndex(
        $installer->getIdxName(
            'edge_reports/topsuppliers_aggregated_yearly',
            array('period', 'store_id', 'supplier_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('period', 'store_id', 'supplier_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_yearly', array('store_id')),
        array('store_id'))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_yearly', array('product_id')),
        array('product_id'))
    ->addIndex($installer->getIdxName('edge_reports/topsuppliers_aggregated_yearly', array('supplier_id')),
        array('supplier_id'))
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_yearly',
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_yearly',
            'product_id',
            'catalog/product',
            'entity_id'
        ),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName(
            'edge_reports/topsuppliers_aggregated_yearly',
            'supplier_id',
            'edge_reports/supplier',
            'supplier_id'
        ),
        'supplier_id', $installer->getTable('edge_reports/supplier'), 'supplier_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Suppliers Top Aggregated Yearly');
$installer->getConnection()->createTable($table);

/**
 * Alter table order item
 */
$installer->getConnection()
    ->addColumn(
            $installer->getTable('sales_flat_order_item'), 
            'supplier_id', 
            Varien_Db_Ddl_Table::TYPE_INTEGER, 
            null, 
            array(
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '1',
                ),
            'Supplier Id')
    ->addIndex($installer->getIdxName('sales_flat_order_item', array('supplier_id')),
        array('supplier_id'))
    ->addForeignKey($installer->getFkName('sales_flat_order_item', 'supplier_id', 'edge_reports/supplier', 'supplier_id'),
        'supplier_id', $installer->getTable('edge_reports/supplier'), 'supplier_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
