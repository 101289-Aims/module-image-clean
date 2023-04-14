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

use Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory;
use Magento\Backend\App\Action\Context;

class DeleteCategory extends AbstractImageclean
{
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory $modelImagecleanFactory
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     */
    public function __construct(
        Context $context,
        CategoryImagecleanFactory $modelImagecleanFactory,
        \Magento\Framework\Filesystem\Driver\File $fileDriver
    )
    {
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        $this->fileDriver = $fileDriver;
        parent::__construct($context);
    }

    /**
     * Delete Category Image
     */
    public function execute()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $mediaPath = BP . '/pub';
                $model = $this->_modelImagecleanFactory->create();
                $model->load($this->getRequest()->getParam('id'));
                if ($this->fileDriver->isExists($mediaPath . $model->getFilename())) {
                    try {
                        $this->fileDriver->deleteFile($mediaPath . $model->getFilename());
                    } catch (\Exception $e) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
                $model->setId($this->getRequest()->getParam('id'))->delete();
                $this->messageManager->addSuccess(__('Image was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        $this->_redirect('*/*/newcategory');
    }
}
