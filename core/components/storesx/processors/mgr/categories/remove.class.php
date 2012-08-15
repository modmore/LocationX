<?php

class sxCategoryRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'sxCategory';
    public function beforeRemove() {
        $c = $this->modx->newQuery('sxStore');
        $c->where(array(
            'category' => $this->object->get('id')
        ));
        /* @var sxStore $store */
        foreach ($this->modx->getIterator('sxStore', $c) as $store) {
            $store->set('category', -1);
            $store->save();
        }
        return parent::beforeRemove();
    }
}
return 'sxCategoryRemoveProcessor';
