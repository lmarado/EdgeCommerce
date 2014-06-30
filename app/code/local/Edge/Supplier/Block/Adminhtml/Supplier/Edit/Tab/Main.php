<?php
/**
 * Supplier List admin edit form main tab
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Block_Adminhtml_Supplier_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $model = Mage::helper('edge_supplier')->getSupplierItemInstance();

        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('edge_supplier/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('supplier_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('edge_supplier')->__('Supplier Item Info')
        ));

        if ($model->getId()) {
            $fieldset->addField('supplier_id', 'hidden', array(
                'name' => 'supplier_id',
            ));
        }

        $fieldset->addField('telephone', 'text', array(
            'name'     => 'telephone',
            'label'    => Mage::helper('edge_supplier')->__('Telephone'),
            'title'    => Mage::helper('edge_supplier')->__('Telephone'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('mobile', 'text', array(
            'name'     => 'mobile',
            'label'    => Mage::helper('edge_supplier')->__('Mobile'),
            'title'    => Mage::helper('edge_supplier')->__('Mobile'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        Mage::dispatchEvent('adminhtml_supplier_edit_tab_main_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('edge_supplier')->__('Supplier Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('edge_supplier')->__('Supplier Info');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }
}
