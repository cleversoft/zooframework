<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/includes/defines.php';
require_once __DIR__ . '/includes/path.php';
require_once __DIR__ . '/includes/loader.php';
require_once __DIR__ . '/includes/framework.php';

/* Register Zo2 autoloading by Psr2 */
$ztPath = ZtPath::getInstance();
$ztPath->registerNamespace('Zt', __DIR__);

spl_autoload_register(array('ZtLoader', 'autoloadZtPsr2'));
