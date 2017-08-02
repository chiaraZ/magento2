<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Magento\Config\Model\Config\Source\Dev;

/**
 * @api
 * @since 2.0.0
 */
class Dbautoup implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     * @since 2.0.0
     */
    public function toOptionArray()
    {
        return [
            ['value' => \Magento\Framework\App\ResourceConnection::AUTO_UPDATE_ALWAYS, 'label' => __('Always (during development)')],
            ['value' => \Magento\Framework\App\ResourceConnection::AUTO_UPDATE_ONCE, 'label' => __('Only Once (version upgrade)')],
            ['value' => \Magento\Framework\App\ResourceConnection::AUTO_UPDATE_NEVER, 'label' => __('Never (production)')]
        ];
    }
}
