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

class MassCategorydelete extends \Magento\Backend\App\Action
{
	protected $filter;
	protected $collectionFactory;
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory, CategoryImagecleanFactory $modelImagecleanFactory)
    {
		
		$this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
        parent::__construct($context);
    }

    public function execute() 
	{
		$collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
		$mediaPath = BP . DIRECTORY_SEPARATOR . 'pub';
        foreach ($collection as $item) 
		{
			$model = $this->_modelImagecleanFactory->create();
			$model->load($item->getImagecleanId());
        	if(file_exists($mediaPath.$model->getFilename())){
				   try{
						unlink($mediaPath.$model->getFilename());
					}
					catch (\Exception $e){
					}
			}
            $item->delete();
        }

        $this->messageManager->addSuccess(__('A total of %1 image(s) have been deleted.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/newcategory');

    }
}
