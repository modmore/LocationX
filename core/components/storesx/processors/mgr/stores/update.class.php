<?php
class sxStoreUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sxStore';
    public $languageTopics = array('storesx:default');
    public $objectType = 'storesx.sxstore';

        public function beforeSet() {
        $this->setCheckbox('active', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ns_name'));
        } else if ($this->modx->getCount($this->objectType,array('name' => $name, 'AND:id:!=' => $this->object->get('id'))) > 0) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ae_name'));
        }

        $this->setProperty('updatedon', time());
        return parent::beforeSet();
    }
}
return 'sxStoreUpdateProcessor';
