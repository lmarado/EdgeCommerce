<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product model
 *
 * @method Mage_Catalog_Model_Resource_Product getResource()
 * @method Mage_Catalog_Model_Product setHasError(bool $value)
 * @method null|bool getHasError()
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Edge_Supplier_Model_Catalog_Product extends Mage_Catalog_Model_Product
{
/*******************************************************************************
 ** Linked products API
 */
    /**
     * Retrieve array of seller roducts
     *
     * @return array
     */
    public function getSupplierProducts()
    {
        if (!$this->hasSellerProducts()) {
            $products = array();
            $collection = $this->getSupplierProductCollection();
            foreach ($collection as $product) {
                $products[] = $product;
            }
            $this->setSupplierProducts($products);
        }
        return $this->getData('supplier_products');
    }

    /**
     * Retrieve seller products identifiers
     *
     * @return array
     */
    public function getSupplierProductIds()
    {
        if (!$this->hasSupplierProductIds()) {
            $ids = array();
            foreach ($this->getSupplierProducts() as $product) {
                $ids[] = $product->getId();
            }
            $this->setSupplierProductIds($ids);
        }
        return $this->getData('supplier_product_ids');
    }

    /**
     * Retrieve collection seller product
     *
     * @return Mage_Catalog_Model_Resource_Product_Link_Product_Collection
     */
    public function getSupplierProductCollection()
    {
        $collection = $this->getLinkInstance()->useSupplierLinks()
            ->getProductCollection()
            ->setIsStrongMode();
        $collection->setProduct($this);
        return $collection;
    }

    /**
     * Retrieve collection seller link
     *
     * @return Mage_Catalog_Model_Resource_Product_Link_Collection
     */
    public function getSupplierLinkCollection()
    {
        $collection = $this->getLinkInstance()->useSupplierLinks()
            ->getLinkCollection();
        $collection->setProduct($this);
        $collection->addLinkTypeIdFilter();
        $collection->addProductIdFilter();
        $collection->joinAttributes();
        return $collection;
    }

    /**
     * Create duplicate
     *
     * @return Mage_Catalog_Model_Product
     */
    public function duplicate()
    {
        $newProduct = parent::duplicate();
        
        /* Prepare Seller*/
        $data = array();
        $this->getLinkInstance()->useSupplierLinks();
        $attributes = array();
        foreach ($this->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($this->getSupplierLinkCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $newProduct->setSupplierLinkData($data);

        return $newProduct;
    }
}
