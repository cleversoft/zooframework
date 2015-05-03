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

        public function registerPath($isAdmin) {
            $parts = explode('.', $this->name);
            if ($isAdmin) {
                $path['root'][] = JPATH_ADMINISTRATOR;
            } else {
                $path['root'][] = JPATH_SITE;
            }
            if (isset($parts[0])) {
                switch ($parts[0]) {
                    case 'modules':
                        $path['root'][] = 'modules';
                        $path['root'][] = $parts[1]; // Name
                        $path['template'][] = 'mod_' . $parts[1];
                        break;
                    case 'plugins':
                        $path['root'][] = 'plugins';
                        $path['root'][] = $parts[1]; // Type
                        $path['root'][] = $parts[2]; // Name
                        break;
                    case 'components':
                        $path['root'][] = 'components';
                        $path['root'][] = $parts[1]; // Name
                        $path['template'][] = 'com_' . $parts[1];
                        break;
                }
            }
            $paths[] = implode(DIRECTORY_SEPARATOR, $path['root']) . DIRECTORY_SEPARATOR . 'core';
            $paths[] = implode(DIRECTORY_SEPARATOR, $path['root']) . DIRECTORY_SEPARATOR . 'local';
            $registeredPaths = $this->getPaths();
            foreach ($paths as $path) {
                if (!in_array($path, $registeredPaths)) {
                    $registeredPaths[] = $path;
                }
            }
            $this->set('paths', $registeredPaths);
        }

        public function registerAssets($namespace) {
            ZtFramework::import('Zt://assets.php');
            ZtAssets::import(array(
                $this->namespace . '://assets/js/scripts.js',
                $this->namespace . '://assets/css/styles.css',
            ));
        }

        public function addScript($name) {
            ZtAssets::getInstance()->addScript($this->name . '://assets/js/' . $name);
        }

        public function addStyleSheet($name) {
            ZtAssets::getInstance()->addStyleSheet($this->name . '://assets/css/' . $name);
        }

        public function getPaths() {
            return $this->get('paths', array());
        }

        public function flush() {
            ZtFramework::setSession($this->name, $this);
            $registeredNamespaces = ZtFramework::getSession('namespaces', array());
            if (!in_array($this->name, $registeredNamespaces)) {
                $registeredNamespaces[$this->namespace] = $this->name;
            }
            ZtFramework::setSession('namespaces', $registeredNamespaces);
        }

    }

}    
