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
use Aimsinfosoft\Imageclean\Model\ResourceModel\Imageclean\CollectionFactory;
use Aimsinfosoft\Imageclean\Model\ImagecleanFactory;

class AllDelete extends \Magento\Backend\App\Action
{
    protected $filter;
    protected $collectionFactory;
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, ImagecleanFactory $modelImagecleanFactory)
    {
        
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        parent::__construct($context);
    }

    public function execute() 
    {
        if ($this->getRequest()->getParam('id') > 0) 
        {
            try 
            {
                $mediaPath = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'product/';
                
                $model = $this->_modelImagecleanFactory->create();
                $model->load($this->getRequest()->getParam('id'));
				if(file_exists($mediaPath.$model->getFilename())){
					 try{
						unlink($mediaPath.$model->getFilename());
					}
					catch (\Exception $e){
					}
				}
                $model->setId($this->getRequest()->getParam('id'))->delete();

                $this->messageManager->addSuccess(__('Image was successfully deleted'));
                $this->_redirect('*/*/');
            } 
            catch (\Exception $e) 
            {
                $this->messageManager->addError($e->getMessage());
                $this->_redirect('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        $this->_redirect('*/*/');
    }
}
