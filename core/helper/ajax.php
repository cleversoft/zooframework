<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');


/**
 * Class exists checking
 */
if (!class_exists('ZtHelperAjax')) {

    /**
     * 
     */
    class ZtHelperAjax {

        public static function userLogin() {
            $input = JFactory::getApplication()->input;
            $username = $input->get('username');
            $password = $input->get('password');
            return ZtHelperJoomlaUser::login($username, $password);
        }

    }

}       
