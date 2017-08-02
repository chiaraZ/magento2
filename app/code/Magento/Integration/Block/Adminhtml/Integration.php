<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Integration\Block\Adminhtml;

/**
 * Integration block.
 *
 * @api
 * @codeCoverageIgnore
 * @since 2.0.0
 */
class Integration extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Define actions available on the integrations grid page.
     *
     * @return void
     * @since 2.0.0
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_integration';
        $this->_blockGroup = 'Magento_Integration';
        $this->_headerText = __('Integrations');
        $this->_addButtonLabel = __('Add New Integration');
        parent::_construct();
    }
}
