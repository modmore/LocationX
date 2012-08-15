<?php


require_once dirname(dirname(__FILE__)) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modelPath = $modx->getOption('storesx.core_path',null,$modx->getOption('core_path').'components/storesx/').'model/';

$modx->addPackage('storesx',$modelPath);

$manager = $modx->getManager();
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('HTML');
$objects = array(
    'sxStore','sxMarker','sxCategory'
);

foreach ($objects as $obj) {
    $manager->createObjectContainer($obj);
}
echo 'Done';
?>
