<?php
class sxStoreCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sxStore';
    public $languageTopics = array('storesx:default');
    public $objectType = 'storesx.store';

    public function beforeSet() {
        $this->setCheckbox('active', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ae_name'));
        }

        $this->setProperty('createdon', time());
        return parent::beforeSet();
    }
}
return 'sxStoreCreateProcessor';
