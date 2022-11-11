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

namespace Aimsinfosoft\Imageclean\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
   
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'orderstatus'
         */
		if(version_compare($context->getVersion(), '1.0.1', '<')) {
			$table = $installer->getConnection()
				->newTable($installer->getTable('categoryimageclean'))
				->addColumn(
					'imageclean_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					['identity' => true,'nullable' => false,'primary' => true,'unsigned' => true],
					'ID'
				)
				->addColumn(
					'filename',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable' => false],
					'Filename'
				)
				->addColumn(
					'imageurl',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable' => false],
					'Imageurl'
				)
				->addIndex(
					$installer->getIdxName(
						'imageclean',
						['filename'],
						\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
					),
					['filename'],
					['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
				);
			$installer->getConnection()->createTable($table);
		}
    }
}