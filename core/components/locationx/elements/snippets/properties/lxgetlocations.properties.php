<?php
return array(
    'debug' => false,
    'apiKey' => '',
    'placeholderPrefix' => 'locationx',

    'allowUrlOverride' => false,
    'allowUrlOverrideProperties' => 'exclude, category, searchName, searchGeo, searchCity, searchState, searchCountry, searchRadius',

    'category' => '',
    'includeInactive' => false,
    'includeCategorizedOnly' => false,
    'includeMappedOnly' => false,
    'includeLinkedOnly' => false,
    'where' => '',
    'exclude' => '',

    'includeMarker' => true,
    'includeCategory' => true,

    'search' => '',
    'searchRadius' => 20,
    'searchRadiusUnit' => 'miles',
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
    'id' => 'lxgl',
    'noResults' => 'Sorry, no matching Locations found.',
    'tplResult' => 'lxgl.result',
    'tplMapMarkup' => 'lxgl.map.markup',
    'tplMapHeadBase' => 'lxgl.map.head_base',
    'tplMapHead' => 'lxgl.map.head',

    'registerCss' => true,
    'registerJqueryHead' => false,
    'registerJqueryFooter' => true,

    'mapDefaultLat' => '',
    'mapDefaultLng' => '',
    'mapType' => 'ROADMAP',

    'mapHeight' => '400px',
    'mapWidth' => '400px;',


);
