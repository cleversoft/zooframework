<?php

/**
 * Zt (http://www.zootemplate.com/zo2)
 * A powerful Joomla template framework
 *
 * @link        http://www.zootemplate.com/zo2
 * @link        https://github.com/cleversoft/zo2
 * @author      ZooTemplate <http://zootemplate.com>
 * @copyright   Copyright (c) 2014 CleverSoft (http://cleversoft.co/)
 * @license     GPL v2
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Class exists checking
 */
if (!class_exists('ZtAssets'))
{

    /**
     * @uses This class used for managed ALL asset stuffs
     * @rule
     * All asset stuffs must be save under <core>|<template>/assets directory
     */
    class ZtAssets
    {

        /**
         * Singleton instance
         * @var ZtAssets
         */
        public static $instance;

        /**
         * Get instance of ZtAssets
         * @return \ZtAssets
         */
        public static function getInstance()
        {
            if (!isset(self::$instance))
            {
                self::$instance = new ZtAssets();
            }
            if (isset(self::$instance))
            {
                return self::$instance;
            }
        }

        /**
         * Get asset file with relative path
         * @param string $key File location    
         * @return boolean|string
         */
        public function getAssetUrl($key)
        {
            return ZtPath::getInstance()->getUrl($key);
        }

        /**
         *
         * @param type $file
         * @return \ZtAssets
         */
        public function addStyleSheet($key)
        {
            $assetFile = $this->getAssetUrl($key);
            if ($assetFile)
            {
                $doc = JFactory::getDocument();
                $doc->addStyleSheet($assetFile);
            }
        }

        /**
         * @param type $file
         *
         * @return \ZtAssets
         */
        public function addScript($key)
        {
            $assetFile = $this->getAssetUrl($file);
            if ($assetFile)
            {
                $doc = JFactory::getDocument();
                $doc->addScript($assetFile);
            }
        }

    }

}    