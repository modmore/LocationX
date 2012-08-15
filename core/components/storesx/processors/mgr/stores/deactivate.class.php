<?php
class sxStoreDeactivateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sxStore';
    public $languageTopics = array('storesx:default');
    public $objectType = 'storesx.sxstore';

    public function beforeSet() {
        $this->setProperty('active', false);
        $this->setProperty('updatedon', time());
        return parent::beforeSet();
    }
}
return 'sxStoreDeactivateProcessor';
