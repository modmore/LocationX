<?php

class lxCategoryRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'lxCategory';
    public function beforeRemove() {
        $c = $this->modx->newQuery('lxStore');
        $c->where(array(
            'category' => $this->object->get('id')
        ));
        /* @var lxStore $store */
        foreach ($this->modx->getIterator('lxStore', $c) as $store) {
            $store->set('category', -1);
            $store->save();
        }
        return parent::beforeRemove();
    }
}
return 'lxCategoryRemoveProcessor';
