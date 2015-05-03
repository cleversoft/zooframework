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
if (!class_exists('ZtExtension'))
{


    class ZtExtension
    {

        /**
         * Singleton instance
         * @var ZtExtension
         */
        public static $instance;

        /**
         * Get instance of ZtExtension
         * @return \ZtExtension
         */
        public static function getInstance()
        {
            if (!isset(self::$instance))
            {
                self::$instance = new ZtExtension();
            }
            if (isset(self::$instance))
            {
                return self::$instance;
            }
        }

        public function registerExtension($extension, $namespace, $isAdmin = false)
        {
            $this->_registerPaths($extension, $namespace, $isAdmin = false);
        }

        private function _registerPaths($extension, $namespace, $isAdmin = false)
        {
            $ztPath = ZtPath::getInstance();
            $parts = explode('.', $extension);
            if ($isAdmin)
            {
                $path['root'][] = JPATH_ADMINISTRATOR;
            } else
            {
                $path['root'][] = JPATH_SITE;
            }
            if (isset($parts[0]))
            {
                switch ($parts[0])
                {
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
                self::$registeredExtensions[$parts[0]]['paths'] = $path;
            }
            $ztPath->registerNamespace($namespace, implode(DIRECTORY_SEPARATOR, $path['root']) . DIRECTORY_SEPARATOR . 'core');
            $ztPath->registerNamespace($namespace, implode(DIRECTORY_SEPARATOR, $path['root']) . DIRECTORY_SEPARATOR . 'local');
        }

        public function isExtensionRegistered($extension)
        {
            $session = JFactory::getSession();
            if ($session->get($extension, null, 'Zt'))
            {
                return true;
            } else
            {
                return false;
            }
        }

    }

}    