<?php

class StoresXHomeManagerController extends StoresXManagerController {
    public function process(array $scriptProperties = array()) {
    }

    public function getPageTitle() {
        return $this->modx->lexicon('storesx');
    }

    public function loadCustomCssJs() {
        //$this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/panel.home.js');
        //$this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/grid.menu.js');
        //$this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/window.menu.js');
        //$this->addJavascript($this->storesx->config['js_url'].'mgr/widgets/formpanel.menu.js');
        $this->addLastJavascript($this->storesx->config['js_url'].'mgr/sections/home.js');
    }

    public function getTemplateFile() {
        return $this->storesx->config['templates_path'].'home.tpl';
    }
}
