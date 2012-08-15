<?php
class sxCategoryGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'sxCategory';
    public $languageTopics = array('storesx:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';

    public function getData() {
        $data = parent::getData();

        /* When requested for a combo box w/ uncategorized, offer the default category. */
        if (($this->getProperty('id') == -1) || ($this->getProperty('combo') && $this->getProperty('include_uncategorizedd'))) {
            /* @var sxCategory $empty */
            /* Create transient object to represent default */
            $empty = $this->modx->newObject('sxCategory');
            $empty->set('name', $this->modx->lexicon('storesx.uncategorized'));
            $empty->set('id', -1);

            /* Pop it in front of the result set */
            array_unshift($data['results'], $empty);
        }

        /* Return the data. */
        return $data;
    }
}
return 'sxCategoryGetListProcessor';
