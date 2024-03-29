<?php
/**
 * LocationX
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of LocationX, a real estate property listings component
 * for MODX Revolution.
 *
 * LocationX is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * LocationX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * LocationX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/


if ($object->xpdo) {
    $modx =& $object->xpdo;

    $modelPath = $modx->getOption('locationx.core_path',null,$modx->getOption('core_path').'components/locationx/').'model/';
    $modx->addPackage('locationx',$modelPath);

    $manager = $modx->getManager();

    $objects = array(
        'lxStore','lxMarker','lxCategory'
    );

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            foreach ($objects as $obj) {
                $manager->createObjectContainer($obj);
            }
        break;
    }
}
return true;
