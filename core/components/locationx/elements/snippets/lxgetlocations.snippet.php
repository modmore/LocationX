<?php
/* @var modX $modx
 * @var LocationX $locationx
 * @var array $scriptProperties
 **/
/* Get service and default properties and set properties in the class. */
$corePath = $modx->getOption('locationx.core_path',null,$modx->getOption('core_path').'components/locationx/');
$locationx = $modx->getService('locationx','LocationX', $corePath.'model/');

/* Get all properties */
$defaults = include $corePath.'elements/snippets/properties/lxgetlocations.properties.php';
$scriptProperties = array_merge($defaults, $scriptProperties);
$locationx->setProperties($scriptProperties);

if ($locationx->getProperty('debug')) {
    echo '<h2>Debug: Properties</h2><pre>';
    var_dump($locationx->getProperties());
    echo '</pre>';
}

$placeholders = array(
    'errors' => array(),
);

$query = $modx->newQuery('lxStore');

/* Join relevant tables */
if ($locationx->getProperty('includeCategory', true)) $query->leftJoin('lxCategory','Category');
if ($locationx->getProperty('includeMarker', false)) $query->leftJoin('lxMarker','Marker');

/* Select all fields */
$query->select($modx->getSelectColumns('lxStore', 'lxStore', '', array(), false));
if ($locationx->getProperty('includeCategory', true)) $query->select($modx->getSelectColumns('lxCategory', 'Category', 'category_', array(), false));
if ($locationx->getProperty('includeMarker', false)) $query->select($modx->getSelectColumns('lxCategory', 'Category', 'category_', array(), false));

/* Searches */
$category = $locationx->getProperty('category');
if (count($category) == 1 && ($category[0] != 0))
    $query->where(array('category' => reset($category)));
elseif (count($category) > 1)
    $query->where(array('category:IN' => $category));

if (!$locationx->getProperty('includeInactive', false))
    $query->where(array('active' => true));
if ($locationx->getProperty('includeCategorizedOnly', false))
    $query->where(array('category:!=' => -1));
if ($locationx->getProperty('includeMappedOnly', false))
    $query->where(array('latitude:!=' => '','AND:longitude:!=' => ''));
if ($locationx->getProperty('includeLinkedOnly', false))
    $query->where(array('link:!=' => ''));

$search = $locationx->getProperty('search','');
if (!empty($search)) {
    $search = strip_tags(htmlentities($search));
    $query->where(array(
        'name:LIKE' => "%$query%",
        'OR:address1:LIKE' => "%$query",
        'OR:city:LIKE' => "%$query%",
    ));
}

$searchCity = $locationx->getProperty('searchCity','');
if (!empty($searchCity)) $query->where(array('city:LIKE' => "%$searchCity%"));
$searchState = $locationx->getProperty('searchState','');
if (!empty($searchState)) $query->where(array('state:LIKE' => "%$searchState%"));
$searchCountry = $locationx->getProperty('searchCountry','');
if (!empty($searchCountry)) $query->where(array('country:LIKE' => "%$searchCountry%"));

$searchGeo = $locationx->getProperty('searchGeo');

if (!empty($searchGeo)) {
    $geoCode = $locationx->geoCode($searchGeo);
    $placeholders['geosearch'] = 1;
    if (!isset($geoCode['error'])) {
        $placeholders['geosearch.term'] = (isset($geoCode['formatted_address'])) ? $geoCode['formatted_address'] : $searchGeo;
        $viewport = $geoCode['geometry']['viewport'];

        $query->where(array(
            'latitude:<=' => $viewport['northeast']['lat'],
            'AND:latitude:>=' => $viewport['southwest']['lat'],
        ));
        $query->where(array(
            'longitude:<=' => $viewport['northeast']['lng'],
            'AND:longitude:>=' => $viewport['southwest']['lng'],
        ));

        if ($locationx->getProperty('debug', false)) {
            echo '<img src="http://maps.googleapis.com/maps/api/staticmap?sensor=false&center=' .
            str_replace(',','.',$geoCode['lat']) . ',' . str_replace(',','.',$geoCode['lng']) .
            '&size=325x325&maptype=roadmap&markers=' .
                str_replace(',','.',$geoCode['lat']) . ',' . str_replace(',','.',$geoCode['lng']) .
            '&path=' .
                str_replace(',','.',$viewport['northeast']['lat']) . ',' . str_replace(',','.',$viewport['northeast']['lng']) . '|' .
                str_replace(',','.',$viewport['northeast']['lat']) . ',' . str_replace(',','.',$viewport['southwest']['lng']) . '|' .
                str_replace(',','.',$viewport['southwest']['lat']) . ',' . str_replace(',','.',$viewport['southwest']['lng']) . '|' .
                str_replace(',','.',$viewport['southwest']['lat']) . ',' . str_replace(',','.',$viewport['northeast']['lng']) . '|' .
                str_replace(',','.',$viewport['northeast']['lat']) . ',' . str_replace(',','.',$viewport['northeast']['lng']) .
            '&visible=' .
                str_replace(',','.',$viewport['northeast']['lat']) . ',' . str_replace(',','.',$viewport['northeast']['lng']) . '|' .
                str_replace(',','.',$viewport['northeast']['lat']) . ',' . str_replace(',','.',$viewport['southwest']['lng']) . '|' .
                str_replace(',','.',$viewport['southwest']['lat']) . ',' . str_replace(',','.',$viewport['southwest']['lng']) . '|' .
                str_replace(',','.',$viewport['southwest']['lat']) . ',' . str_replace(',','.',$viewport['northeast']['lng']) .

                '" />';
        }
    } else {
        $placeholders['errors'][] = $geoCode['error'];
    }
} else {
    $placeholders['geosearch'] = 0;
}

/* Apply sorting */
$sort = $modx->fromJSON($locationx->getProperty('sort'));
if (!$sort) { // sort is invalid
    if ($locationx->getProperty('debug', false)) echo 'ERROR: &sort param is invalid JSON, using default value.';
    $sort = array('rank' => 'asc');
}
foreach ($sort as $field => $dir) {
    $query->sortby($field, $dir);
}

/* Get total */
$total = $modx->getCount('lxStore', $query);
$modx->setPlaceholder($locationx->getProperty('totalVar','total'), $total);

if ($locationx->getProperty('debug', false)) {
    $query->prepare();
    echo 'Query: ' . $query->toSQL() . '<br /> Total results: ' . $total ;
}

if ($total < 1) {
    $placeholders['output'] = $locationx->getProperty('noResults');
} else {
    $placeholders['output'] = array();
    /* @var lxStore $store */
    foreach ($modx->getIterator('lxStore', $query) as $store) {
        $phs = $store->toArray('',false, true);
        $placeholders['output'][] = $locationx->getChunk($locationx->getProperty('tplResult'), $phs);
    }
    $placeholders['output'] = implode($locationx->getProperty('resultSeparator',"\n"), $placeholders['output']);
}

$modx->setPlaceholders($placeholders, $locationx->getProperty('placeholderPrefix', 'locationx.'));
return '';
