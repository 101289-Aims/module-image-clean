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

namespace Aimsinfosoft\Imageclean\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Categorydeleteimage extends Column
{
	const ROW_EDIT_URL = 'imageclean/imageclean/deletecategory';
	
	protected $_urlBuilder;
    /**
     * @var string
     */
    private $_editUrl;
 
    /**
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     * @param string             $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::ROW_EDIT_URL
    ) 
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
	
	public function prepareDataSource(array $dataSource)
    {
		if (isset($dataSource['data']['items'])) 
		{
            foreach ($dataSource['data']['items'] as &$item) 
			{
                $name = $this->getData('filename');	
                if (isset($item['imageclean_id'])) 
				{
                    $item['actions']['delete'] = [
                        'href' => $this->_urlBuilder->getUrl(
                            $this->_editUrl, 
                            ['id' => $item['imageclean_id']]
                        ),
                        'label' => __('Delete'),
						'confirm' => [
                            'title' => __('Delete'),
                            'message' => __('Are you sure you wan\'t to delete a Image?')
                        ]
                    ];
                }
            }
        }
		
        return $dataSource;
    }
}