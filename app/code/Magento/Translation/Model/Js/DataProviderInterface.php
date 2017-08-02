<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Translation\Model\Js;

/**
 * Provides translation data from a theme.
 *
 * @api
 * @since 2.0.0
 */
interface DataProviderInterface
{
    /**
     * Gets translation data for a given theme. Only returns phrases which are actually translated.
     *
     * @param string $themePath The path to the theme
     * @return array A string array where the key is the phrase and the value is the translated phrase.
     * @throws \Exception
     * @since 2.0.0
     */
    public function getData($themePath);
}
