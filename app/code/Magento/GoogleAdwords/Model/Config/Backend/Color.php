<?php
/**
 * Google AdWords Color Backend model
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\GoogleAdwords\Model\Config\Backend;

/**
 * @api
 * @since 2.0.0
 */
class Color extends \Magento\GoogleAdwords\Model\Config\Backend\AbstractConversion
{
    /**
     * Validation rule conversion color
     *
     * @return \Zend_Validate_Interface|null
     * @since 2.0.0
     */
    protected function _getValidationRulesBeforeSave()
    {
        $this->_validatorComposite->addRule(
            $this->_validatorFactory->createColorValidator($this->getValue()),
            'conversion_color'
        );
        return $this->_validatorComposite;
    }

    /**
     * Get tested value
     *
     * @return string
     * @since 2.0.0
     */
    public function getConversionColor()
    {
        return $this->getValue();
    }
}
