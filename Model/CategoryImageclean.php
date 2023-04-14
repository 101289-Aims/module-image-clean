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
use Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean as CategoryClean;

/**
 * Class CategoryImageclean
 *
 * @package Aimsinfosoft\Imageclean\Model
 */
class CategoryImageclean extends AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{

    public const CACHE_TAG = 'imageclean_id';

    /**
     * @param \Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean
     */
    protected function _construct()
    {
        $this->_init('Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean');
    }

    /**
     * Get Identities
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
