<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');


/**
 * Class exists checking
 */
if (!class_exists('ZtAjax'))
{

    /**
     * Zt ajax class
     */
    class ZtAjax
    {

        /**
         * Responses data
         * @var array
         */
        protected $_responses = array();

        /**
         * 
         * @staticvar ZtAjax $instance
         * @return \ZtAjax
         */
        public static function getInstance()
        {
            static $instance;
            if (!isset($instance))
            {
                $instance = new ZtAjax();
            }
            return $instance;
        }

        /**
         * Add response data
         * @param mixed $data
         * @param string $key
         * @return \ZtAjax
         */
        public function add($data, $key = 'global')
        {
            $this->_responses[$key][] = $data;
            return $this;
        }

        /**
         * Add HTML to client side
         * @param type $html
         * @param type $target
         * @return \ZtAjax
         */
        public function addHtml($html, $target = '')
        {
            $data = new stdClass();
            $data->html = $html;
            $data->target = $target;
            return $this->add($data, 'html');
        }

        /**
         * Append HTML to client side
         * @param type $html
         * @param type $target
         * @return \ZtAjax
         */
        public function appendHtml($html, $target = '')
        {
            $data = new stdClass();
            $data->html = $html;
            $data->target = $target;
            return $this->add($data, 'appendHtml');
        }

        /**
         * Add notice message
         * @param type $message
         * @param type $type
         * @return \ZtAjax
         */
        public function addMessage($message, $header = '', $type = 'info')
        {
            switch ($type)
            {
                case 'error':
                case 'danger':
                case 'alert':
                    $messageType = 'error';
                    break;
                case 'warning':
                    $messageType = 'warning';
                    break;
                case 'success':
                case 'message':
                case '':
                    $messageType = 'success';
                    break;
                default:
                    $messageType = 'info';
                    break;
            }
            $html = new ZtHtml();
            $html->set('header', $header);
            $html->set('message', $message);
            $html->set('type', $messageType);
            $data = new stdClass();
            $data->message = $html->fetch('Zt://html/message.php');
            $this->add($data, 'message');
            return $this;
        }

        /**
         * Add execute script
         * @param string $script
         * @return \ZtAjax
         */
        public function addExecute($script)
        {
            return $this->add($script, 'execute');
        }

        /**
         * Do response json data
         */
        public function response()
        {
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($this->_responses);
            exit();
        }

        /**
         * Response empty object and exit
         */
        public function breakResponse()
        {
            echo CrexHelperEncode::jsonEncode(array());
            exit();
        }

    }

}       
