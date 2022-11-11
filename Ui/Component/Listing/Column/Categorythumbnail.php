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
use Magento\Store\Model\StoreManagerInterface;

class Categorythumbnail extends Column
{
	const ALT_FIELD = 'caption_text';
	protected $storeManager;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

	public function prepareDataSource(array $dataSource)
    {
		$_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$storeManager = $_objectManager->get('Magento\Store\Model\StoreManagerInterface');
		$currentStore = $storeManager->getStore();
		$mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        if(isset($dataSource['data']['items']))
		{

            $fieldName = $this->getData('name');
            foreach($dataSource['data']['items'] as & $item)
			{

                $url = 'catalog/category/';
                if($item[$fieldName] != '')
				{

                    $url.= $item['imageurl'];
                }
                $item[$fieldName . '_src'] = $mediaUrl . $url;
                $item[$fieldName . '_alt'] = $this->getAlt($item) ?: '';
                $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                    'imageclean/imageclean/CategoryIndex',
                    ['id' => $item['imageclean_id']]
                );
                $item[$fieldName . '_orig_src'] = $mediaUrl . $url;
            }
        }

        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}
