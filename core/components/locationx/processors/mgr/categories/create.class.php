<?php
class lxCategoryCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'lxCategory';
    public $languageTopics = array('locationx:default');

    public function beforeSet() {
        $this->setCheckbox('visible', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('locationx.err_ae_name'));
        }
        return parent::beforeSet();
    }
}
return 'lxCategoryCreateProcessor';
