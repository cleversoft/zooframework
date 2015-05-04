<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');


/**
 * Class exists checking
 */
if (!class_exists('ZtHelperAJax')) {

    /**
     * 
     */
    class ZtHelperAJax {

        public static function userLogin() {
            $input = JFactory::getApplication()->input;
            $username = $input->get('username');
            $password = $input->get('password');
            print_r (ZtHelperJoomlaUser::login($username, $password));
        }

    }

}       
