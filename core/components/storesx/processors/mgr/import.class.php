<?php

class sxStoreImportProcessor extends modProcessor {
    public $overwriteStores = false;
    public $autoCreateCategories = true;
    public $getLatLong = false;
    public $raw = '';
    public $xml = null;
    public $data = array();
    public $categories = array();

    public function prepare() {
        $this->modx->request->registerLogging($this->getProperties());
        $this->overwriteStores = (boolean)$this->getProperty('overwrite_stores', false);
        $this->autoCreateCategories = (boolean)$this->getProperty('auto_create_categories', true);
        $this->getLatLong = (boolean)$this->getProperty('get_latlong', false);

        $f = (isset($_FILES['xmlfile'])) ? $_FILES['xmlfile'] : array('name' => '', 'type' => '', 'tmp_name' => '', 'error' => 4, 'size' => 0);
        if (!empty($f['name']) && ($f['size'] > 0) && ($f['error'] == 0) && !empty($f['tmp_name'])) {
            $this->raw = file_get_contents($f['tmp_name']);
            $size = $this->formatSize(strlen($this->raw));
            $this->modx->log(modX::LOG_LEVEL_INFO,$this->modx->lexicon('storesx.import.file_received',array('size' => $size)));
            return true;
        } else {
            return false;
        }
    }

    public function process() {
        if (!$this->prepare() || empty($this->raw)) {
            sleep (2);
            return $this->failure();
        }

        if (!$this->parseXML()) {
            return $this->failure();
        }

        sleep(2);
        return $this->success('COMPLETE');
    }

    public function formatSize($size, $precision = 2) {
        $base = log($size) / log(1024);
        $suffix = array("", "k", "M", "G", "T");
        return round(pow(1024, $base - floor($base)), $precision) . $suffix[floor($base)];
    }

    public function parseXML() {
        $this->modx->log(modX::LOG_LEVEL_INFO,$this->modx->lexicon('storesx.import.parsing_xml'));

        if (!function_exists('simplexml_load_string')) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,$this->modx->lexicon('storesx.import.missing_simplexml'));
            return false;
        }
        $this->xml = simplexml_load_string($this->raw,'SimpleXMLElement');
        if (!$this->xml) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,$this->modx->lexicon('storesx.import.error_parsing_xml'));
            return false;
        }

        if (!isset($this->xml->sxStore)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,$this->modx->lexicon('storesx.import.error_xml_misses_sxstore'));
            return false;
        }

        /* Start looping */
        $total = count($this->xml->sxStore);
        $steps = ceil($total / 15);
        $i = 0;
        $this->modx->log(modX::LOG_LEVEL_INFO,"Import Progress: <span id='{$this->getProperty('topic')}-progress'>0</span> / ".$total);

        /* Give the Console time to receive the progress counter */
        sleep (2);
        foreach ($this->xml->sxStore as $store) {
            $i++;
            $this->importStore($store);
            if (($i % $steps == 0) || ($i == $total)) {
                /* Update our progress counter */
                $this->modx->log(modX::LOG_LEVEL_INFO,'PROGRESS:'.$i);
            }
        }

        return true;
    }

    private function importStore($store) {
        /* @var sxStore $o */
        $o = null;
        if ($this->overwriteStores) {
            $o = $this->modx->getObject('sxStore',(int)$store->id);
        }
        if (!$o) {
            $o = $this->modx->newObject('sxStore');
            $o->set('category', -1);
            $o->set('gmap_marker', -1);
            $o->set('active', true);
        }
        foreach ($store as $key => $value) {
            if (((string)$key == 'id') && !$this->overwriteStores) continue;
            if ((string)$key == 'category') {
                $value = (string)$value;
                if (is_numeric($value)) continue;
                elseif (!empty($value)) $value = $this->getCategoryByName($value);
                else $value = -1;
            }
            $o->set($key, $value);
        }
        if ($this->getLatLong && ($o->get('latitude') == '' || $o->get('longitude') == '')) {
            $this->getLatLong($o);
        }
        $o->save();
    }

    public function getCategoryByName($name) {
        if (empty($name)) return -1;

        if (isset($this->categories[urlencode($name)])) {
            return $this->categories[urlencode($name)];
        }

        /* @var sxCategory $o */
        $o = $this->modx->getObject('sxCategory',array('name' => $name));
        if (!$o && $this->autoCreateCategories) {
            $o = $this->modx->newObject('sxCategory', array('name' => $name, 'visible' => true));
            $o->save();
        }
        if ($o) {
            return $this->categories[urlencode($name)] = $o->get('id');
        }
        return -1;
    }

    private function getLatLong(sxStore $o) {
        $address = implode(' ',$o->get(array('address1','address2','city','zip','state','country')));
        $address = str_replace('  ',' ', $address);
        /* @var modProcessorResponse $result */
        $result = $this->modx->runProcessor('rest/geocode',array(
            'address' => $address
        ),array(
            'processors_path' => $this->modx->storesx->config['processors_path']
        ));

        if ($result->isError()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,$this->modx->lexicon('storesx.import.error.lat_long',array(
                'name' => $o->get('name'),
                'message' => $result->getMessage(),
            )));
            return;
        }
        $opts = $result->getObject();
        $o->set('latitude', $opts['lat']);
        $o->set('longitude', $opts['lng']);
    }
}
return 'sxStoreImportProcessor';
