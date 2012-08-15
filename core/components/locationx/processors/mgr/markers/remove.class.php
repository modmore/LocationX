<?php

class lxMarkerRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'lxMarker';
    public function beforeRemove() {
        $c = $this->modx->newQuery('lxStore');
        $c->where(array(
            'gmap_marker' => $this->object->get('id')
        ));
        /* @var lxStore $store */
        foreach ($this->modx->getIterator('lxStore', $c) as $store) {
            $store->set('gmap_marker', -1);
            $store->save();
        }
        return parent::beforeRemove();
    }
}
return 'lxMarkerRemoveProcessor';
