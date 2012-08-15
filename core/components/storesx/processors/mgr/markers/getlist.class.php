<?php
class sxMarkerGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sxMarker';
    public $languageTopics = array('storesx:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';

    public function getData() {
        $data = parent::getData();

        /* When requested for a combo box, offer the default marker. */
        if ($this->getProperty('combo')) {
            /* Get url to red pin (default */
            $url = $this->modx->getOption('storesx.assets_url', null, $this->modx->getOption('assets_url') . 'components/storesx/');
            $url .= 'img/markers/red.png';
            /* @var sxMarker $empty */
            /* Create transient object to represent default */
            $empty = $this->modx->newObject('sxMarker');
            $empty->set('name', $this->modx->lexicon('storesx.default_marker'));
            $empty->set('image', $url);
            $empty->set('id', -1);

            /* Pop it in front of the result set */
            array_unshift($data['results'], $empty);
        }

        /* Return the data. */
        return $data;
    }
}
return 'sxMarkerGetListProcessor';
