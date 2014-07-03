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
 * Creating table supplier
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('edge_supplier/supplier'))
    ->addColumn('supplier_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'identity' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Entity id')
    ->addColumn('social_designation', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
    ), 'Social Designation')
    ->addColumn('nif', Varien_Db_Ddl_Table::TYPE_INTEGER, 9, array(
        'nullable' => true,
        'default'  => null,
    ), 'NIF')
    ->addColumn('country', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'Country')
    ->addColumn('city', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'City')
    ->addColumn('address', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'Address')
    ->addColumn('postal_code', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'Postal Code')
    ->addColumn('telephone', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'Telephone')
    ->addColumn('mobile', Varien_Db_Ddl_Table::TYPE_TEXT, 63, array(
        'nullable' => true,
        'default'  => null,
    ), 'Mobile')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
        'default'  => null,
    ), 'Creation Time')
    ->addForeignKey(
            $installer->getFkName(
                    'edge_supplier/supplier',
                    'supplier_id',
                    'admin/user',
                    'user_id'
            ),
            'supplier_id', $installer->getTable('admin/user'), 'user_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, 
            Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Supplier item');

$installer->getConnection()->createTable($table);
