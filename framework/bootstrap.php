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
$ztPath->registerNamespace('Zt',__DIR__);

//echo '<pre>';
//print_r ($ztPath);
//echo '</pre>';

/* Include JS Framework core */
if(JFactory::getApplication()->input->get('zt.ajax', false) === false){
    JHtml::_('bootstrap.framework');
    ob_start();
    require_once $ztPath->getInstance()->getPath('Zt://assets/js/zt.core.php');
    $script = ob_get_contents();
    ob_end_clean();
    JFactory::getDocument()->addScriptDeclaration($script);
}

spl_autoload_register(array('ZtLoader', 'autoloadZtPsr2'));
