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
return 'sxStoreGetListProcessor';
