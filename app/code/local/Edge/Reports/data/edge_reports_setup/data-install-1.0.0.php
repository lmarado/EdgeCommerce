<?php

/**
 * Supplier data installation script
 *
 * @author Luís André Franco Marado
 */

/**
 *  Create Sample Supplier User
 */
try {
    /*
    $user = Mage::getModel('admin/user')
                    ->setData(array(
                        'username' => 'SupplierUser',
                        'firstname' => 'Supplier',
                        'lastname' => 'User',
                        'email' => 'teste@edge.pt',
                        'password' => 'supplier12345',
                        'is_active' => 1
                    ))->save();
     */
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

/**
 * Create Supplier Role
 */
try {
    //create new role 
    $role = Mage::getModel("admin/roles")
            ->setName('Supplier')
            ->setRoleType('G')
            ->save();

    //give "all" privileges to role
    Mage::getModel("admin/rules")
            ->setRoleId($role->getId())
            ->setResources(array("admin/dashboard", "admin/sales", "admin/catalog", "admin/customer", "admin/promo", "admin/supplier", "admin/report"))
            ->saveRel();
} catch (Mage_Core_Exception $e) {
    echo $e->getMessage();
    exit;
} catch (Exception $e) {
    echo 'Error while saving role.';
    exit;
}

/**
 * Assign Supplier Role to Sample Supplier User
 */
try {
    /*
    $user = Mage::getModel("admin/user")->load('SupplierUser', 'username');
    $user->setRoleIds(array($role->getId()))
         ->setRoleUserId($user->getUserId())
         ->saveRelations();
     */
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

/**
 *  Create Suppliers Catalog Product Attribute
 */
try {
    /*
    $attribute = Mage::getModel('catalog/resource_eav_attribute')
                    ->setData(array(
                        //eav_attribute
                        'entity_type_id' => Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId(),
                        'attribute_code' => 'suppliers',
                        'attribute_model' => null,
                        'backend_model' => 'eav/entity_attribute_backend_array',
                        'backend_type' => 'varchar',
                        'backend_table' => null,
                        'frontend_model' => null,
                        'frontend_input' => 'multiselect',
                        'frontend_label' => 'Suppliers',
                        'frontend_class' => null,
                        'source_model' => null,
                        'is_required' => '0',
                        'is_user_defined' => '1',
                        'default_value' => null,
                        'is_unique' => '0',
                        'note' => null,	
                        //catalog_eav_attribute                        
                        'frontend_input_renderer' => null,
                        'is_global' => '2',
                        'is_visible' => '1',
                        'is_searchable' => '0',
                        'is_filterable' => '0',
                        'is_comparable' => '0',
                        'is_visible_on_front' => '0',
                        'is_html_allowed_on_front' => '1',
                        'is_used_for_price_rules' => '0',
                        'is_filterable_in_search' => '0',
                        'used_in_product_listing' => '0',
                        'used_for_sort_by' => '0',
                        'is_configurable' => '0',
                        'apply_to' => null,
                        'is_visible_in_advanced_search' => '0',
                        'position' => '0',
                        'is_wysiwyg_enabled' => '0',
                        'is_used_for_promo_rules' => '0',
                        //from example found... where does this come from?
                        //'default_value_text' => '',
                        //'default_value_yesno' => '0',
                        //'default_value_date' => '',
                        //'default_value_textarea' => '',
                    ))->save();
    $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
    $attribute_set_id=$setup->getAttributeSetId('catalog_product', 'Default');
    $attribute_group_id=$setup->getAttributeGroupId('catalog_product', $attribute_set_id, 'General');
    $attribute_id=$setup->getAttributeId('catalog_product', 'suppliers');
    $setup->addAttributeToSet($entityTypeId='catalog_product',$attribute_set_id, $attribute_group_id, $attribute_id);*/
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}


try{
    //insert into catalog_product_link_type(link_type_id,code) values(6,'supplier');
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
