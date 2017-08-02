<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Rule\Model\Condition;

/**
 * Constructor modification point for Magento\Catalog\Model\Layer.
 *
 * All context classes were introduced to allow for backwards compatible constructor modifications
 * of classes that were supposed to be extended by extension developers.
 *
 * Do not call methods of this class directly.
 *
 * As Magento moves from inheritance-based APIs all such classes will be deprecated together with
 * the classes they were introduced for.
 *
 * @api
 * @deprecated 2.2.0
 * @since 2.0.0
 */
class Context implements \Magento\Framework\ObjectManager\ContextInterface
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     * @since 2.0.0
     */
    protected $_assetRepo;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     * @since 2.0.0
     */
    protected $_localeDate;

    /**
     * @var \Magento\Framework\View\LayoutInterface
     * @since 2.0.0
     */
    protected $_layout;

    /**
     * @var \Magento\Rule\Model\ConditionFactory
     * @since 2.0.0
     */
    protected $_conditionFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     * @since 2.0.0
     */
    protected $_logger;

    /**
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\View\LayoutInterface $layout
     * @param \Magento\Rule\Model\ConditionFactory $conditionFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @since 2.0.0
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Rule\Model\ConditionFactory $conditionFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_assetRepo = $assetRepo;
        $this->_localeDate = $localeDate;
        $this->_layout = $layout;
        $this->_conditionFactory = $conditionFactory;
        $this->_logger = $logger;
    }

    /**
     * @return \Magento\Framework\View\Asset\Repository
     * @since 2.0.0
     */
    public function getAssetRepository()
    {
        return $this->_assetRepo;
    }

    /**
     * @return \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     * @since 2.0.0
     */
    public function getLocaleDate()
    {
        return $this->_localeDate;
    }

    /**
     * @return \Magento\Framework\View\LayoutInterface
     * @since 2.0.0
     */
    public function getLayout()
    {
        return $this->_layout;
    }

    /**
     * @return \Magento\Rule\Model\ConditionFactory
     * @since 2.0.0
     */
    public function getConditionFactory()
    {
        return $this->_conditionFactory;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     * @since 2.0.0
     */
    public function getLogger()
    {
        return $this->_logger;
    }
}
