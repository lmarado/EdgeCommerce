<?php
/**
 * Supplier List admin edit form container
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Block_Adminhtml_Supplier_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize edit form container
     *
     */
    public function __construct() {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'edge_supplier';
        $this->_controller = 'adminhtml_supplier';

        parent::__construct();

        if (Mage::helper('edge_supplier/admin')->isActionAllowed('save')) {
            $this->_updateButton('save', 'label', Mage::helper('edge_supplier')->__('Save Supplier Item'));
            $this->_addButton('saveandcontinue', array(
                'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ), -100);
        } else {
            $this->_removeButton('save');
        }
        if (Mage::helper('edge_supplier/admin')->isActionAllowed('delete')) {
            $this->_updateButton('delete', 'label', Mage::helper('edge_supplier')->__('Delete Supplier Item'));
        } else {
            $this->_removeButton('delete');
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'page_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'page_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText() {
        $model = Mage::helper('edge_supplier')->getSupplierItemInstance();
        if ($model->getId()) {
            return Mage::helper('edge_supplier')->__("Edit Supplier Item '%s'",
                 $this->escapeHtml($model->getSocialDesignation()));
        } else {
            return Mage::helper('edge_supplier')->__('New Supplier Item');
        }
    }
}
