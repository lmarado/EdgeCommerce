<?php
/**
 * Supplier controller
 *
 * @author Luís André Franco Marado
 */
class Edge_Supplier_Adminhtml_SupplierController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Init actions
     *
     * @return Edge_Supplier_Adminhtml_SupplierController
     */
    protected function _initAction() {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('supplier/manage')
            ->_addBreadcrumb(
                  Mage::helper('edge_supplier')->__('Supplier'),
                  Mage::helper('edge_supplier')->__('Supplier')
              )
            ->_addBreadcrumb(
                  Mage::helper('edge_supplier')->__('Manage Supplier'),
                  Mage::helper('edge_supplier')->__('Manage Supplier')
              );
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction() {
        $this->_title($this->__('Supplier'))
             ->_title($this->__('Manage Supplier'));

        $this->_initAction();
        $this->renderLayout();
    }
    
    /**
     * Create new Supplier item
     */
    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    /**
     * Edit Supplier item
     */
    public function editAction() {
        $this->_title($this->__('Supplier'))
             ->_title($this->__('Manage Supplier'));
        
        // 1. instance news model
        /* @var $model Edge_Supplier_Model_Item */
        $model = Mage::getModel('edge_supplier/supplier');
        
        // 2. if exists id, check it and load data
        $supplierId = $this->getRequest()->getParam('id');
        if ($supplierId) {
            $model->load($supplierId);
            
            if (!$model->getId()) {
                $this->_getSession()->addError(
                    Mage::helper('edge_supplier')->__('Supplier item does not exist.')
                );
                return $this->_redirect('*/*/');
            }
            // prepare title
            $this->_title($model->getSocialDesignation());
            $breadCrumb = Mage::helper('edge_supplier')->__('Edit Item');
        }else{
            $this->_title(Mage::helper('edge_supplier')->__('New Item'));
            $breadCrumb = Mage::helper('edge_supplier')->__('New Item');
        }
        // Init breadcrumbs
        $this->_initAction()->_addBreadcrumb($breadCrumb, $breadCrumb);
        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        // 4. Register model to use later in blocks
        Mage::register('supplier_item', $model);
        // 5. render layout
        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function saveAction() {
        $redirectPath   = '*/*';
        $redirectParams = array();

        // check if data sent
        $data = $this->getRequest()->getPost();
        if ($data) {
            $data = $this->_filterPostData($data);
            // init model and set data
            /* @var $model Edge_Supplier_Model_Item */
            $model = Mage::getModel('edge_supplier/supplier');

            // if news item exists, try to load it
            $supplierId = $this->getRequest()->getParam('supplier_id');
            if ($supplierId) {
                $model->load($supplierId);
            }
            $model->addData($data);

            try {
                $hasError = false;
                
                // save the data
                $model->save();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('edge_supplier')->__('The supplier item has been saved.')
                );

                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $redirectPath   = '*/*/edit';
                    $redirectParams = array('id' => $model->getId());
                }
            } catch (Mage_Core_Exception $e) {
                $hasError = true;
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $hasError = true;
                $this->_getSession()->addException($e,
                    Mage::helper('edge_supplier')->__('An error occurred while saving the supplier item.')
                );
            }

            if ($hasError) {
                $this->_getSession()->setFormData($data);
                $redirectPath   = '*/*/edit';
                $redirectParams = array('id' => $this->getRequest()->getParam('id'));
            }
        }

        $this->_redirect($redirectPath, $redirectParams);
    }

    
    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        $itemId = $this->getRequest()->getParam('id');
        if ($itemId) {
            try {
                // init model and delete
                /** @var $model Edge_Supplier_Model_Item */
                $model = Mage::getModel('edge_supplier/supplier');
                $model->load($itemId);
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('edge_supplier')->__('Unable to find a supplier item.'));
                }
                $model->delete();

                // display success message
                $this->_getSession()->addSuccess(
                    Mage::helper('edge_supplier')->__('The supplier item has been deleted.')
                );
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('edge_supplier')->__('An error occurred while deleting the supplier item.')
                );
            }
        }

        // go to grid
        $this->_redirect('*/*/');
    }
    
    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed() {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('supplier/manage/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('supplier/manage/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('supplier/manage');
                break;
        }
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array
     * @return array
     */
    protected function _filterPostData($data) {
        //$data = $this->_filterDates($data, array('time_published'));
        return $data;
    }

    /**
     * Grid ajax action
     */
    public function gridAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Flush Supplier Posts Cache action
     */
    public function flushAction() {
        $this->_forward('index');
    }
}
