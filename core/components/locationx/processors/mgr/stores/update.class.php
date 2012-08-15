<?php
class lxStoreUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'lxStore';
    public $languageTopics = array('locationx:default');
    public $objectType = 'locationx.lxstore';

        public function beforeSet() {
        $this->setCheckbox('active', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ns_name'));
        } else if ($this->modx->getCount($this->objectType,array('name' => $name, 'AND:id:!=' => $this->object->get('id'))) > 0) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ae_name'));
        }

        $this->setProperty('updatedon', time());
        return parent::beforeSet();
    }
}
return 'lxStoreUpdateProcessor';
