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
    $modx->log(modX::LOG_LEVEL_ERROR,'Error geocoding ' . $address . ': ' . print_r($result, true));
    return $modx->error->failure('Geocoding error: ' . $result['status']);
}
$result = $result['results'][0];

if (isset($result['geometry']) && isset($result['geometry']['location'])) {
    $result['lat'] = $result['geometry']['location']['lat'];
    $result['lng'] = $result['geometry']['location']['lng'];
    return $modx->error->success('', $result);
} else {
    return $modx->error->failure('No results from the Google Geocoding service.');
}
