<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');


/**
 * Class exists checking
 */
if (!class_exists('ZtHelperJoomlaUser'))
{

    /**
     * 
     */
    class ZtHelperJoomlaUser
    {

        public static function login($username, $password)
        {
            jimport('joomla.user.authentication');
            $auth = JAuthentication::getInstance();
            $credentials = array('username' => $username, 'password' => $password);
            $options = array();
            $response = $auth->authenticate($credentials, $options);
            return $response;
        }

        public static function logout()
        {
            
        }

        public static function isLogged()
        {
            return !JFactory::getUser()->guest;
        }

    }

}       