<?php

/**
 * ZooFramework (http://www.zootemplate.com)
 * A powerful Joomla framework
 *
 * @version     1.0.0
 * @link        http://www.zootemplate.com
 * @link        https://github.com/cleversoft/
 * @author      ZooTemplate <http://zootemplate.com>
 * @copyright   Copyright (c) 2015 CleverSoft (http://cleversoft.co/)
 * @license     GPL v2
 */

defined('_JEXEC') or die();


class PlgSystemZooFrameworkInstallerScript
{
    /**
     * Called after any type of action
     *
     * @param     string              $route      Which action is happening (install|uninstall|discover_install)
     * @param     jadapterinstance    $adapter    The object responsible for running this script
     *
     * @return    boolean                         True on success
     */
    public function postFlight($route, JAdapterInstance $adapter)
    {
        $db    = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query
            ->update('#__extensions')
            ->set("`enabled`='1'")
            ->where("`type`='plugin'")
            ->where("`folder`='system'")
            ->where("`element`='zooframework'");
        $db->setQuery($query);
        $db->execute();
        
        return true;
    }
}
