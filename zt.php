<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Class exists checking
 */
if (!class_exists('plgSystemZt'))
{

    /**
     * Zoo Framework entrypoint plugin
     */
    class plgSystemZt extends JPlugin
    {

        public function __construct(&$subject, $config = array())
        {
            parent::__construct($subject, $config);
            require_once __DIR__ . '/core/bootstrap.php';
        }

        public function onAfterDispatch()
        {
            $input = JFactory::getApplication()->input;
            $ztCommand = $input->getCmd('zt');
            if ($ztCommand)
            {
                $extension = $input->get('extension');
                $namespace = $input->get('namespace');
                $isAdmin = $input->get('isAdmin', false);
                ZtFramework::registerExtension($extension, $namespace, $isAdmin);
                $ztTask = $input->getCmd('zt_task');
                $this->_execute($ztCommand, $ztTask, $namespace);
            }
        }

        private function _execute($ztCommand, $ztTask, $namespace)
        {

            $className = $namespace . 'HelperAjax';
            $return = call_user_func(array($className, $ztTask));
            switch ($ztCommand)
            {
                case 'ajax':
                    $ajax = ZtAjax::getInstance();
                    $ajax->response();
                    break;
            }
        }

    }

}
