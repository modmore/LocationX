<?php
require_once dirname(__FILE__) . '/model/locationx.class.php';

abstract class LocationXManagerController extends modExtraManagerController {
    /** @var LocationX $locationx */
    public $locationx = null;

    public function initialize() {
        $this->locationx = new LocationX($this->modx);

        $this->addJavascript($this->locationx->config['js_url'].'mgr/locationx.class.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            LocationX.config = '.$this->modx->toJSON($this->locationx->config).';
        });
        </script>');

        parent::initialize();
    }

    public function getLanguageTopics() {
        return array('locationx:default');
    }

    public function checkPermissions() {
        return true;
    }
}

class IndexManagerController extends LocationXManagerController {
    public static function getDefaultController() {
        return 'home';
    }
}
