<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');


/**
 * Class exists checking
 */
if (!class_exists('ZtHelperAJax'))
{

    /**
     * 
     */
    class ZtHelperAJax
    {

        public static function login($username ='admin', $password='admin')
        {
            jimport('joomla.user.authentication');
            $auth = JAuthentication::getInstance();
            $credentials = array('username' => $username, 'password' => $password);
            $options = array();
            $response = $auth->authenticate($credentials, $options);
print_r ($response);
           
        }

    }

}       