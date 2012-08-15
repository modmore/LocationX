<?php
class lxStoreCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'lxStore';
    public $languageTopics = array('locationx:default');
    public $objectType = 'locationx.store';

    public function beforeSet() {
        $this->setCheckbox('active', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ae_name'));
        }

        $this->setProperty('createdon', time());
        return parent::beforeSet();
    }
}
return 'lxStoreCreateProcessor';
