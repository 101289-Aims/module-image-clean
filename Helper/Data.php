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

use Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\DB\Exception;
use Magento\Framework\Filesystem\Driver\File as DriverFile;

/**
 * Class Data
 *
 * @package Aimsinfosoft\Imageclean\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var ImagecleanFactory
     */
    protected $_modelcategoryImagecleanFactory;

    /**
     * @var $result
     */
    protected $result = [];

    /**
     * @var $valdir
     */
    public $valdir = [];

    /**
     * @var $_logger
     */
    protected $_logger;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Aimsinfosoft\Imageclean\Model\CategoryImagecleanFactory $modelcategoryImagecleanFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param Magento\Framework\Filesystem\Driver\File $driverFile
     */
    public function __construct(
        Context $context,
        CategoryImagecleanFactory $modelcategoryImagecleanFactory,
        \Psr\Log\LoggerInterface $logger,
        DriverFile $driverFile
    )
    {
        $this->_modelcategoryImagecleanFactory = $modelcategoryImagecleanFactory;
        $this->_logger = $logger;
        $this->driverFile = $driverFile;
        parent::__construct($context);
    }

    public function listCatelogDirectories($path)
    {
        $pathOfMedia = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'category';
        if ($this->driverFile->isDirectory($path)) {
            if ($dir = opendir($path)) {
                while (($entry = readdir($dir)) !== false) {
                    if (preg_match('/^\./', $entry) != 1) {
                        if ($this->driverFile->isDirectory($path . DIRECTORY_SEPARATOR . $entry) && !in_array($entry, ['cache', 'watermark', 'placeholder'])) {
                            $this->listCatelogDirectories($path . DIRECTORY_SEPARATOR . $entry);
                        } elseif (!in_array($entry, ['cache', 'watermark']) && (strpos($entry, '.') !== 0)) {
                            $fullpath = $path . DIRECTORY_SEPARATOR . $entry;
                            $finalPath = str_replace($pathOfMedia, "", $fullpath);
                            $this->result[] = $finalPath;
                        }
                    }
                }
                closedir($dir);
            }
        }
        return $this->result;
    }

    /**
     * Compare Catelog List
     */
    public function compareCatelogList()
    {
        $valores = $this->_modelcategoryImagecleanFactory->create()->getCollection()->getImages();
        $pepe = BP . DIRECTORY_SEPARATOR . 'pub' . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR . 'category';
        $pub = '/media/catalog/category';
        $leer = $this->listCatelogDirectories($pepe);
        $model = $this->_modelcategoryImagecleanFactory->create();
        foreach ($leer as $item) {
            try {
                $item = str_replace('\\', '/', $item);
                $item = $pub . $item;
                if (!in_array($item, $valores)) {
                    $filename = substr(strrchr($item, "/"), 1);
                    $valdir[]['filename'] = $item;
                    $model->setData(['filename' => $item, 'imageurl' => $filename])->setId(null);
                    $model->save();
                }
            } catch (\Exception $e) {
                $this->_logger->critical('Error message', ['exception' => $e]);
            }
        }
    }
}
