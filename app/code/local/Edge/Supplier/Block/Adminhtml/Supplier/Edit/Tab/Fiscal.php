<?php
/**
 * Supplier List admin edit form fiscal tab
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Block_Adminhtml_Supplier_Edit_Tab_Fiscal
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepares tab form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
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

        $form->setHtmlIdPrefix('supplier_fiscal_');

        $fieldset = $form->addFieldset('fiscal_fieldset', array(
            'legend' => Mage::helper('edge_supplier')->__('Supplier Fiscal Info')
        ));

        $fieldset->addField('social_designation', 'text', array(
            'name'     => 'social_designation',
            'label'    => Mage::helper('edge_supplier')->__('Social Designation'),
            'title'    => Mage::helper('edge_supplier')->__('Social Designation'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        $fieldset->addField('nif', 'text', array(
            'name'     => 'nif',
            'label'    => Mage::helper('edge_supplier')->__('NIF'),
            'title'    => Mage::helper('edge_supplier')->__('NIF'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('country', 'text', array(
            'name'     => 'country',
            'label'    => Mage::helper('edge_supplier')->__('Country'),
            'title'    => Mage::helper('edge_supplier')->__('Country'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('city', 'text', array(
            'name'     => 'city',
            'label'    => Mage::helper('edge_supplier')->__('City'),
            'title'    => Mage::helper('edge_supplier')->__('City'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('address', 'text', array(
            'name'     => 'address',
            'label'    => Mage::helper('edge_supplier')->__('Address'),
            'title'    => Mage::helper('edge_supplier')->__('Address'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('postal_code', 'text', array(
            'name'     => 'postal_code',
            'label'    => Mage::helper('edge_supplier')->__('Postal Code'),
            'title'    => Mage::helper('edge_supplier')->__('Postal Code'),
            'required' => false,
            'disabled' => $isElementDisabled
        ));

        Mage::dispatchEvent('adminhtml_supplier_edit_tab_fiscal_prepare_form', array('form' => $form));

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
        return Mage::helper('edge_supplier')->__('Fiscal');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('edge_supplier')->__('Fiscal');
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
