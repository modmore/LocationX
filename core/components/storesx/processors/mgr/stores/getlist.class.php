<?php
class sxStoreGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sxStore';
    public $languageTopics = array('storesx:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'storesx.store';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('sxMarker','Marker');
        $c->leftJoin('sxCategory','Category');

        $c->select($this->modx->getSelectColumns('sxStore', 'sxStore', '', array(), false));
        $c->select($this->modx->getSelectColumns('sxMarker', 'Marker', 'gmap_marker_',array('name')));
        $c->select($this->modx->getSelectColumns('sxCategory', 'Category', 'category_',array('name')));

        if ($this->getProperty('category',-1) > 0) {
            $c->where(array(
                'category' => $this->getProperty('category')
            ));
        }
        return $c;
    }
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        return $row;
    }
}
return 'sxStoreGetListProcessor';
