<?php

/**
 * {$id}
 */
defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/includes/defines.php';
require_once __DIR__ . '/includes/path.php';

require_once __DIR__ . '/includes/extensions.php';
require_once __DIR__ . '/includes/loader.php';
require_once __DIR__ . '/includes/framework.php';
// Another force just for make sure. It's not make sense but for safety
require_once __DIR__ . '/extension.php';

if (JFactory::getApplication()->input->get('zt_debug') == 1) {
    ZtFramework::restart();
}
/* Register Zt autoloading by Psr2 */
ZtFramework::registerExtension(__DIR__ . '/../extension.json');

spl_autoload_register(array('ZtLoader', 'autoloadZtPsr2'));

/* Include JS Framework core */
JHtml::_('bootstrap.framework');

/* Extension init */
$extension = ZtFramework::getExtension('Zt');
$extension->init();
