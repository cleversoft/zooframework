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

            JPluginHelper::importPlugin('user');
            $options = array();
            $options['action'] = 'core.login.site';
            $result = JFactory::getApplication()->triggerEvent('onUserLogin', array((array) $response, $options));
            return $result;
        }

        public static function logout()
        {
            
        }

        public static function isLogged()
        {
            return !JFactory::getUser()->guest;
        }

        /**
         * Register Joomla! new user
         * @param type $data
         * @return boolean|string
         */
        public static function registerUser($data)
        {

            // Filter datas
            $_data = array(
                'name',
                'username',
                'password1',
                'password2',
                'email1',
                'email2',
            );
            foreach ($_data as $value)
            {
                if (isset($data[$value]))
                {
                    $_data[$value] = $data[$value];
                }
            }
            $data = $_data;

            // Get com_users params
            $params = JComponentHelper::getParams('com_users');

            // Initialise the table with JUser.
            $user = new JUser;

            // Get the groups the user should be added to after registration.
            $data['groups'] = array();

            // Get the default new user group, Registered if not specified.
            $system = $params->get('new_usertype', 2);
            $data['groups'][] = $system;

            // Prepare the data for the user object.            
            $data['email'] = JStringPunycode::emailToPunycode($data['email1']);
            $data['password'] = $data['password1'];
            $useractivation = $params->get('useractivation');
            $sendpassword = $params->get('sendpassword', 1);

            // Check if the user needs to activate their account.
            if (($useractivation == 1) || ($useractivation == 2))
            {
                $data['activation'] = JApplicationHelper::getHash(JUserHelper::genRandomPassword());
                $data['block'] = 1;
            }

            // Bind the data.
            if (!$user->bind($data))
            {
                return false;
            }

            // Load the users plugin group.
            JPluginHelper::importPlugin('user');

            // Store the data.
            if (!$user->save())
            {
                return false;
            }

            $message[] = 'User created';

            $config = JFactory::getConfig();
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            // Compile the notification mail values.
            $data = $user->getProperties();
            $data['fromname'] = $config->get('fromname');
            $data['mailfrom'] = $config->get('mailfrom');
            $data['sitename'] = $config->get('sitename');
            $data['siteurl'] = JUri::root();

            // Handle account activation/confirmation emails.
            if ($useractivation == 2)
            {
                // Set the link to confirm the user email.
                $uri = JUri::getInstance();
                $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
                $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

                $emailSubject = JText::sprintf(
                                'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
                );

                if ($sendpassword)
                {
                    $emailBody = JText::sprintf(
                                    'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']
                    );
                } else
                {
                    $emailBody = JText::sprintf(
                                    'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']
                    );
                }
            } elseif ($useractivation == 1)
            {
                // Set the link to activate the user account.
                $uri = JUri::getInstance();
                $base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));
                $data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

                $emailSubject = JText::sprintf(
                                'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
                );

                if ($sendpassword)
                {
                    $emailBody = JText::sprintf(
                                    'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username'], $data['password_clear']
                    );
                } else
                {
                    $emailBody = JText::sprintf(
                                    'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW', $data['name'], $data['sitename'], $data['activate'], $data['siteurl'], $data['username']
                    );
                }
            } else
            {
                $emailSubject = JText::sprintf(
                                'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
                );

                if ($sendpassword)
                {
                    $emailBody = JText::sprintf(
                                    'COM_USERS_EMAIL_REGISTERED_BODY', $data['name'], $data['sitename'], $data['siteurl'], $data['username'], $data['password_clear']
                    );
                } else
                {
                    $emailBody = JText::sprintf(
                                    'COM_USERS_EMAIL_REGISTERED_BODY_NOPW', $data['name'], $data['sitename'], $data['siteurl']
                    );
                }
            }

            // Send the registration email.
            $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

            // Send Notification mail to administrators
            if (($params->get('useractivation') < 2) && ($params->get('mail_to_admin') == 1))
            {
                $emailSubject = JText::sprintf(
                                'COM_USERS_EMAIL_ACCOUNT_DETAILS', $data['name'], $data['sitename']
                );

                $emailBodyAdmin = JText::sprintf(
                                'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY', $data['name'], $data['username'], $data['siteurl']
                );

                // Get all admin users
                $query->clear()
                        ->select($db->quoteName(array('name', 'email', 'sendEmail')))
                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('sendEmail') . ' = ' . 1);

                $db->setQuery($query);

                try
                {
                    $rows = $db->loadObjectList();
                } catch (RuntimeException $e)
                {

                    //$message[] = JText::sprintf('COM_USERS_DATABASE_ERROR', (string)$e->getMessage());
                }

                // Send mail to all superadministrators id
                foreach ($rows as $row)
                {
                    $return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

                    // Check for an error.
                    if ($return !== true)
                    {
                        $message[] = JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED');
                    }
                }
            }

            // Check for an error.
            if ($return !== true)
            {
                //$this->setError(JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));
                // Send a system message to administrators receiving system mails
                $db = JFactory::getDbo();
                $query->clear()
                        ->select($db->quoteName(array('name', 'email', 'sendEmail', 'id')))
                        ->from($db->quoteName('#__users'))
                        ->where($db->quoteName('block') . ' = ' . (int) 0)
                        ->where($db->quoteName('sendEmail') . ' = ' . (int) 1);
                $db->setQuery($query);

                try
                {
                    $sendEmail = $db->loadColumn();
                } catch (RuntimeException $e)
                {
                    $message[] = JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED');
                }

                if (count($sendEmail) > 0)
                {
                    $jdate = new JDate;

                    // Build the query to add the messages
                    foreach ($sendEmail as $userid)
                    {
                        $values = array(
                            $db->quote($userid),
                            $db->quote($userid),
                            $db->quote($jdate->toSql()),
                            $db->quote(JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')),
                            $db->quote(JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username']))
                        );
                        $query->clear()
                                ->insert($db->quoteName('#__messages'))
                                ->columns($db->quoteName(array('user_id_from', 'user_id_to', 'date_time', 'subject', 'message')))
                                ->values(implode(',', $values));
                        $db->setQuery($query);

                        try
                        {
                            $db->execute();
                        } catch (RuntimeException $e)
                        {
                            //$message[] = JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage());
                        }
                    }
                }

                //return false;
            }

            if ($useractivation == 1)
            {
                $message[] = 'Waiting for activation';
            } elseif ($useractivation == 2)
            {
                $message[] = 'Waiting for admin activation';
            } else
            {
                $message[] = 'Register success';
            }
            $_return ['status'] = true;
            $_return ['message'] = $message;
            return $_return;
        }

    }

}       
