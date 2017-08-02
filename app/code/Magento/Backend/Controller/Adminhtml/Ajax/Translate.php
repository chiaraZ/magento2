<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Backend\Controller\Adminhtml\Ajax;

use Magento\Backend\App\Action;

/**
 * Class \Magento\Backend\Controller\Adminhtml\Ajax\Translate
 *
 * @since 2.0.0
 */
class Translate extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Translate\Inline\ParserInterface
     * @since 2.0.0
     */
    protected $inlineParser;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     * @since 2.0.0
     */
    protected $resultJsonFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\Translate\Inline\ParserInterface $inlineParser
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @since 2.0.0
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\Translate\Inline\ParserInterface $inlineParser,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->inlineParser = $inlineParser;
    }

    /**
     * Ajax action for inline translation
     *
     * @return \Magento\Framework\Controller\Result\Json
     * @since 2.0.0
     */
    public function execute()
    {
        $translate = (array)$this->getRequest()->getPost('translate');

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        try {
            $this->inlineParser->processAjaxPost($translate);
            $response = ['success' => 'true'];
        } catch (\Exception $e) {
            $response = ['error' => 'true', 'message' => $e->getMessage()];
        }

        $this->_actionFlag->set('', self::FLAG_NO_POST_DISPATCH, true);
        return $resultJson->setData($response);
    }
}
