<?php
class lxCategoryUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'lxCategory';
    public $languageTopics = array('locationx:default');
    public $objectType = 'locationx.lxstore';

    public function beforeSet() {
        $this->setCheckbox('visible', true);

        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ns_name'));
        } else if ($this->modx->getCount($this->objectType,array('name' => $name, 'AND:id:!=' => $this->object->get('id'))) > 0) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ae_name'));
        }
        return parent::beforeSet();
    }
}
return 'lxCategoryUpdateProcessor';
