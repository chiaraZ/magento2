<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Magento\Shipping\Block\Tracking;

use Magento\Framework\Stdlib\DateTime\DateTimeFormatterInterface;

/**
 * @api
 * @since 2.0.0
 */
class Popup extends \Magento\Framework\View\Element\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     * @since 2.0.0
     */
    protected $_registry;

    /**
     * @var DateTimeFormatterInterface
     * @since 2.0.0
     */
    protected $dateTimeFormatter;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param DateTimeFormatterInterface $dateTimeFormatter
     * @param array $data
     * @since 2.0.0
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        DateTimeFormatterInterface $dateTimeFormatter,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
        $this->dateTimeFormatter = $dateTimeFormatter;
    }

    /**
     * Retrieve array of tracking info
     *
     * @return array
     * @since 2.0.0
     */
    public function getTrackingInfo()
    {
        /* @var $info \Magento\Shipping\Model\Info */
        $info = $this->_registry->registry('current_shipping_info');

        return $info->getTrackingInfo();
    }

    /**
     * Format given date and time in current locale without changing timezone
     *
     * @param string $date
     * @param string $time
     * @return string
     * @since 2.0.0
     */
    public function formatDeliveryDateTime($date, $time)
    {
        return $this->formatDeliveryDate($date) . ' ' . $this->formatDeliveryTime($time);
    }

    /**
     * Format given date in current locale without changing timezone
     *
     * @param string $date
     * @return string
     * @since 2.0.0
     */
    public function formatDeliveryDate($date)
    {
        $format = $this->_localeDate->getDateFormat(\IntlDateFormatter::MEDIUM);
        return $this->dateTimeFormatter->formatObject($this->_localeDate->date(new \DateTime($date)), $format);
    }

    /**
     * Format given time [+ date] in current locale without changing timezone
     *
     * @param string $time
     * @param string $date
     * @return string
     * @since 2.0.0
     */
    public function formatDeliveryTime($time, $date = null)
    {
        if (!empty($date)) {
            $time = $date . ' ' . $time;
        }

        $format = $this->_localeDate->getTimeFormat(\IntlDateFormatter::SHORT);
        return $this->dateTimeFormatter->formatObject($this->_localeDate->date(new \DateTime($time)), $format);
    }

    /**
     * Is 'contact us' option enabled?
     *
     * @return boolean
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     * @since 2.0.0
     */
    public function getContactUsEnabled()
    {
        return (bool)$this->_scopeConfig->getValue(
            'contacts/contacts/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     * @since 2.0.0
     */
    public function getStoreSupportEmail()
    {
        return $this->_scopeConfig->getValue(
            'trans_email/ident_support/email',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     * @since 2.0.0
     */
    public function getContactUs()
    {
        return $this->getUrl('contact');
    }
}
