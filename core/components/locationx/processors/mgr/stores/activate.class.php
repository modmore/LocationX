<?php
class lxStoreActivateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'lxStore';
    public $languageTopics = array('locationx:default');
    public $objectType = 'locationx.lxstore';

    public function beforeSet() {
        $this->setProperty('active', true);
        $this->setProperty('updatedon', time());
        return parent::beforeSet();
    }
}
return 'lxStoreActivateProcessor';
