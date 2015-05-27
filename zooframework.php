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
    class plgSystemZooframework extends JPlugin
    {

        public function __construct(&$subject, $config = array())
        {
            parent::__construct($subject, $config);
            require_once __DIR__ . '/core/bootstrap.php';

            if (JFactory::getApplication()->isSite())
            {
                if ($this->params->get('assets_bs3', 0))
                {
                    ZtAssets::getInstance()->loadVendor('bootstrap', array(
                        'css/bootstrap.css',
                        'js/bootstrap.js'
                    ));
                }
            }
        }

        public function onAfterDispatch()
        {
            $input = JFactory::getApplication()->input;
            $ztCommand = $input->getCmd('zt_cmd');

            if ($ztCommand)
            {
                switch ($ztCommand)
                {
                    case 'ajax':
                        $class = $input->get('zt_namespace') . 'HelperAjax';
                        $task = $input->get('zt_task');
                        if (class_exists($class))
                        {
                            call_user_func(array($class, $task));
                            $ajax = ZtAjax::getInstance();
                            $ajax->response();
                        }
                        break;
                }
            }
        }

    }

}
