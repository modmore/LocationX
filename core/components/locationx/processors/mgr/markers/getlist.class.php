<?php
class lxMarkerGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'lxMarker';
    public $languageTopics = array('locationx:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';

    public function getData() {
        $data = parent::getData();

        /* When requested for a combo box, offer the default marker. */
        if ($this->getProperty('combo')) {
            /* Get url to red pin (default */
            $url = $this->modx->getOption('locationx.assets_url', null, $this->modx->getOption('assets_url') . 'components/locationx/');
            $url .= 'img/markers/red.png';
            /* @var lxMarker $empty */
            /* Create transient object to represent default */
            $empty = $this->modx->newObject('lxMarker');
            $empty->set('name', $this->modx->lexicon('locationx.default_marker'));
            $empty->set('image', $url);
            $empty->set('id', -1);

            /* Pop it in front of the result set */
            array_unshift($data['results'], $empty);
        }

        /* Return the data. */
        return $data;
    }
}
return 'lxMarkerGetListProcessor';
