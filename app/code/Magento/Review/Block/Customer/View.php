<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Review\Block\Customer;

use Magento\Catalog\Model\Product;
use Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection as VoteCollection;
use Magento\Review\Model\Review;

/**
 * Customer Review detailed view block
 *
 * @api
 * @author      Magento Core Team <core@magentocommerce.com>
 * @since 2.0.0
 */
class View extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * Customer view template name
     *
     * @var string
     * @since 2.0.0
     */
    protected $_template = 'customer/view.phtml';

    /**
     * Catalog product model
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     * @since 2.0.0
     */
    protected $productRepository;

    /**
     * Review model
     *
     * @var \Magento\Review\Model\ReviewFactory
     * @since 2.0.0
     */
    protected $_reviewFactory;

    /**
     * Rating option model
     *
     * @var \Magento\Review\Model\Rating\Option\VoteFactory
     * @since 2.0.0
     */
    protected $_voteFactory;

    /**
     * Rating model
     *
     * @var \Magento\Review\Model\RatingFactory
     * @since 2.0.0
     */
    protected $_ratingFactory;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     * @since 2.0.0
     */
    protected $currentCustomer;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     * @param \Magento\Review\Model\Rating\Option\VoteFactory $voteFactory
     * @param \Magento\Review\Model\RatingFactory $ratingFactory
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param array $data
     * @since 2.0.0
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Review\Model\ReviewFactory $reviewFactory,
        \Magento\Review\Model\Rating\Option\VoteFactory $voteFactory,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        $this->_reviewFactory = $reviewFactory;
        $this->_voteFactory = $voteFactory;
        $this->_ratingFactory = $ratingFactory;
        $this->currentCustomer = $currentCustomer;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Initialize review id
     *
     * @return void
     * @since 2.0.0
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setReviewId($this->getRequest()->getParam('id', false));
    }

    /**
     * Get product data
     *
     * @return Product
     * @since 2.0.0
     */
    public function getProductData()
    {
        if ($this->getReviewId() && !$this->getProductCacheData()) {
            $product = $this->productRepository->getById($this->getReviewData()->getEntityPkValue());
            $this->setProductCacheData($product);
        }
        return $this->getProductCacheData();
    }

    /**
     * Get review data
     *
     * @return Review
     * @since 2.0.0
     */
    public function getReviewData()
    {
        if ($this->getReviewId() && !$this->getReviewCachedData()) {
            $this->setReviewCachedData($this->_reviewFactory->create()->load($this->getReviewId()));
        }
        return $this->getReviewCachedData();
    }

    /**
     * Return review customer url
     *
     * @return string
     * @since 2.0.0
     */
    public function getBackUrl()
    {
        return $this->getUrl('review/customer');
    }

    /**
     * Get review rating collection
     *
     * @return VoteCollection
     * @since 2.0.0
     */
    public function getRating()
    {
        if (!$this->getRatingCollection()) {
            $ratingCollection = $this->_voteFactory->create()->getResourceCollection()->setReviewFilter(
                $this->getReviewId()
            )->addRatingInfo(
                $this->_storeManager->getStore()->getId()
            )->setStoreFilter(
                $this->_storeManager->getStore()->getId()
            )->load();

            $this->setRatingCollection($ratingCollection->getSize() ? $ratingCollection : false);
        }

        return $this->getRatingCollection();
    }

    /**
     * Get rating summary
     *
     * @return array
     * @since 2.0.0
     */
    public function getRatingSummary()
    {
        if (!$this->getRatingSummaryCache()) {
            $this->setRatingSummaryCache(
                $this->_ratingFactory->create()->getEntitySummary($this->getProductData()->getId())
            );
        }
        return $this->getRatingSummaryCache();
    }

    /**
     * Get total reviews
     *
     * @return int
     * @since 2.0.0
     */
    public function getTotalReviews()
    {
        if (!$this->getTotalReviewsCache()) {
            $this->setTotalReviewsCache(
                $this->_reviewFactory->create()->getTotalReviews($this->getProductData()->getId()),
                false,
                $this->_storeManager->getStore()->getId()
            );
        }
        return $this->getTotalReviewsCache();
    }

    /**
     * Get formatted date
     *
     * @param string $date
     * @return string
     * @since 2.0.0
     */
    public function dateFormat($date)
    {
        return $this->formatDate($date, \IntlDateFormatter::LONG);
    }

    /**
     * Get product reviews summary
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param bool $templateType
     * @param bool $displayIfNoReviews
     * @return string
     * @since 2.0.0
     */
    public function getReviewsSummaryHtml(
        \Magento\Catalog\Model\Product $product,
        $templateType = false,
        $displayIfNoReviews = false
    ) {
        if (!$product->getRatingSummary()) {
            $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
        }
        return parent::getReviewsSummaryHtml($product, $templateType, $displayIfNoReviews);
    }

    /**
     * @return string
     * @since 2.0.0
     */
    protected function _toHtml()
    {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }
}
