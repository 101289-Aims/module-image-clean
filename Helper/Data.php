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

namespace Aimsinfosoft\Imageclean\Helper;

use Aimsinfosoft\Imageclean\Model\ImagecleanFactory;
use Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DB\Exception;

class Data extends AbstractHelper {
    /**
     * @var ImagecleanFactory
     */
    protected $_modelImagecleanFactory;
	
	 protected $_modelcategoryImagecleanFactory;


    public function __construct(Context $context, 
        ImagecleanFactory $modelImagecleanFactory,
		CategoryImagecleanFactory $modelcategoryImagecleanFactory)
    {
        $this->_modelImagecleanFactory = $modelImagecleanFactory;
		$this->_modelcategoryImagecleanFactory = $modelcategoryImagecleanFactory;
        parent::__construct($context);
    }


    protected $result = [];
    protected $_mainTable;
    public $valdir = [];

    public function listDirectories($path) 
	{
		$pathOfMedia = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'product';
		
        if (is_dir($path)) 
		{
            if ($dir = opendir($path)) 
			{
                while (($entry = readdir($dir)) !== false) 
				{
                    if (preg_match('/^\./', $entry) != 1) 
					{
                        if (is_dir($path . DIRECTORY_SEPARATOR . $entry) && !in_array($entry, ['cache', 'watermark', 'placeholder'])) 
						{
                            $this->listDirectories($path.DIRECTORY_SEPARATOR.$entry);
                        } 
						elseif (!in_array($entry, ['cache', 'watermark']) && (strpos($entry, '.') != 0)) 
						{
                            //$this->result[] = substr($path.DIRECTORY_SEPARATOR.$entry,25);
							$fullpath = $path.DIRECTORY_SEPARATOR.$entry;
							$finalPath = str_replace($pathOfMedia,"",$fullpath);
							$this->result[] = $finalPath;
                        }
                    }
                }
                closedir($dir);
            }
        }

        return $this->result;
    }

  
    public function compareList() 
	{
        $valores = $this->_modelImagecleanFactory->create()->getCollection()->getImages();
        $pepe = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR .'catalog' . DIRECTORY_SEPARATOR . 'product';
        $leer = $this->listDirectories($pepe);
        $model = $this->_modelImagecleanFactory->create();
		$arr_data = array();
		if(!empty($valores)){
			foreach ($valores as &$str) {
					$arr_data[] = ltrim($str, '//');
			}
		}
		
        foreach ($leer as $item) 
		{
            try 
			{
                $item = str_replace('\\', '/', $item);
				$item = ltrim($item, '/');
				
                if (in_array($item, $arr_data)) 
				{
					$filename = substr(strrchr($item, "/"), 1);
                    $valdir[]['filename'] = $item;
                    $model->setData(['filename' => $item ,'imageurl' => $filename ])->setId(null);
                    $model->save();
                }
            } 
			catch (\Exception $e) 
			{
				$om = \Magento\Framework\App\ObjectManager::getInstance();
				$storeManager = $om->get('Psr\Log\LoggerInterface');
				$storeManager->info($e->getMessage());
			} 
        }
    }
	
	
	
	 public function listCatelogDirectories($path) 
	{
		$pathOfMedia = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'category';
		
        if (is_dir($path)) 
		{
            if ($dir = opendir($path)) 
			{
                while (($entry = readdir($dir)) !== false) 
				{
                    if (preg_match('/^\./', $entry) != 1) 
					{
                        if (is_dir($path . DIRECTORY_SEPARATOR . $entry) && !in_array($entry, ['cache', 'watermark', 'placeholder'])) 
						{
                            $this->listCatelogDirectories($path.DIRECTORY_SEPARATOR.$entry);
                        } 
						elseif (!in_array($entry, ['cache', 'watermark']) && (strpos($entry, '.') != 0)) 
						{
                            //$this->result[] = substr($path.DIRECTORY_SEPARATOR.$entry,25);
							$fullpath = $path.DIRECTORY_SEPARATOR.$entry;
							$finalPath = str_replace($pathOfMedia,"",$fullpath);
							$this->result[] = $finalPath;
                        }
                    }
                }
                closedir($dir);
            }
        }

        return $this->result;
    }
	
	public function compareCatelogList() 
	{
		
        $valores = $this->_modelcategoryImagecleanFactory->create()->getCollection()->getImages();
        $pepe = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'category';
		$pub = '/media/catalog/category';
        $leer = $this->listCatelogDirectories($pepe);




        $model = $this->_modelcategoryImagecleanFactory->create();
        foreach ($leer as $item) 
		{
            try 
			{
                $item = str_replace('\\', '/', $item);
				//$item = substr_replace($item, '//', 0 , 1);
				$item  = $pub . $item;

            
                if (!in_array($item, $valores)) 
				{   
					$filename = substr(strrchr($item, "/"), 1);
                    $valdir[]['filename'] = $item;
                    $model->setData(['filename' => $item ,'imageurl' => $filename ])->setId(null);
                    $model->save();
                }
            } 
			catch (\Exception $e) 
			{
				$om = \Magento\Framework\App\ObjectManager::getInstance();
				$storeManager = $om->get('Psr\Log\LoggerInterface');
				$storeManager->info($e->getMessage());
			} 
			
        }
	
    }

}
