<?php
/**
 * Supplier Admin helper
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Helper_Admin extends Mage_Core_Helper_Abstract
{
    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    public function isActionAllowed($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('supplier/manage/' . $action);
    }
}
