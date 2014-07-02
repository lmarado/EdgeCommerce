<?php
/**
 * Physicalshop List admin edit form container
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Adminhtml_Physicalshop_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize edit form container
     *
     */
    public function __construct() {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'edge_physicalshop';
        $this->_controller = 'adminhtml_physicalshop';

        parent::__construct();

        if (Mage::helper('edge_physicalshop/admin')->isActionAllowed('save')) {
            $this->_updateButton('save', 'label', Mage::helper('edge_physicalshop')->__('Save Physical Shop Item'));
            $this->_addButton('saveandcontinue', array(
                'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ), -100);
        } else {
            $this->_removeButton('save');
        }
        if (Mage::helper('edge_physicalshop/admin')->isActionAllowed('delete')) {
            $this->_updateButton('delete', 'label', Mage::helper('edge_physicalshop')->__('Delete Physical Shop Item'));
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
        $model = Mage::helper('edge_physicalshop')->getPhysicalshopItemInstance();
        if ($model->getId()) {
            return Mage::helper('edge_physicalshop')->__("Edit Physical Shop Item '%s'",
                 $this->escapeHtml($model->getSocialDesignation()));
        } else {
            return Mage::helper('edge_physicalshop')->__('New Physical Shop Item');
        }
    }
}
