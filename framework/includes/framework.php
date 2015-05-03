<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

if (!class_exists('ZtFramework'))
{

    class ZtFramework
    {

        public static $registeredExtensions;

        public static function registerExtension($extension, $namespace, $isAdmin = false)
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

        protected static function isExtensionRegistered($extension, $namespace, $isAdmin = false)
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

        public static function import($key)
        {
            $path = ZtPath::getInstance();
            $filePath = $path->getPath($key);
            if ($filePath)
            {
                return require_once $filePath;
            }
            return false;
        }

        public static function addStyleSheet($key)
        {
            return ZtAssets::getInstance()->addStyleSheet($key);
        }

        public static function isAjax()
        {
            $input = JFactory::getApplication()->input;
            if ($input->get('zt') == 'ajax')
            {
                return true;
            }
            return false;
        }

    }

}