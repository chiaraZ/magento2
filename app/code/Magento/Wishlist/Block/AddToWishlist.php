<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Wishlist\Block;

/**
 * Wishlist js plugin initialization block
 *
 * @api
 * @since 2.1.0
 */
class AddToWishlist extends \Magento\Framework\View\Element\Template
{
    /**
     * Product types
     *
     * @var array|null
     * @since 2.1.0
     */
    private $productTypes;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     * @since 2.1.0
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Returns wishlist widget options
     *
     * @return array
     * @since 2.1.0
     */
    public function getWishlistOptions()
    {
        return ['productType' => $this->getProductTypes()];
    }

    /**
     * Returns an array of product types
     *
     * @return array|null
     * @throws \Magento\Framework\Exception\LocalizedException
     * @since 2.1.0
     */
    private function getProductTypes()
    {
        if ($this->productTypes === null) {
            $this->productTypes = [];
            $block = $this->getLayout()->getBlock('category.products.list');
            if ($block) {
                $productCollection = $block->getLoadedProductCollection();
                $productTypes = [];
                /** @var $product \Magento\Catalog\Model\Product */
                foreach ($productCollection as $product) {
                    $productTypes[] = $this->escapeHtml($product->getTypeId());
                }
                $this->productTypes = array_unique($productTypes);
            }
        }
        return $this->productTypes;
    }

    /**
     * {@inheritdoc}
     * @since 2.1.0
     */
    protected function _toHtml()
    {
        if (!$this->getProductTypes()) {
            return '';
        }
        return parent::_toHtml();
    }
}
