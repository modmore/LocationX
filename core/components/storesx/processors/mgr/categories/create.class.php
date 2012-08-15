<?php
class sxCategoryCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sxCategory';
    public $languageTopics = array('storesx:default');

    public function beforeSet() {
        $this->setCheckbox('visible', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ae_name'));
        }
        return parent::beforeSet();
    }
}
return 'sxCategoryCreateProcessor';
