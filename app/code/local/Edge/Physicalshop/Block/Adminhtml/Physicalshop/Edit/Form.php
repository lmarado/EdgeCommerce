<?php
/**
 * Physicalshop List admin edit form block
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_Block_Adminhtml_Physicalshop_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form action
     *
     * @return Edge_Physicalshop_Block_Adminhtml_Physicalshop_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/save'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
