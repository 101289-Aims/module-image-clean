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

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

	public function __construct(\Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

	public function execute()
    {

        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('Aimsinfosoft_Imageclean::imageclean');

        $resultPage->addBreadcrumb(__('Aimsinfosoft'), __('Aimsinfosoft'));

        $resultPage->addBreadcrumb(__('Imageclean'), __('Imageclean'));
        $resultPage->getConfig()->getTitle()->prepend(__('Products Images Manager'));

		$dataPersistor = $this->_objectManager->get('Magento\Framework\App\Request\DataPersistorInterface');
        $dataPersistor->clear('imageclean_data');

        return $resultPage;
    }

	protected function _isAllowed()
    {
		return $this->_authorization->isAllowed('Aimsinfosoft_Imageclean::imageclean');
    }
}
