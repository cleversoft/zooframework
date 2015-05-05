<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

if (!class_exists('ZtFramework')) {

    class ZtFramework {

        public static function getSession($name, $default = null) {
            $session = JFactory::getSession();
            return $session->get($name, $default, 'Zt');
        }

        public static function setSession($name, $value) {
            $session = JFactory::getSession();
            return $session->set($name, $value, 'Zt');
        }

        public static function registerExtension($file) {
            if (JFile::exists($file)) {
                $content = file_get_contents($file);
                $extension = json_decode($content);
                ZtExtensions::getInstance()->register($extension);
            }
        }

        public static function getExtension($namespace, $flush = false) {
            static $extensions;
            if (!isset($extensions[$namespace]) || $flush) {
                $className = $namespace . 'Extension';
                $extensions[$namespace] = new $className(ZtExtensions::getInstance()->get($namespace));
            }
            return $extensions[$namespace];
        }

        public static function import($key) {
            $path = ZtPath::getInstance();
            $filePath = $path->getPath($key);
            if ($filePath) {
                return require_once $filePath;
            }
            return false;
        }

        public static function addStyleSheet($key) {
            return ZtAssets::getInstance()->addStyleSheet($key);
        }

        public static function isAjax() {
            $input = JFactory::getApplication()->input;
            if ($input->get('zt') == 'ajax') {
                return true;
            }
            return false;
        }

        public static function restart() {
            JFactory::getSession()->restart();
        }

    }

}
