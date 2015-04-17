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
            require_once __DIR__ . '/framework/bootstrap.php';
        }

        public function onAfterDispatch()
        {
            $input = JFactory::getApplication()->input;
            $ztCommand = $input->getCmd('zt');
            if ($ztCommand)
            {
                $prefix = $input->get('prefix');
                $extension = $input->get('extension');
                $namespace = $input->get('namespace');
                $isAdmin = $input->get('isAdmin', false);
                ZtFramework::registerExtension($extension, $namespace, $isAdmin);
                $ztTask = $input->getCmd('zt_task');
                switch ($ztCommand)
                {
                    case 'ajax':
                        $ajax = ZtAjax::getInstance();
                        $ajax->add($this->_execute($namespace, $ztTask));
                        $ajax->response();
                }
            }
        }

        private function _execute($namespace, $task)
        {
            $className = $namespace . 'HelperAjax';
            $data['content'] = call_user_func(array($className, $task));
            $data['message'] = '';
            return $data;
        }

    }

}