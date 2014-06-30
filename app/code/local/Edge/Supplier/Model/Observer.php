<?php
/**
 * Supplier module observer
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Model_Observer
{
    /**
     * Event after save admin user item on backend
     * 
     * If saved admin/user has the Supplier Role, creates the Supplier if it doesn't
     * exist. Otherwise makes sure there's no Supplier linked to the admin/user 
     * saved deleting it in case it exists.
     *
     * @param Varien_Event_Observer $observer
     */
    public function afterAdminUserSave(Varien_Event_Observer $observer) {
        $role = Mage::getModel("admin/roles")->load('Supplier', 'role_name');
        $collection = Mage::getModel('edge_supplier/supplier')->getCollection()
                ->addFieldToFilter('supplier_id', $observer->getEvent()->getObject()->getUserId())
                ->getFirstItem();
        if (in_array($role->getId(), $observer->getEvent()->getObject()->getData('roles'))){
            if(!$collection->getId()) {
                $model = Mage::getModel('edge_supplier/supplier');
                $dataRow = array('supplier_id'  => $observer->getEvent()->getObject()->getUserId(),
                                 'created_at' => Varien_Date::now());
                $model->setData($dataRow)->setOrigData()->save();
                
                //$this->addAttributeOption('product_supplier', $observer->getEvent()->getObject()->getUsername());
                //$this->addAttributeOption('suppliers', $observer->getEvent()->getObject()->getUsername());
            }
        }else{
            if($collection->getId()){
                $model = Mage::getModel('edge_supplier/supplier');
                $model->load($observer->getEvent()->getObject()->getUserId())->delete();
            }
        }        
    }
    
    public function beforeAdminUserDelete(Varien_Event_Observer $observer) {
        $model = Mage::getModel('edge_supplier/supplier');
        $model->load($observer->getEvent()->getObject()->getUserId())->delete();
    }
    
    public function beforeSalesOrderSave(Varien_Event_Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        Mage::log($order, null, 'edge.log');
    }
    
    /*
     * 1. Verifica se produto a guardar está associado ao product_supplier Admin
     * 2. Se sim verifica se produto a guardar é um duplicado
     * 2.1. Se sim faz loop aos suppliers que estão associados ao produto
     * 2.1.1. Verifica se produto para o supplier existe
     * 2.1.1.1. Não existindo atualiza ao produto duplicado alguns atributos
     * 2.1.1.2. Fecha o loop
     * 2.2. Se não faz loop aos suppliers que estão associados ao produto
     * 2.2.1.  
     * 
     * 3. Não existindo um produto para esse supplier atualiza alguns atributos e fecha o ciclo
     */
    public function beforeCatalogProductSave(Varien_Event_Observer $observer) {
        $product = $observer->getProduct();
        if ($product->getAttributeText('product_supplier') == 'Admin'){
            if ($product->getIsDuplicate()) {
                $this->updateDuplicateBeforeSave($product);
            } else {
                $this->createOrUpdateSupplierProducts($product);
                $this->removeOldSupplierProducts($product);
                $product->setSupplierLinkData($this->getSupplierLinkData($product));
            }
        } else {
            
        }
    }

    private function updateProduct($product, $productSupplier){
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        //Settings
        $productSupplier->setAttributeSetId($product->getAttributeSetId());
        $productSupplier->setTypeId($product->getTypeId()); 
        $productSupplier->setWebsiteIDs($product->getWebsiteIDs());
        //General
        $productSupplier->setName($product->getName());
        $productSupplier->setDescription($product->getDescription());
        $productSupplier->setShortDescription($product->getShortDescription());
        //$productSupplier->setSku($product->getSku() . '-' . $supplier);
        $productSupplier->setWeight($product->getWeight()); 
        $productSupplier->setStatus($product->getStatus()); 
        //$productSupplier->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH); 
        $productSupplierOption = array_filter(
                Mage::getModel('eav/config')->getAttribute('catalog_product', 'product_supplier')->getSource()->getAllOptions(), 
                function($el) use ($supplier) {
                    return ($el['label'] === $supplier);
                });
        $productSupplier->setProductSupplier($productSupplierOption[key($productSupplierOption)]['value']);
        //Categories
        $productSupplier->setCategoryIds($product->getCategoryIds());
        //Price
        $productSupplier->setPrice($product->getPrice());
        $productSupplier->setTaxClassId($product->getTaxClassId());
        //Inventory
        $productSupplier->setStockData($product->getStockData());
        //Save
        //$productSupplier->save();
    }    

    private function updateDuplicateBeforeSave($product){
        foreach ($product->getSuppliers() as $supplier) {
            $supplierOption = $this->getSupplierAttributesOptions('suppliers', $supplier, 'value');
            if (!Mage::getModel('catalog/product')->loadByAttribute('sku', $this->getSupplierProductSku($product, $supplierOption))) {
                $productSupplierOption = $this->getSupplierAttributesOptions('product_supplier', $supplierOption[key($supplierOption)]['label'], 'label');
                $product->setSku($this->getSupplierProductSku($product, $supplierOption))
                        ->setProductSupplier($productSupplierOption[key($productSupplierOption)]['value'])
                        ->setSuppliers(null);
                continue;
            }
        }
    }
    
    private function createOrUpdateSupplierProducts($product){
        foreach ($product->getSuppliers() as $supplier) {
            $supplierOption = $this->getSupplierAttributesOptions('suppliers', $supplier, 'value');
            if (Mage::getModel('catalog/product')->loadByAttribute('sku', $this->getSupplierProductSku($product, $supplierOption))) {
                //$this->updateProduct($product, $productSupplier);
            } else {
                $product->duplicate();
            }
        }
    }
     
    private function removeOldSupplierProducts($product){
        $suppliersOptions = null;
        foreach ($product->getSuppliers() as $supplier) {
            if($suppliersOptions) {
                array_push($suppliersOptions, $this->getSupplierAttributesOptions('suppliers', $supplier, 'value'));
            }else{
                $suppliersOptions = $this->getSupplierAttributesOptions('suppliers', $supplier, 'value');
            }
        }
        $suppliersOptions = $suppliersOptions ? $suppliersOptions : array();
        $allSuppliersOptions = Mage::getModel('eav/config')
                ->getAttribute('catalog_product', 'suppliers')
                ->getSource()
                ->getAllOptions();
        foreach (array_diff($allSuppliersOptions, $suppliersOptions) as $supplierOption) {
            $productSupplier = Mage::getModel('catalog/product')
                    ->loadByAttribute('sku', $this->getSupplierProductSku($product, array($supplierOption)));
            if ($productSupplier) {
                $productSupplier->delete();
            }
        }
    }
    
    private function getSupplierLinkData($product){
        //Refazer as associações dos links supplier
        $supplierData = array();
        foreach ($product->getSuppliers() as $supplier) {
            $supplierOption = $this->getSupplierAttributesOptions('suppliers', $supplier, 'value');
            $productSupplier = Mage::getModel('catalog/product')
                    ->loadByAttribute('sku', $this->getSupplierProductSku($product, $supplierOption));
            if ($productSupplier) {
                $supplierData[$productSupplier->getId()] = array('position' => $productSupplier->getId());
            }
        }
        return $supplierData;
    }

    private function getSupplierAttributesOptions($attributeCode, $selection = null, $filterBy = 'label'){
        if ($selection) {
            return array_filter(
                Mage::getModel('eav/config')
                    ->getAttribute('catalog_product', $attributeCode)
                    ->getSource()
                    ->getAllOptions(), 
                function($el) use ($selection, $filterBy) {
                    return ($el[$filterBy] === $selection);
                });
        }else{
            return Mage::getModel('eav/config')
                ->getAttribute('catalog_product', $attributeCode)
                ->getSource()
                ->getAllOptions();
        }
    }

    private function getSupplierProductSku($product, $supplierOption){
        return $sku = $product->getName() . '-' . $supplierOption[key($supplierOption)]['label'];
    }

    private function addAttributeOption($arg_attribute, $arg_value) { 
        $attribute_model = Mage::getModel('eav/entity_attribute'); 
        $attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;  
        
        $attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
        $attribute = $attribute_model->load($attribute_code);
        
        $attribute_table = $attribute_options_model->setAttribute($attribute); 
        $options = $attribute_options_model->getAllOptions(false);  
        
        $value['option'] = array($arg_value,$arg_value);
        $result = array('value' => $value);
        $attribute->setData('option',$result);
        $attribute->save(); 
        
        return $this->getAttributeOptionValue($arg_attribute, $arg_value); }

    /*
    private function duplicateProduct($product, $supplier){
        $duplicate = new Mage_Catalog_Model_Product(); 
        //Settings
        $duplicate->setAttributeSetId($product->getAttributeSetId())
                ->setTypeId($product->getTypeId())
                ->setWebsiteIDs($product->getWebsiteIDs())
                ->setStoreId(Mage::app()->getStore()->getId());
        //General
        $productSupplierOption = array_filter(
                Mage::getModel('eav/config')->getAttribute('catalog_product', 'product_supplier')->getSource()->getAllOptions(), 
                function($el) use ($supplier) {
                    return ($el['label'] === $supplier);
                });
        $duplicate->setName($product->getName())
                ->setDescription($product->getDescription())
                ->setShortDescription($product->getShortDescription())
                ->setSku($product->getSku() . '-' . $supplier)
                ->setWeight($product->getWeight())
                //->setNewsFromDate(null)
                //->setNewsToDate(null)
                ->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED)
                ->setUrl($product->getUrl())
                ->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH)
                //->setCountryOfManufacture($product->getCountryOfManufacture());
                //->setSuppliers(null) //Não é definido nestes duplicados
                ->setProductSupplier($productSupplierOption[key($productSupplierOption)]['value']);
        //Price
        $duplicate->setPrice($product->getPrice())
                ->setTaxClassId($product->getTaxClassId());
        //Meta Information
        $duplicate->setMetaTitle($product->getMetaTitle())
                ->setMetaKeywords($product->getMetaKeywords())
                ->setMetaDescription($product->getMetaDescription());
        //Images
        //Recurring Profile
        //Design
        //Gift Options
        //Inventory
        $duplicate->setStockData($product->getStockData());
        //Categories
        $duplicate->setCategoryIds($product->getCategoryIds());
        //Supplier Products
        //$duplicate->setSupplierLinkData();
        //Related Products
        $data = array();
        $product->getLinkInstance()->useRelatedLinks();
        $attributes = array();
        foreach ($product->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($product->getRelatedLinkCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $duplicate->setRelatedLinkData($data);
        //Up-sells
        $data = array();
        $product->getLinkInstance()->useUpSellLinks();
        $attributes = array();
        foreach ($product->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($product->getUpSellLinkCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $duplicate->setUpSellLinkData($data);
        //Cross-sells
        $data = array();
        $product->getLinkInstance()->useCrossSellLinks();
        $attributes = array();
        foreach ($product->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($product->getCrossSellLinkCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $duplicate->setCrossSellLinkData($data);
        //Product Reviews
        $duplicate->setProductReviews($product->getProductReviews());
        //Product Tags
        $duplicate->setProductTags($product->getProductTags());
        //Customer Tagged Products
        //Custom Options
        $duplicate->setProductOptions($product->getProductOptions());
        //Save
        //$duplicate->save();
    }
    */
    }
