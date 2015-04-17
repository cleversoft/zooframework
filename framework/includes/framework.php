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
                    case 'module':
                        $path['root'][] = 'modules';
                        $path['root'][] = $parts[1]; // Name
                        $path['template'][] = 'mod_' . $parts[1];
                        break;
                    case 'plugin':
                        $path['root'][] = 'plugins';
                        $path['root'][] = $parts[1]; // Type
                        $path['root'][] = $parts[2]; // Name
                        break;
                    case 'component':
                        $path['root'][] = 'components';
                        $path['root'][] = $parts[1]; // Name
                        $path['template'][] = 'com_' . $parts[1];
                        break;
                }
            }
            $ztPath->registerNamespace($namespace, implode(DIRECTORY_SEPARATOR, $path['root']) . DIRECTORY_SEPARATOR . 'core');
            $ztPath->registerNamespace($namespace, implode(DIRECTORY_SEPARATOR, $path['root']) . DIRECTORY_SEPARATOR . 'local');
        }

    }

}