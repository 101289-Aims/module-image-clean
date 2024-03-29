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

namespace Aimsinfosoft\Imageclean\Controller\Adminhtml\Imageclean;

/**
 * Abstarct Class AbstractImageclean
 *
 * @package Aimsinfosoft\Imageclean\Controller\Adminhtml\Imageclean
 */
abstract class AbstractImageclean extends \Magento\Backend\App\Action
{

    /**
     * Check Is Allow
     */
    protected function _isAllowed()
    {
        if ($this->_authorization->isAllowed('Aimsinfosoft_Imageclean::categoryimagecleandata')) {
            return $this->_authorization->isAllowed('Aimsinfosoft_Imageclean::categoryimagecleandata');
        }
    }
}
