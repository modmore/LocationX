<?php
class lxStoreGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'lxStore';
    public $languageTopics = array('locationx:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'locationx.store';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $c->leftJoin('lxMarker','Marker');
        $c->leftJoin('lxCategory','Category');

        $c->select($this->modx->getSelectColumns('lxStore', 'lxStore', '', array(), false));
        $c->select($this->modx->getSelectColumns('lxMarker', 'Marker', 'gmap_marker_',array('name')));
        $c->select($this->modx->getSelectColumns('lxCategory', 'Category', 'category_',array('name')));

        if ($this->getProperty('category',-1) > 0) {
            $c->where(array(
                'category' => $this->getProperty('category')
            ));
        }

        $query = $this->getProperty('query', '');
        if (!empty($query)) {
            $query = "%$query%";
            $c->where(array(
                'name:LIKE' => $query,
                'OR:address1:like' => $query,
                'OR:address2:like' => $query,
                'OR:city:like' => $query,
                'OR:state:like' => $query,
                'OR:country:like' => $query,
                'OR:contactperson:like' => $query,
            ));
        }
        return $c;
    }
    public function prepareRow(xPDOObject $object) {
        $row = $object->toArray('', false, true);
        return $row;
    }
}
return 'lxStoreGetListProcessor';
