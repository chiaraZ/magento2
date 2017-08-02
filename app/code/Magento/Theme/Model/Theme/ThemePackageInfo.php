<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Theme\Model\Theme;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Filesystem\Directory\ReadFactory;

/**
 * Maps package name to full theme path, and vice versa
 * @since 2.0.0
 */
class ThemePackageInfo
{
    /**
     * @var ComponentRegistrar
     * @since 2.0.0
     */
    private $componentRegistrar;

    /**
     * @var ReadFactory
     * @since 2.0.0
     */
    private $readDirFactory;

    /**
     * @var array
     * @since 2.0.0
     */
    private $packageNameToFullPathMap = [];

    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     * @since 2.2.0
     */
    private $serializer;

    /**
     * Initialize dependencies.
     *
     * @param ComponentRegistrar $componentRegistrar
     * @param ReadFactory $readDirFactory
     * @param \Magento\Framework\Serialize\Serializer\Json|null $serializer
     * @since 2.0.0
     */
    public function __construct(
        ComponentRegistrar $componentRegistrar,
        ReadFactory $readDirFactory,
        \Magento\Framework\Serialize\Serializer\Json $serializer = null
    ) {
        $this->componentRegistrar = $componentRegistrar;
        $this->readDirFactory = $readDirFactory;
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Serialize\Serializer\Json::class);
    }

    /**
     * Get package name of a theme by its full theme path
     *
     * @param string $themePath
     * @return string
     * @since 2.0.0
     */
    public function getPackageName($themePath)
    {
        $themePath = $this->componentRegistrar->getPath(ComponentRegistrar::THEME, $themePath);
        $themeDir = $this->readDirFactory->create($themePath);
        if ($themeDir->isExist('composer.json')) {
            $rawData = [];
            $themeFile = $themeDir->readFile('composer.json');
            if ($themeFile) {
                $rawData = $this->serializer->unserialize($themeFile);
            }
            return isset($rawData['name']) ? $rawData['name'] : '';
        }
        return '';
    }

    /**
     * Get full theme path by its package name
     *
     * @param string $packageName
     * @return string
     * @since 2.0.0
     */
    public function getFullThemePath($packageName)
    {
        if (empty($this->packageNameToFullPathMap)) {
            $this->initializeMap();
        }
        return isset($this->packageNameToFullPathMap[$packageName])
            ? $this->packageNameToFullPathMap[$packageName] : '';
    }

    /**
     * Initialize package name to full theme path map
     *
     * @return void
     * @since 2.0.0
     */
    private function initializeMap()
    {
        $themePaths = $this->componentRegistrar->getPaths(ComponentRegistrar::THEME);
        /** @var \Magento\Theme\Model\Theme $theme */
        foreach ($themePaths as $fullThemePath => $themeDir) {
            $themeDirRead = $this->readDirFactory->create($themeDir);
            if ($themeDirRead->isExist('composer.json')) {
                $rawData = $this->serializer->unserialize($themeDirRead->readFile('composer.json'));
                if (isset($rawData['name'])) {
                    $this->packageNameToFullPathMap[$rawData['name']] = $fullThemePath;
                }
            }
        }
    }
}
