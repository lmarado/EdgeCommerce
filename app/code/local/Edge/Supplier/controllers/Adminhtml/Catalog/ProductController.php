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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'Catalog'.DS.'ProductController.php');

class Edge_Supplier_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    public function supplierAction() {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('catalog.product.edit.tab.supplier')
            ->setProductsSupplier($this->getRequest()->getPost('products_supplier', null));
        $this->renderLayout();
    }
    
    /**
     * Get supplier products grid
     */
    public function supplierGridAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('catalog.product.edit.tab.supplier')
            ->setProductsRelated($this->getRequest()->getPost('products_supplier', null));
        $this->renderLayout();
    }

    /**
     * Initialize product before saving
     */
    protected function _initProductSave()
    {
        $product     = parent::_initProductSave();
        
        /**
         * Init product links data (supplier, related, upsell, crosssel)
         */
        $links = $this->getRequest()->getPost('links');
        if (isset($links['supplier']) && !$product->getSupplierReadonly()) {
            $product->setSupplierLinkData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['supplier']));
        }

        return $product;
    }
}
