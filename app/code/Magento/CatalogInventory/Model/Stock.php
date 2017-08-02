<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\CatalogInventory\Model;

use Magento\CatalogInventory\Api\Data\StockInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class Stock
 *
 * @since 2.0.0
 */
class Stock extends AbstractExtensibleModel implements StockInterface
{
    /**
     * Stock entity code
     */
    const ENTITY = 'cataloginventory_stock';

    /**
     * Prefix of model events names
     *
     * @var string
     * @since 2.2.0
     */
    protected $_eventPrefix = 'cataloginventory_stock';

    /**
     * Parameter name in event
     * In observe method you can use $observer->getEvent()->getStock() in this case
     *
     * @var string
     * @since 2.2.0
     */
    protected $_eventObject = 'stock';

    const BACKORDERS_NO = 0;

    const BACKORDERS_YES_NONOTIFY = 1;

    const BACKORDERS_YES_NOTIFY = 2;

    const STOCK_OUT_OF_STOCK = 0;

    const STOCK_IN_STOCK = 1;

    const WEBSITE_ID = 'website_id';

    /**
     * Default stock id
     */
    const DEFAULT_STOCK_ID = 1;

    /**
     * @return void
     * @since 2.0.0
     */
    protected function _construct()
    {
        $this->_init(\Magento\CatalogInventory\Model\ResourceModel\Stock::class);
    }

    //@codeCoverageIgnoreStart

    /**
     * Retrieve stock identifier
     *
     * @return int|null
     * @since 2.0.0
     */
    public function getStockId()
    {
        return $this->_getData(self::STOCK_ID);
    }

    /**
     * Retrieve website identifier
     *
     * @return int
     * @since 2.0.0
     */
    public function getWebsiteId()
    {
        return $this->_getData(self::WEBSITE_ID);
    }

    /**
     * Retrieve Stock Name
     *
     * @return string
     * @since 2.0.0
     */
    public function getStockName()
    {
        return $this->_getData(self::STOCK_NAME);
    }

    /**
     * Set stock identifier
     *
     * @param int $stockId
     * @return $this
     * @since 2.0.0
     */
    public function setStockId($stockId)
    {
        return $this->setData(self::STOCK_ID, $stockId);
    }

    /**
     * Retrieve website identifier
     *
     * @param int $websiteId
     * @return $this
     * @since 2.0.0
     */
    public function setWebsiteId($websiteId)
    {
        return $this->setData(self::WEBSITE_ID, $websiteId);
    }

    /**
     * Set stock name
     *
     * @param string $stockName
     * @return $this
     * @since 2.0.0
     */
    public function setStockName($stockName)
    {
        return $this->setData(self::STOCK_NAME, $stockName);
    }

    /**
     * {@inheritdoc}
     *
     * @return \Magento\CatalogInventory\Api\Data\StockExtensionInterface|null
     * @since 2.0.0
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     *
     * @param \Magento\CatalogInventory\Api\Data\StockExtensionInterface $extensionAttributes
     * @return $this
     * @since 2.0.0
     */
    public function setExtensionAttributes(
        \Magento\CatalogInventory\Api\Data\StockExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    //@codeCoverageIgnoreEnd
}
