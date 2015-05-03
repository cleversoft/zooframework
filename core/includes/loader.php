<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Class exists checking
 */
if (!class_exists('ZtLoader'))
{

    /**
     * Zt Loader class
     */
    class ZtLoader
    {

        /**
         * 
         * @param string $className
         */
        public static function autoloadZtPsr2($className)
        {           
            if (substr($className, 0, 1) != 'J')
            {
                $path = ZtPath::getInstance();
                $filePath = $path->getPathByClassname($className);                
                if ($filePath)
                {
                    return require_once $filePath;
                }
            }
            return false;
        }

    }

}