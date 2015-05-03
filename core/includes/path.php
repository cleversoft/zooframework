<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

/**
 * Fix JFile requirement
 */
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Class exists checking
 */
if (!class_exists('ZtPath')) {


    /**
     * Used to managed files & folders path by namespaces with override supported
     */
    class ZtPath {

        /**
         * Array of registered namespaces
         * @var array
         */
        protected $_namespaces = array();

        /**
         * 
         * @staticvar ZtPath $instances
         * @param string $name
         * @return \ZtPath
         */
        public static function &getInstance($name = 'zt') {
            static $instances;
            if (!isset($instances[$name])) {
                $instances[$name] = new ZtPath();
            }
            return $instances[$name];
        }

        /**
         * Split classname
         * @param string $className
         * @return array
         */
        public function splitClassname($className) {
            return preg_split('/(?=[A-Z])/', $className, -1, PREG_SPLIT_NO_EMPTY);
        }

        /**
         * 
         * @param string $namespace
         * @param string $path
         * @return \ZtPath
         */
        public function registerNamespace($namespace, $path) {
            if (!isset($this->_namespaces[$namespace])) {
                $this->_namespaces[$namespace] = array();
            }
            array_unshift($this->_namespaces[$namespace], $path);
            return $this;
        }

        /**
         * 
         * @param string $namespace
         * @return array
         */
        public function getNamespace($namespace) {
            if (isset($this->_namespaces[$namespace])) {
                return $this->_namespaces[$namespace];
            } else {
                return array();
            }
        }

        /**
         * 
         * @param string $namespace
         * @param string $path
         * @return boolean|string
         */
        protected function _getPath($namespace, $path) {
            // Find in session
            $namespaces = ZtFramework::getSession('namespaces', array());
            if (isset($namespaces[$namespace])) {
                $extension = ZtFramework::getSession($namespaces[$namespace]);
                $namespaces = $extension->get('paths', array());
            } else {
                if (isset($this->_namespaces[$namespace])) {
                    $namespaces = $this->_namespaces[$namespace];
                } else {
                    $namespaces = array();
                }
            }
            /* Find first exists filePath */
            foreach ($namespaces as $namespace) {
                $physicalPath = $namespace . DIRECTORY_SEPARATOR . $path;

                if (JFile::exists($physicalPath)) {
                    return rtrim(str_replace('/', DIRECTORY_SEPARATOR, $physicalPath), DIRECTORY_SEPARATOR);
                } elseif (JFolder::exists($physicalPath)) {
                    return rtrim(str_replace('/', DIRECTORY_SEPARATOR, $physicalPath), DIRECTORY_SEPARATOR);
                }
            }
        }

        /**
         * 
         * @param string $className
         * @return string|boolean
         */
        public function getPathByClassname($className) {
            $array = $this->splitClassname($className);
            if (count($array) > 1) {
                $prefix = array_shift($array);
                return $this->_getPath($prefix, strtolower(implode(DIRECTORY_SEPARATOR, $array) . '.php'));
            }
            return false;
        }

        /**
         * Get physical path by key
         * @param string $key
         * @return string|boolean
         */
        public function getPath($key) {
            /* Extract key to get namespace and path */
            $parts = explode('://', $key);
            if (is_array($parts) && count($parts) == 2) {
                $namespace = $parts[0];
                $path = $parts[1];
                return $this->_getPath($namespace, $path);
            }
            return false;
        }

        /**
         * Get URL path by key
         * @param string $key
         * @return string|boolean
         */
        public function getUrl($key) {
            /* Extract key to get namespace and path */
            $parts = explode('://', $key);
            if (is_array($parts) && count($parts) == 2) {
                $namespace = $parts[0];
                $path = $parts[1];
                $filePath = $this->_getPath($namespace, $path);
                if ($filePath) {
                    return $this->toUrl($filePath);
                }
            }
            return false;
        }

        /**
         * Convert physical path to URL
         * @param string $path
         * @return string
         */
        public function toUrl($path, $pathOnly = true) {
            $relative = str_replace(JPATH_ROOT, '', $path);
            $relative = trim(JPath::clean($relative, '/'), '/');
            if ($pathOnly) {
                return rtrim(JUri::root(true), '/') . '/' . $relative;
            } else {
                return rtrim(JUri::root(), '/') . '/' . $relative;
            }
        }

    }

}
