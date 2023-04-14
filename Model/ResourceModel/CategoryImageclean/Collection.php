<?php

/**
 * Aimsinfosoft
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the aimsinfosoft.com license that is
 * available through the world-wide-web at this URL:
 * https://www.aimsinfosoft.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Aimsinfosoft
 * @package     Aimsinfosoft_Imageclean
 * @copyright   Copyright (c) Aimsinfosoft (https://www.aimsinfosoft.com)
 * @license     https://www.aimsinfosoft.com/LICENSE.txt
 */

namespace Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 *
 * @package Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean
 */
class Collection extends AbstractCollection
{
    /**
     * @var $_idFieldName
     */
    protected $_idFieldName = 'imageclean_id';

    /**
     * @var $total
     */
    protected $total;

    /**
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface $connection
     * @param AbstractDb $resource
     *
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    )
    {
        $this->_logger = $logger;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * @param \Aimsinfosoft\Imageclean\Model\CategoryImageclean
     */
    public function _construct()
    {
        $this->_init('Aimsinfosoft\Imageclean\Model\CategoryImageclean', 'Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean');
    }

    /**
     * Get Images
     */
    public function getImages()
    {
        $array = [];
        try {
            $this->setConnection($this->getResource()->getConnection());
            $this->getSelect()->from(['main_table' => $this->getTable('catalog_category_entity_varchar')], '*');
            foreach ($this->getData() as $item) {
                $array[] = $item['value'];
            }
        } catch (\Exception $e) {
            $this->_logger->critical('Error message', ['exception' => $e]);
        }
        return $array;
    }
}
