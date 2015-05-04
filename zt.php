<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Class exists checking
 */
if (!class_exists('plgSystemZt')) {

    /**
     * Zoo Framework entrypoint plugin
     */
    class plgSystemZt extends JPlugin {

        public function __construct(&$subject, $config = array()) {
            parent::__construct($subject, $config);
            require_once __DIR__ . '/core/bootstrap.php';
        }

        public function onAfterDispatch() {
            $input = JFactory::getApplication()->input;
            $ztCommand = $input->getCmd('zt_cmd');
            $ztCommand = explode('.', $ztCommand);
            if ($ztCommand[0]) {
                if ($ztCommand[0] = 'ajax') {
                    $class = $input->get('zt_namespace') . 'HelperAjax';
                    $task = $input->get('zt_task');                    
                    if (class_exists($class)) {
                        $data = call_user_func(array($class, $task));
                        $ajax = ZtAjax::getInstance();
                        call_user_func_array(array($ajax, $ztCommand[1]), $data);
                        $ajax->response();
                    }
                }
            }
        }

        private function _execute($ztCommand, $ztTask, $namespace) {

            $className = $namespace . 'HelperAjax';
            $return = call_user_func(array($className, $ztTask));
            switch ($ztCommand) {
                case 'ajax':
                    $ajax = ZtAjax::getInstance();
                    $ajax->response();
                    break;
            }
        }

    }

}
