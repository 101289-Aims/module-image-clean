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

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'imageclean_id';
    protected $total;
    public function __construct(EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null)
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    public function _construct()
    {
        $this->_init('Aimsinfosoft\Imageclean\Model\CategoryImageclean','Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean');
    }

    public function getImages()
    {
        $array = [];
        try {

            $this->setConnection($this->getResource()->getConnection());
            $this->getSelect()->from(['main_table' => $this->getTable('catalog_category_entity_varchar')], '*');
           

            // $this->getSelect()->joinLeft(array('table_two' => 'catalog_category_entity_varchar_value'),
   //                                            'main_table.value_id = table_two.value_id');
            //  $this->addFieldToFilter('table_two.value_id', array('null' => true) );

            //echo '<pre>-----';print_r($imgC->getData());echo '</pre>';die;
//          echo $this->getSelect()->__toString();  exit;
         // echo "<pre>";  print_r($this->getData());
         // die();
            foreach ($this->getData() as $item) {
                $array[] = $item['value'];
            }


            
          
         

        }
        catch (\Exception $e)
        {
            $om = \Magento\Framework\App\ObjectManager::getInstance();
            $storeManager = $om->get('Psr\Log\LoggerInterface');
            $storeManager->info($e->getMessage());
        }
        return $array;
    }

}
