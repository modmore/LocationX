<?php

class StoresXHomeManagerController extends StoresXManagerController {
    public function process(array $scriptProperties = array()) {
    }

    public function getPageTitle() {
        return $this->modx->lexicon('storesx');
    }

    public function loadCustomCssJs() {
        $this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/grid.stores.js');
        $this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/window.stores.js');
        $this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/combo.markers.js');
        $this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/combo.categories.js');

        $this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/grid.markers.js');
        $this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/window.markers.js');

        $this->addLastJavascript($this->storesx->config['js_url'].'mgr/sections/home.js');
    }

    public function getTemplateFile() {
        return $this->storesx->config['templates_path'].'home.tpl';
    }
}
