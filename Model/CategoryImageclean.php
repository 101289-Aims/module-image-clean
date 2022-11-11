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

namespace Aimsinfosoft\Imageclean\Model;

use Magento\Framework\Model\AbstractModel;

class CategoryImageclean extends AbstractModel implements \Magento\Framework\DataObject\IdentityInterface {

	const CACHE_TAG = 'imageclean_id';

    protected function _construct()
	{
        $this->_init('Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean');
    }

	public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

}
