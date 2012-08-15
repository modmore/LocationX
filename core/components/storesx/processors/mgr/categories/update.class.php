<?php
class sxCategoryUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'sxCategory';
    public $languageTopics = array('storesx:default');
    public $objectType = 'storesx.sxstore';

    public function beforeSet() {
        $this->setCheckbox('visible', true);

        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ns_name'));
        } else if ($this->modx->getCount($this->objectType,array('name' => $name, 'AND:id:!=' => $this->object->get('id'))) > 0) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ae_name'));
        }
        return parent::beforeSet();
    }
}
return 'sxCategoryUpdateProcessor';
