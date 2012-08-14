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
require_once dirname(dirname(__FILE__)) . '/model/storesx.class.php';
$storesx = new StoresX($modx);
$storesx->initialize('mgr');

$modx->regClientStartupHTMLBlock('
<script type="text/javascript">
    Ext.onReady(function() {
        StoresX.config = '.$modx->toJSON($storesx->config).';
    });
</script>');

$modx->regClientStartupScript($storesx->config['js_url'].'mgr/storesx.class.js');

return '<div id="storesx"></div>';
?>
