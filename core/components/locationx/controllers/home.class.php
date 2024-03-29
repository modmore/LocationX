<?php

class LocationXHomeManagerController extends LocationXManagerController {
    public function process(array $scriptProperties = array()) {
    }

    public function getPageTitle() {
        return $this->modx->lexicon('locationx');
    }

    public function loadCustomCssJs() {
        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/grid.stores.js');
        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/window.stores.js');
        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/combo.markers.js');
        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/combo.categories.js');

        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/grid.markers.js');
        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/window.markers.js');

        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/grid.categories.js');
        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/window.categories.js');

        $this->addJavascript($this->locationx->config['js_url'].'mgr/widgets/window.import.js');

        $this->addLastJavascript($this->locationx->config['js_url'].'mgr/sections/home.js');
    }

    public function getTemplateFile() {
        return $this->locationx->config['templates_path'].'home.tpl';
    }
}
