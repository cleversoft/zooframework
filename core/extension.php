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
if (!class_exists('ZtExtension')) {

    /**
     * Extension object
     * Extension information that will be used by Framework
     */
    class ZtExtension extends ZtObjectExtension {

        public function init() {
            static $inited = false;
            if ($inited == false) {
                /* Import Zt Assets */
                ZtAssets::import(array(
                    'Zt://assets/js/zt.core.php',
                    'Zt://assets/js/zt.ui.js',
                    'Zt://assets/js/zt.ajax.js',
                    'Zt://assets/js/zt.joomla.js',
                ));
                parent::init();
                $inited = true;
            }
        }

    }

}    
