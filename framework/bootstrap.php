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

/* Include JS Framework core */
JHtml::_('bootstrap.framework');
ob_start();
require_once $ztPath->getPath('Zt://assets/js/zt.core.php');
$script = ob_get_contents();
ob_end_clean();
$document = JFactory::getDocument();
$document->addScriptDeclaration($script);

ZtAssets::import(array(
    'Zt://assets/js/zt.ui.js',
    'Zt://assets/js/zt.ajax.js'
));
