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

use Aimsinfosoft\Imageclean\Helper\Data as HelperData;
use Magento\Backend\App\Action\Context;

class Newcategory extends AbstractImageclean
{
    /**
     * @var HelperData
     */
    protected $_helperData;

    public function __construct(Context $context, 
        HelperData $helperData)
    {
        $this->_helperData = $helperData;

        parent::__construct($context);
    }

    public function execute() {
        $this->_helperData->compareCatelogList();
        $this->_redirect('*/*/categoryindex');
    }
}
