<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Sales\Model\Order\Invoice;

/**
 * Interface for Invoice notifier.
 *
 * @api
 * @since 2.2.0
 */
interface NotifierInterface
{
    /**
     * Notifies customer.
     *
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Magento\Sales\Api\Data\InvoiceInterface $invoice
     * @param \Magento\Sales\Api\Data\InvoiceCommentCreationInterface|null $comment
     * @param bool $forceSyncMode
     *
     * @return void
     * @since 2.2.0
     */
    public function notify(
        \Magento\Sales\Api\Data\OrderInterface $order,
        \Magento\Sales\Api\Data\InvoiceInterface $invoice,
        \Magento\Sales\Api\Data\InvoiceCommentCreationInterface $comment = null,
        $forceSyncMode = false
    );
}
