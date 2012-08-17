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

class LocationX {
    public $modx;
    public $config = array();
    public $properties = array();
    private $chunks = array();
    public $cacheOptions = array(xPDO::OPT_CACHE_KEY => 'locationx');

    /**
     * Main LocationX constructor for setting up configuration etc.
     *
     * @param \modX $modx
     * @param array $config
     * @return \LocationX
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;
 
        $basePath = $this->modx->getOption('locationx.core_path',$config,$this->modx->getOption('core_path').'components/locationx/');
        $assetsUrl = $this->modx->getOption('locationx.assets_url',$config,$this->modx->getOption('assets_url').'components/locationx/');
        $assetsPath = $this->modx->getOption('locationx.assets_path',$config,$this->modx->getOption('assets_path').'components/locationx/');
        $this->config = array_merge(array(
            'base_bath' => $basePath,
            'core_path' => $basePath,
            'model_path' => $basePath.'model/',
            'processors_path' => $basePath.'processors/',
            'templates_path' => $basePath.'templates/',
            'elements_path' => $basePath.'elements/',
            'assets_path' => $assetsPath,
            'js_url' => $assetsUrl.'js/',
            'css_url' => $assetsUrl.'css/',
            'assets_url' => $assetsUrl,
            'connector_url' => $assetsUrl.'connector.php',

            'cmp_zoom' => $modx->getOption('locationx.cmp_zoom', null, 14),
            'cmp_default_zoom' => $modx->getOption('storex.cmp_default_zoom', null, 16),
            'cmp_default_lat' => $modx->getOption('storex.cmp_default_lat', null, '53.006759'),
            'cmp_default_long' => $modx->getOption('storex.cmp_default_long', null, '7.192037'),

            'zipCacheLifetime' => $modx->getOption('storex.cache.zip.lifetime', null, 0),
        ),$config);

        $this->modx->addPackage('locationx',$this->config['model_path']);
        $this->modx->lexicon->load('locationx:default');
    }

    /**
     * Optional context specific initialization.
     *
     * @param string $ctx Context name
     * @return bool
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
            break;
        }
        return true;
    }

    /**
    * Gets a Chunk and caches it; also falls back to file-based templates
    * for easier debugging.
    *
    * @author Shaun McCormick
    * @access public
    * @param string $name The name of the Chunk
    * @param array $properties The properties for the Chunk
    * @return string The processed content of the Chunk
    */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
            if (empty($chunk)) {
                $chunk = $this->_getTplChunk($name);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
    * Returns a modChunk object from a template file.
    *
    * @author Shaun McCormick
    * @access private
    * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
    * @param string $postFix The postfix to append to the name
    * @return modChunk/boolean Returns the modChunk object if found, otherwise
    * false.
    */
    private function _getTplChunk($name,$postFix = '.tpl') {
        $chunk = false;
        $f = $this->config['elements_path'].'chunks/'.strtolower($name).$postFix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            /* @var modChunk $chunk */
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }

    public function getProperty($key, $default = '') {
        if (in_array($key, $this->properties['allowUrlOverrideProperties']) && $this->properties['allowUrlOverride']) {
            if (isset($_GET[$key]) && !empty($_GET[$key])) return $_GET[$key];
        }
        if (isset($this->properties[$key]) && !empty($this->properties[$key])) return $this->properties[$key];
        return $default;
    }

    public function getProperties() {
        return $this->properties;
    }

    public function setProperties(array $properties = array()) {
        $this->properties = $properties;
        $this->properties['allowUrlOverrideProperties'] = array_map('trim',explode(',',$this->properties['allowUrlOverrideProperties']));
        $this->properties['category'] = explode(',',$this->properties['category']);
    }

    public function geoCode($geoCodeSearch) {
        $cacheKey = 'geocoding/'.md5($geoCodeSearch);
        $data = $this->modx->cacheManager->get($cacheKey,$this->cacheOptions);
        if (true || empty($data)) {
            /* @var modProcessorResponse $result */
            $result = $this->modx->runProcessor('rest/geocode',array(
                'address' => $geoCodeSearch
            ),array(
                'processors_path' => $this->config['processors_path']
            ));

            if ($result->isError()) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,$this->modx->lexicon('locationx.import.error.lat_long',array(
                    'name' => $geoCodeSearch,
                    'message' => $result->getMessage(),
                )));
                $data = array('error' => $result->getMessage());
            } else {
                $data = $result->getObject();
            }
            $this->modx->cacheManager->set($cacheKey, $data, $this->config['zipCacheLifetime'], $this->cacheOptions);
        }
        return $data;
    }

}

