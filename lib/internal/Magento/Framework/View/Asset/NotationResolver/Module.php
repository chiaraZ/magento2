<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\View\Asset\NotationResolver;

use Magento\Framework\View\Asset;
use Magento\Framework\View\FileSystem;

/**
 * Module notation normalizer
 * @since 2.0.0
 */
class Module
{
    /**
     * @var \Magento\Framework\View\Asset\Repository
     * @since 2.0.0
     */
    private $assetRepo;

    /**
     * @param Asset\Repository $assetRepo
     * @since 2.0.0
     */
    public function __construct(Asset\Repository $assetRepo)
    {
        $this->assetRepo = $assetRepo;
    }

    /**
     * Convert module notation to a path relative to the specified asset
     *
     * For example, the asset is Foo_Bar/styles/style.css and it refers to Bar_Baz::images/logo.gif
     * (i.e. url(Bar_Baz::images/logo.gif))
     * The result will be ../../Bar_Baz/images/logo.gif
     *
     * @param Asset\LocalInterface $thisAsset
     * @param string $relatedFileId
     * @return string
     * @since 2.0.0
     */
    public function convertModuleNotationToPath(Asset\LocalInterface $thisAsset, $relatedFileId)
    {
        if (false === strpos($relatedFileId, Asset\Repository::FILE_ID_SEPARATOR)) {
            return $relatedFileId;
        }
        $thisPath = $thisAsset->getPath();
        $relatedAsset = $this->assetRepo->createSimilar($relatedFileId, $thisAsset);
        $relatedPath = $relatedAsset->getPath();
        $offset = FileSystem::offsetPath($relatedPath, $thisPath);
        return FileSystem::normalizePath($offset . '/' . basename($relatedPath));
    }
}
