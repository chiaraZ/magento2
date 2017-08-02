<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\GiftMessage\Model\Type\Plugin;

/**
 * Class \Magento\GiftMessage\Model\Type\Plugin\Onepage
 *
 * @since 2.0.0
 */
class Onepage
{
    /**
     * @var \Magento\GiftMessage\Model\GiftMessageManager
     * @since 2.0.0
     */
    protected $message;

    /**
     * @var \Magento\Framework\App\RequestInterface
     * @since 2.0.0
     */
    protected $request;

    /**
     * @param \Magento\GiftMessage\Model\GiftMessageManager $message
     * @param \Magento\Framework\App\RequestInterface $request
     * @since 2.0.0
     */
    public function __construct(
        \Magento\GiftMessage\Model\GiftMessageManager $message,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->message = $message;
        $this->request = $request;
    }

    /**
     * @param \Magento\Checkout\Model\Type\Onepage $subject
     * @param array $result
     * @return $this
     * @since 2.0.0
     */
    public function afterSaveShippingMethod(
        \Magento\Checkout\Model\Type\Onepage $subject,
        array $result
    ) {
        if (!$result) {
            $giftMessages = $this->request->getParam('giftmessage');
            $quote = $subject->getQuote();
            $this->message->add($giftMessages, $quote);
        }
        return $result;
    }
}
