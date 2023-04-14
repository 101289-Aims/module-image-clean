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

namespace Aimsinfosoft\Imageclean\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class Imageclean
 *
 * @package Aimsinfosoft\Imageclean\Block
 */
class Imageclean extends Template
{
    /**
     * @var \Magento\Framework\Registry $_frameworkRegistry
     */
    protected $_frameworkRegistry;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Registry $_frameworkRegistry
     * @param array $data[]
     */
    public function __construct(
        Context $context,
        Registry $frameworkRegistry,
        array $data = []
    )
    {
        $this->_frameworkRegistry = $frameworkRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Get Image Clean
     */
    public function getImageclean()
    {
        if (!$this->hasData('imageclean')) {
            $this->setData('imageclean', $this->_frameworkRegistry->registry('imageclean'));
        }
        return $this->getData('imageclean');
    }
}
