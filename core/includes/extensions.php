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
if (!class_exists('ZtExtensions')) {
    require_once __DIR__ . '/../object/extension.php';

    class ZtExtensions {

        /**
         * Singleton instance
         * @var ZtExtension
         */
        public static $instance;
        private $_extensions;

        /**
         * Get instance of ZtExtension
         * @return \ZtExtension
         */
        public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$instance = new ZtExtensions();
            }
            if (isset(self::$instance)) {
                return self::$instance;
            }
        }

        /**
         * Get extension object
         * @param type $name
         * @return \JObject
         */
        public function get($name) {
            if (empty($this->_extensions[$name])) {
                $this->_extensions[$name] = new ZtObjectExtension();
            }
            return $this->_extensions[$name];
        }

        public function set($name, $extension) {
            $this->_extensions[$name] = $extension;
        }

        /**
         * 
         * @param type $name
         * @param type $namespace
         * @param boolean $isAdmin
         */
        public function registerExtension($name, $namespace, $isAdmin = false) {

            if (empty($this->_extensions[$name])) {
                $extension = new ZtObjectExtension();
                $extension->set('name', $name);
                $extension->set('namespace', $namespace);
                $extension->registerPath($isAdmin);
                $extension->flush();
                $this->set($name, $extension);
            }
        }

    }

}    
