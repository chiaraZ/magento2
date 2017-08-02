<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Checkout\Model\Cart;

/**
 * Class \Magento\Checkout\Model\Cart\CollectQuote
 *
 * @since 2.0.0
 */
class CollectQuote
{
    /**
     * @var \Magento\Customer\Model\Session
     * @since 2.0.0
     */
    protected $customerSession;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     * @since 2.0.0
     */
    protected $customerRepository;

    /**
     * @var \Magento\Customer\Api\AddressRepositoryInterface
     * @since 2.0.0
     */
    protected $addressRepository;

    /**
     * @var \Magento\Quote\Api\Data\EstimateAddressInterfaceFactory
     * @since 2.0.0
     */
    protected $estimatedAddressFactory;

    /**
     * @var \Magento\Quote\Api\ShippingMethodManagementInterface
     * @since 2.0.0
     */
    protected $shippingMethodManager;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     * @since 2.0.0
     */
    protected $quoteRepository;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Magento\Quote\Api\Data\EstimateAddressInterfaceFactory $estimatedAddressFactory
     * @param \Magento\Quote\Api\ShippingMethodManagementInterface $shippingMethodManager
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @codeCoverageIgnore
     * @since 2.0.0
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Quote\Api\Data\EstimateAddressInterfaceFactory $estimatedAddressFactory,
        \Magento\Quote\Api\ShippingMethodManagementInterface $shippingMethodManager,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->addressRepository = $addressRepository;
        $this->estimatedAddressFactory = $estimatedAddressFactory;
        $this->shippingMethodManager = $shippingMethodManager;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @return void
     * @since 2.0.0
     */
    public function collect(\Magento\Quote\Model\Quote $quote)
    {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerRepository->getById($this->customerSession->getCustomerId());
            if ($defaultShipping = $customer->getDefaultShipping()) {
                $address = $this->addressRepository->getById($defaultShipping);
                if ($address) {
                    /** @var \Magento\Quote\Api\Data\EstimateAddressInterface $estimatedAddress */
                    $estimatedAddress = $this->estimatedAddressFactory->create();
                    $estimatedAddress->setCountryId($address->getCountryId());
                    $estimatedAddress->setPostcode($address->getPostcode());
                    $estimatedAddress->setRegion((string)$address->getRegion()->getRegion());
                    $estimatedAddress->setRegionId($address->getRegionId());
                    $this->shippingMethodManager->estimateByAddress($quote->getId(), $estimatedAddress);
                    $this->quoteRepository->save($quote);
                }
            }
        }
    }
}
