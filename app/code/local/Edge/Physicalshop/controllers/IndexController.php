<?php
 /**
 * Physicalshop frontend controller
 *
 * @author Luís André Franco Marado
 */
class Edge_Physicalshop_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Pre dispatch action that allows to redirect to no route page in case of disabled extension through admin panel
     */
    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::helper('edge_physicalshop')->isEnabled()) {
            $this->setFlag('', 'no-dispatch', true);
            $this->_redirect('noRoute');
        }
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->loadLayout();

        $listBlock = $this->getLayout()->getBlock('physicalshop.list');

        if ($listBlock) {
            $currentPage = abs(intval($this->getRequest()->getParam('p')));
            if ($currentPage < 1) {
                $currentPage = 1;
            }
            $listBlock->setCurrentPage($currentPage);
        }

        $this->renderLayout();
    }

    /**
     * Physicalshop view action
     */
    public function viewAction()
    {
        $newsId = $this->getRequest()->getParam('id');
        if (!$newsId) {
            return $this->_forward('noRoute');
        }
        
        /** @var $model Magentostudy_News_Model_News */
        $model = Mage::getModel('edge_physicalshop/physicalshop');
        $model->load($newsId);

        if (!$model->getId()) {
            return $this->_forward('noRoute');
        }

        Mage::register('physicalshop_item', $model);

        Mage::dispatchEvent('before_physicalshop_item_display', array('physicalshop_item' => $model));

        $this->loadLayout();
        $itemBlock = $this->getLayout()->getBlock('physicalshop.item');
        if ($itemBlock) {
            $listBlock = $this->getLayout()->getBlock('physicalshop.list');
            if ($listBlock) {
                $page = (int)$listBlock->getCurrentPage() ? (int)$listBlock->getCurrentPage() : 1;
            } else {
                $page = 1;
            }
            $itemBlock->setPage($page);
        }
        $this->renderLayout();
    }
}