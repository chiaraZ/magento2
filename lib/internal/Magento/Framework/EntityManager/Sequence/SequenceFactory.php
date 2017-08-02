<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\EntityManager\Sequence;

use Magento\Framework\DB\Sequence\SequenceInterface;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class SequenceFactory
 * @since 2.1.0
 */
class SequenceFactory
{
    /**
     * @var ObjectManagerInterface
     * @since 2.1.0
     */
    protected $objectManager;

    /**
     * @var SequenceRegistry
     * @since 2.1.0
     */
    protected $sequenceRegistry;

    /**
     * @var string
     * @since 2.1.0
     */
    protected $instanceName;

    /**
     * @param SequenceRegistry $sequenceRegistry
     * @param ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @since 2.1.0
     */
    public function __construct(
        SequenceRegistry $sequenceRegistry,
        ObjectManagerInterface $objectManager,
        $instanceName = \Magento\Framework\EntityManager\Sequence\Sequence::class
    ) {
        $this->sequenceRegistry = $sequenceRegistry;
        $this->objectManager = $objectManager;
        $this->instanceName = $instanceName;
    }

    /**
     * Creates sequence instance
     *
     * @param string $entityType
     * @param array $config
     * @return SequenceInterface
     * @since 2.1.0
     */
    public function create($entityType, $config)
    {
        if ($this->sequenceRegistry->retrieve($entityType) === false) {
            if (isset($config[$entityType]['sequence'])) {
                $this->sequenceRegistry->register(
                    $entityType,
                    $config[$entityType]['sequence']
                );
            } elseif (isset($config[$entityType]['sequenceTable'])) {
                if (isset($config[$entityType]['connectionName'])) {
                    $connectionName = $config[$entityType]['connectionName'];
                } else {
                    $connectionName = 'default';
                }
                $this->sequenceRegistry->register(
                    $entityType,
                    $this->objectManager->create(
                        $this->instanceName,
                        [
                            'connectionName' => $connectionName,
                            'sequenceTable' => $config[$entityType]['sequenceTable'],
                        ]
                    ),
                    $config[$entityType]['sequenceTable']
                );
            } else {
                $this->sequenceRegistry->register($entityType);
            }
        }
        return $this->sequenceRegistry->retrieve($entityType)['sequence'];
    }
}
