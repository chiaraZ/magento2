<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Variable\Controller\Adminhtml\System;

use Magento\Backend\App\Action;

/**
 * Custom Variables admin controller
 * @since 2.0.0
 */
abstract class Variable extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Variable::variable';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     * @since 2.0.0
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     * @since 2.0.0
     */
    protected $resultForwardFactory;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     * @since 2.0.0
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     * @since 2.0.0
     */
    protected $resultJsonFactory;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     * @since 2.0.0
     */
    protected $layoutFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @since 2.0.0
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->layoutFactory = $layoutFactory;
    }

    /**
     * Initialize Layout and set breadcrumbs
     *
     * @return \Magento\Backend\Model\View\Result\Page
     * @since 2.0.0
     */
    protected function createPage()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Variable::system_variable')
            ->addBreadcrumb(__('Custom Variables'), __('Custom Variables'));
        return $resultPage;
    }

    /**
     * Initialize Variable object
     *
     * @return \Magento\Variable\Model\Variable
     * @since 2.0.0
     */
    protected function _initVariable()
    {
        $variableId = $this->getRequest()->getParam('variable_id', null);
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        /* @var $variable \Magento\Variable\Model\Variable */
        $variable = $this->_objectManager->create(\Magento\Variable\Model\Variable::class);
        if ($variableId) {
            $variable->setStoreId($storeId)->load($variableId);
        }
        $this->_coreRegistry->register('current_variable', $variable);
        return $variable;
    }
}
