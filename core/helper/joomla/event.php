<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');


/**
 * Class exists checking
 */
if (!class_exists('ZtHelperJoomlaEvent'))
{

    /**
     * 
     */
    class ZtHelperJoomlaEvent
    {

        public static function trigger($pluginType, $event, $args = array())
        {
            // Note JDispatcher is deprecated in favour of JEventDispatcher in Joomla 3.x however still works.
            JPluginHelper::importPlugin($pluginType);
            $app = JFactory::getApplication();
            return $app->triggerEvent($event, $args);
        }

    }

}
