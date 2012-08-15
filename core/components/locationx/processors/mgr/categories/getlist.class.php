<?php
class lxCategoryGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'lxCategory';
    public $languageTopics = array('locationx:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';

    public function getData() {
        $data = parent::getData();

        /* When requested for a combo box w/ uncategorized, offer the default category. */
        if (($this->getProperty('id') == -1) || ($this->getProperty('combo') && $this->getProperty('include_uncategorizedd'))) {
            /* @var lxCategory $empty */
            /* Create transient object to represent default */
            $empty = $this->modx->newObject('lxCategory');
            $empty->set('name', $this->modx->lexicon('locationx.uncategorized'));
            $empty->set('id', -1);

            /* Pop it in front of the result set */
            array_unshift($data['results'], $empty);
        }

        /* Return the data. */
        return $data;
    }
}
return 'lxCategoryGetListProcessor';
