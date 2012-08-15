<?php
/* @var modX $modx
 * @var array $scriptProperties
 */

$address = $modx->getOption('address', $scriptProperties, '');
if (empty($address)) {
    return $modx->error->failure('Not enough location details available.');
}

/* Google Maps Geocoding URL */
$apiurl = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false';

/* Prepare address to send to Google Maps */
$address = trim(str_replace('  ',' ',$address));

$apiurl .= '&address='.urlencode($address);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$result = $modx->fromJSON($result);
if (!is_array($result)) {
    return $modx->error->failure('Invalid response from Google Geocoding Service');
}

if ($result['status'] != 'OK') {
    return $modx->error->failure('Invalid response or no data available from Google Geocoding Service');
}

$result = $result['results'][0];

if (isset($result['geometry']) && isset($result['geometry']['location'])) {
    $out = array();
    $out['lat'] = $result['geometry']['location']['lat'];
    $out['lng'] = $result['geometry']['location']['lng'];
    return $modx->error->success('', $out);
} else {
    return $modx->error->failure('No results from the Google Geocoding service.');
}
