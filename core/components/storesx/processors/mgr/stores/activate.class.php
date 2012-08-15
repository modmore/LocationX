<?php
class sxStoreActivateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sxStore';
    public $languageTopics = array('storesx:default');
    public $objectType = 'storesx.sxstore';

    public function beforeSet() {
        $this->setProperty('active', true);
        $this->setProperty('updatedon', time());
        return parent::beforeSet();
    }
}
return 'sxStoreActivateProcessor';
