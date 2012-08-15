<?php
/**
 * StoresX
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of StoresX
 *
 * StoresX is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * StoresX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * StoresX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/

$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 0,
    'namespace' => 'storesx',
    'parent' => '0',
    'controller' => 'index',
    'haslayout' => '1',
    'lang_topics' => 'storesx:default',
    'assets' => '',
),'',true,true);

$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text' => 'storesx',
    'parent' => 'components',
    'description' => 'storesx.desc',
    'icon' => 'images/icons/plugin.gif',
    'menuindex' => '10',
    'params' => '',
    'handler' => '',
),'',true,true);
$menu->addOne($action);

$vehicle = $builder->createVehicle($menu,array (
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Action' => array (
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => array ('namespace','controller'),
            xPDOTRANSPORT::RELATED_OBJECTS => false
        ),
    ),
));
$builder->putVehicle($vehicle);
unset ($vehicle,$childActions,$action,$menu);

