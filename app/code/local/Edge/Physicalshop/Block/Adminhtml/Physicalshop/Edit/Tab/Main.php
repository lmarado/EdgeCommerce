<?php
/**
 * Physicalshop List admin edit form main tab
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Adminhtml_Physicalshop_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Prepare form elements for tab
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm() {
        $model = Mage::helper('edge_physicalshop')->getPhysicalshopItemInstance();

        /**
         * Checking if user have permissions to save information
         */
        if (Mage::helper('edge_physicalshop/admin')->isActionAllowed('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('physicalshop_main_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('edge_physicalshop')->__('Physical Shop Item Info')
        ));

        if ($model->getId()) {
            $fieldset->addField('physicalshop_id', 'hidden', array(
                'name' => 'physicalshop_id',
            ));
        }
        
        $fieldset->addField('country', 'text', array(
            'name'     => 'country',
            'label'    => Mage::helper('edge_physicalshop')->__('Country'),
            'title'    => Mage::helper('edge_physicalshop')->__('Country'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('locale', 'text', array(
            'name'     => 'locale',
            'label'    => Mage::helper('edge_physicalshop')->__('Locale'),
            'title'    => Mage::helper('edge_physicalshop')->__('Locale'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('address', 'text', array(
            'name'     => 'address',
            'label'    => Mage::helper('edge_physicalshop')->__('Address'),
            'title'    => Mage::helper('edge_physicalshop')->__('Address'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('postal_code', 'text', array(
            'name'     => 'postal_code',
            'label'    => Mage::helper('edge_physicalshop')->__('Postal Code'),
            'title'    => Mage::helper('edge_physicalshop')->__('Postal Code'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('telephone', 'text', array(
            'name'     => 'telephone',
            'label'    => Mage::helper('edge_physicalshop')->__('Telephone'),
            'title'    => Mage::helper('edge_physicalshop')->__('Telephone'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('free_parking', 'select', array(
            'name'     => 'free_parking',
            'class'    => 'required-entry',
            'label'    => Mage::helper('edge_physicalshop')->__('Free Parking'),
            'title'    => Mage::helper('edge_physicalshop')->__('Free Parking'),
            'onclick'  => '',
            'onchange' => '',
            'value'    => '1',
            'values'   => array('1' => 'Yes', '2' => 'No'),
            'tabindex' => 1,
            'required' => false,
            'disabled' => $isElementDisabled
        ));
        
        $fieldset->addField('gps', 'text', array(
            'name'     => 'gps',
            'label'    => Mage::helper('edge_physicalshop')->__('GPS'),
            'title'    => Mage::helper('edge_physicalshop')->__('GPS'),
            'required' => true,
            'disabled' => $isElementDisabled
        ));

        Mage::dispatchEvent('adminhtml_physicalshop_edit_tab_main_prepare_form', array('form' => $form));

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
        return Mage::helper('edge_physicalshop')->__('Physical Shop Info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('edge_physicalshop')->__('Physical Shop Info');
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
