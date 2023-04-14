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

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean\CollectionFactory;
use Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory;

/**
 * Class MassCategorydelete
 *
 * @package Aimsinfosoft\Imageclean\Controller\Adminhtml\Imageclean
 */
class MassCategorydelete extends \Magento\Backend\App\Action
{

    /**
     * @var $filter
     */
    protected $filter;

    /**
     * @var $collectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory $_modelImagecleanFactory
     */
    protected $_modelImagecleanFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Aimsinfosoft\Imageclean\Model\ResourceModel\CategoryImageclean\CollectionFactory $collectionFactory
     * @param \Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory $modelImagecleanFactory
     * @param \Magento\Framework\Filesystem\Driver\File $fileDriver
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CategoryImagecleanFactory $modelImagecleanFactory,
        \Magento\Framework\Filesystem\Driver\File $fileDriver
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        $this->fileDriver = $fileDriver;
        parent::__construct($context);
    }

    /**
     * Delete Mass Category Image
     */
    public function execute()
    {
        if ($this->getRequest()->getParam("selected") == null) {
            $collection = $this->filter->getCollection(
                $this->collectionFactory->create()
            );
            $collectionSize = $collection->getSize();
            $mediaPath = BP . "/pub";
            foreach ($collection as $item) {
                $model = $this->_modelImagecleanFactory->create();
                $model->load($item->getImagecleanId());
                if ($this->fileDriver->isExists($mediaPath . $model->getFilename())) {
                    try {
                        $this->fileDriver->deleteFile($mediaPath . $model->getFilename());
                    } catch (\Exception $e) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }
                $item->delete();
            }
            $this->messageManager->addSuccess(
                __("A total of %1 image(s) have been deleted.", $collectionSize)
            );
            /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
            $resultRedirect = $this->resultFactory->create(
                ResultFactory::TYPE_REDIRECT
            );
            return $resultRedirect->setPath("*/*/newcategory");
        }
        if (is_array($this->getRequest()->getParam("selected"))) {
            try {
                for ($i = 0;$i < count($this->getRequest()->getParam("selected"));$i++) 
                {
                    $mediaPath = BP . "/pub";
                    $model = $this->_modelImagecleanFactory->create();
                    $model->load($this->getRequest()->getParam("selected")[$i]);
                    if ($this->fileDriver->isExists($mediaPath . $model->getFilename())) {
                        try {
                            $this->fileDriver->deleteFile($mediaPath . $model->getFilename());
                        } catch (\Exception $e) {
                            $this->messageManager->addError($e->getMessage());
                        }
                    }
                    $model
                        ->setId($this->getRequest()->getParam("selected")[$i])
                        ->delete();
                }
                $this->messageManager->addSuccess(
                    __("Image was successfully deleted")
                );
                $this->_redirect("*/*/");
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect("*/*/edit", [
                    "id" => $this->getRequest()->getParam("id"),
                ]);
            }
        }
        $this->_redirect("*/*/newcategory");
    }
}
