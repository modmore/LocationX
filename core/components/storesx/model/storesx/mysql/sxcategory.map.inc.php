<?php
/**
 * StoresX
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of StoresX, a real estate property listings component
 * for MODX Revolution.
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
$xpdo_meta_map['sxCategory']= array (
  'package' => 'storesx',
  'version' => '1.1',
  'table' => 'storesx_category',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => 'Unnamed Category',
    'visible' => 1,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '150',
      'phptype' => 'string',
      'null' => false,
      'default' => 'Unnamed Category',
    ),
    'visible' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'boolean',
      'default' => 1,
    ),
  ),
  'aggregates' => 
  array (
    'Stores' => 
    array (
      'class' => 'sxStore',
      'local' => 'id',
      'foreign' => 'category',
      'owner' => 'local',
      'cardinality' => 'many',
    ),
  ),
);
