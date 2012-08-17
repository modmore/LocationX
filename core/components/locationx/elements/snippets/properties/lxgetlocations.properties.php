<?php
return array(
    'debug' => true,
    'placeholderPrefix' => 'locationx.',

    'allowUrlOverride' => false,
    'allowUrlOverrideProperties' => 'category, searchName, searchGeo, searchCity, searchState, searchCountry, searchDistance',

    'category' => '',
    'includeInactive' => false,
    'includeCategorizedOnly' => false,
    'includeMappedOnly' => false,
    'includeLinkedOnly' => false,
    'where' => '',

    'includeMarker' => false,
    'includeCategory' => true,

    'search' => '',
    'searchGeo' => '',
    'searchCity' => '',
    'searchState' => '',
    'searchCountry' => '',

    /* Pagination */
    'totalVar' => 'total',
    'limit' => 10,
    'offset' => 0,

    /* Sorting */
    'sort' => '{"rank":"asc"}',

    /* Templating */
    'noResults' => 'Sorry, no matching Locations found.',
    'tplResult' => 'lxgl.result'


);
