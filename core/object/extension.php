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
if (!class_exists('ZtObjectExtension')) {

    /**
     * Extension object
     * Extension information that will be used by Framework
     */
    class ZtObjectExtension extends JObject {

        public function addScript($name) {
            ZtAssets::getInstance()->addScript($this->name . '://assets/js/' . $name);
        }

        public function addStyleSheet($name) {
            ZtAssets::getInstance()->addStyleSheet($this->name . '://assets/css/' . $name);
        }

        public function getPaths() {
            return $this->get('paths', array());
        }

        public function init() {
            ZtAssets::import(array(
                $this->namespace . '://assets/js/scripts.js',
                $this->namespace . '://assets/css/styles.css',
            ));
        }

    }

}    
