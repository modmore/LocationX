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
    'properties' => $locationx->getProperties(),
);

$query = $modx->newQuery('lxStore');
$query->select($modx->getSelectColumns('lxStore', 'lxStore', '', array(), false));

/* Join relevant tables and select them */
if ($locationx->getProperty('includeCategory', true)) {
    $query->leftJoin('lxCategory','Category');
    $query->select($modx->getSelectColumns('lxCategory', 'Category', 'category_', array(), false));
}
if ($locationx->getProperty('includeMarker', true)) {
    $query->leftJoin('lxMarker','Marker');
    $query->select($modx->getSelectColumns('lxMarker', 'Marker', 'marker_', array(), false));
}


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

        if (is_numeric($locationx->getProperty('searchRadius','')) && $locationx->getProperty('searchRadius','') > 0) {
            $viewportCalculated = $locationx->getFlatBoundingBox($locationx->getProperty('searchRadius',''), $geoCode['lat'], $geoCode['lng']);
            if (is_array($viewportCalculated)) {
                $viewport = array(
                    'northeast' => array(
                        'lat' => $viewportCalculated[1],
                        'lng' => $viewportCalculated[3]
                    ),
                    'southwest' => array(
                        'lat' => $viewportCalculated[0],
                        'lng' => $viewportCalculated[2]
                    )
                );
            }
        }

        $query->where(array(
            'latitude:<=' => $viewport['northeast']['lat'],
            'AND:latitude:>=' => $viewport['southwest']['lat'],
        ));
        $query->where(array(
            'longitude:<=' => $viewport['northeast']['lng'],
            'AND:longitude:>=' => $viewport['southwest']['lng'],
        ));

        $placeholders['bounding_box'] = 'http://maps.googleapis.com/maps/api/staticmap?sensor=false&center=' .
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
                str_replace(',','.',$viewport['southwest']['lat']) . ',' . str_replace(',','.',$viewport['northeast']['lng']);

    } else {
        $placeholders['errors'][] = $geoCode['error'];
    }
} else {
    $placeholders['geosearch'] = 0;
}

/* Apply sorting */
$sort = $modx->fromJSON($locationx->getProperty('sort'));
if (!$sort) { // sort is invalid
    if ($locationx->getProperty('debug', false)) echo 'ERROR: &sort param is invalid JSON, using default value of rank ascending.';
    $sort = array('rank' => 'asc');
}
foreach ($sort as $field => $dir) {
    $query->sortby($field, $dir);
}

/* Get total */
$total = $modx->getCount('lxStore', $query);
$modx->setPlaceholder($locationx->getProperty('totalVar','total'), $total);

/* Apply limits */
$query->limit($locationx->getProperty('limit'), $locationx->getProperty('offset'));

if ($locationx->getProperty('debug', false)) {
    $query->prepare();
    echo 'Query: ' . $query->toSQL() . '<br /> Total results: ' . $total ;
}

$markers = array(
    0 => array(
        'static' => '',
        'image' => '',
        'shadow' => '',
        'size' => '',
        'origin' => '',
        'flat' => '',
        'items' => array(),
    )
);

if ($total < 1) {
    $placeholders['output'] = $locationx->getProperty('noResults');
} else {
    $placeholders['output'] = array();
    /* @var lxStore $store */
    foreach ($modx->getIterator('lxStore', $query) as $store) {
        $phs = $store->toArray('',false, true);
        $placeholders['output'][] = $locationx->getChunk($locationx->getProperty('tplResult'), $phs);

        /* Ensure we always have a valid ID here, 0 being the default. */
        if ($phs['marker_id'] < 1) {
            $phs['marker_id'] = 0;
        }
        if (!isset($markers[$phs['marker_id']])) {
            $markers[$phs['marker_id']] = array(
                'static' => 'icon:' . urlencode($phs['marker_image']),
                'image' => $phs['marker_image'],
                'shadow' => $phs['marker_shadow'],
                'size' => $phs['marker_size'],
                'origin' => $phs['marker_origin'],
                'flat' => $phs['marker_flat'],
                'items' => array(),
            );
        }
        if (!empty($phs['latitude']) && !empty($phs['longitude'])) {
            $markers[$phs['marker_id']]['items'][$phs['id']] = $phs;
        }
    }
    $placeholders['output'] = implode($locationx->getProperty('resultSeparator',"\n"), $placeholders['output']);
}


if ($locationx->getProperty('registerCss', true)) {
    $modx->regClientCSS($locationx->config['css_url'] . 'frontend.css');
}
if ($locationx->getProperty('registerJqueryHead', false)) {
    $modx->regClientStartupScript($locationx->config['js_url'] . 'web/jquery-1.8.1.min.js');
}
if ($locationx->getProperty('registerJqueryFooter', true)) {
    $modx->regClientScript($locationx->config['js_url'] . 'web/jquery-1.8.1.min.js');
}

/* Build the JS map. */
if ($locationx->getProperty('buildGmap', true)) {
    $placeholders['gmaps'] = array();
    $placeholders['gmaps']['markers'] = $modx->toJSON($markers);

    /* Get the main markup for the map */
    $placeholders['gmaps']['map'] = $locationx->getChunk($locationx->getProperty('tplMapMarkup'),array(
        'id' => $locationx->getProperty('id'),
        'width' => $locationx->getProperty('mapWidth'),
        'height' => $locationx->getProperty('mapHeight'),
        ));

    /* Get the base head, only to be included once per page */
    $placeholders['gmaps']['head_base'] = $locationx->getChunk($locationx->getProperty('tplMapHeadBase'),array(
        'id' => $locationx->getProperty('id'),
        'data' => $modx->toJSON($markers),
        'key' => $locationx->getProperty('apiKey',''),
        ));
    if (!$locationx->baseRegistered) {
        $modx->regClientStartupHTMLBlock($placeholders['gmaps']['head_base']);
        $locationx->baseRegistered = true;
    }

    /* Get the head for this map */
    $placeholders['gmaps']['head'] = $locationx->getChunk($locationx->getProperty('tplMapHead'),array(
        'id' => $locationx->getProperty('id'),
        'data' => $modx->toJSON($markers),
        'center_lat' => (isset($geoCode)) ? $geoCode['lat'] : $locationx->getProperty('mapDefaultLat'),
        'center_lng' => (isset($geoCode)) ? $geoCode['lng'] : $locationx->getProperty('mapDefaultLng')
        ));
    $modx->regClientHTMLBlock($placeholders['gmaps']['head']);

}

$modx->toPlaceholders($placeholders, $locationx->getProperty('placeholderPrefix', 'locationx'));
return '';
