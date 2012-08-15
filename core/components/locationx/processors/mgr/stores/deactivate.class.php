<?php
class lxStoreDeactivateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'lxStore';
    public $languageTopics = array('locationx:default');
    public $objectType = 'locationx.lxstore';

    public function beforeSet() {
        $this->setProperty('active', false);
        $this->setProperty('updatedon', time());
        return parent::beforeSet();
    }
}
return 'lxStoreDeactivateProcessor';
