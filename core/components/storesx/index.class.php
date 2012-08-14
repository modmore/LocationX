<?php
require_once dirname(__FILE__) . '/model/storesx.class.php';

abstract class StoresXManagerController extends modExtraManagerController {
    /** @var StoresX $storesx */
    public $storesx = null;

    public function initialize() {
        $this->storesx = new StoresX($this->modx);

        $this->addJavascript($this->storesx->config['js_url'].'mgr/storesx.class.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            StoresX.config = '.$this->modx->toJSON($this->storesx->config).';
        });
        </script>');

        parent::initialize();
    }

    public function getLanguageTopics() {
        return array('storesx:default');
    }

    public function checkPermissions() {
        return true;
    }
}

class IndexManagerController extends StoresXManagerController {
    public static function getDefaultController() {
        return 'home';
    }
}
