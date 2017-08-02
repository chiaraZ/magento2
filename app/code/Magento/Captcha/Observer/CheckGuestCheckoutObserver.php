<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Captcha\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class \Magento\Captcha\Observer\CheckGuestCheckoutObserver
 *
 * @since 2.0.0
 */
class CheckGuestCheckoutObserver implements ObserverInterface
{
    /**
     * @var \Magento\Captcha\Helper\Data
     * @since 2.0.0
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\App\ActionFlag
     * @since 2.0.0
     */
    protected $_actionFlag;

    /**
     * @var CaptchaStringResolver
     * @since 2.0.0
     */
    protected $captchaStringResolver;

    /**
     * @var \Magento\Checkout\Model\Type\Onepage
     * @since 2.0.0
     */
    protected $_typeOnepage;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     * @since 2.0.0
     */
    protected $jsonHelper;

    /**
     * @param \Magento\Captcha\Helper\Data $helper
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param CaptchaStringResolver $captchaStringResolver
     * @param \Magento\Checkout\Model\Type\Onepage $typeOnepage
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @since 2.0.0
     */
    public function __construct(
        \Magento\Captcha\Helper\Data $helper,
        \Magento\Framework\App\ActionFlag $actionFlag,
        CaptchaStringResolver $captchaStringResolver,
        \Magento\Checkout\Model\Type\Onepage $typeOnepage,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->_helper = $helper;
        $this->_actionFlag = $actionFlag;
        $this->captchaStringResolver = $captchaStringResolver;
        $this->_typeOnepage = $typeOnepage;
        $this->jsonHelper = $jsonHelper;
    }

    /**
     * Check Captcha On Checkout as Guest Page
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     * @since 2.0.0
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $formId = 'guest_checkout';
        $captchaModel = $this->_helper->getCaptcha($formId);
        $checkoutMethod = $this->_typeOnepage->getQuote()->getCheckoutMethod();
        if ($checkoutMethod == \Magento\Checkout\Model\Type\Onepage::METHOD_GUEST) {
            if ($captchaModel->isRequired()) {
                $controller = $observer->getControllerAction();
                if (!$captchaModel->isCorrect($this->captchaStringResolver->resolve($controller->getRequest(), $formId))
                ) {
                    $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
                    $result = ['error' => 1, 'message' => __('Incorrect CAPTCHA')];
                    $controller->getResponse()->representJson($this->jsonHelper->jsonEncode($result));
                }
            }
        }

        return $this;
    }
}
