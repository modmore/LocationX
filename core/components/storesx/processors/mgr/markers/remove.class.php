<?php

class sxMarkerRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'sxMarker';
    public function beforeRemove() {
        $c = $this->modx->newQuery('sxStore');
        $c->where(array(
            'gmap_marker' => $this->object->get('id')
        ));
        /* @var sxStore $store */
        foreach ($this->modx->getIterator('sxStore', $c) as $store) {
            $store->set('gmap_marker', -1);
            $store->save();
        }
        return parent::beforeRemove();
    }
}
return 'sxMarkerRemoveProcessor';
