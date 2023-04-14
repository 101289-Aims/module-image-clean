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

class CategoryIndex extends \Magento\Backend\App\Action
{
    /**
     * @var $resultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
    }

    /**
     * Get Category List
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Aimsinfosoft_Imageclean::imageclean');
        $resultPage->addBreadcrumb(__('Aimsinfosoft'), __('Aimsinfosoft'));
        $resultPage->addBreadcrumb(__('Imageclean'), __('Imageclean'));
        $resultPage->getConfig()->getTitle()->prepend(__('Categories Images Manager'));
        $this->dataPersistor->clear('imageclean_data');
        return $resultPage;
    }

    /**
     * Check Is Allow
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Aimsinfosoft_Imageclean::categoryimagecleandata');
    }
}
