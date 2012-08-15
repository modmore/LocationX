<?php

$s = array(
    'cmp_zoom' => 14,
    'cmp_default_zoom' => 16,
    'cmp_default_lat' => '53.006759',
    'cmp_default_long' => '7.192037',
);

$settings = array();

foreach ($s as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $parts = explode('.',$key);
    if (count($parts) == 1) { $area = 'Default'; }
    else { $area = $parts[0]; }
    
    $settings['storesx.'.$key] = $modx->newObject('modSystemSetting');
    $settings['storesx.'.$key]->set('key', 'storesx.'.$key);
    $settings['storesx.'.$key]->fromArray(array(
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'storesx',
        'area' => $area
    ));
}

return $settings;


