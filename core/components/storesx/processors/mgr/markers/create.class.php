<?php
class sxMarkerCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'sxMarker';
    public $languageTopics = array('storesx:default');

    public function beforeSet() {
        $this->setCheckbox('flat', true);
        $name = $this->getProperty('name');

        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('storesx.err_ae_name'));
        }
        return parent::beforeSet();
    }
}
return 'sxMarkerCreateProcessor';
