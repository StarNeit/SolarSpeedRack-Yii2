<?php

$apiKey = 'XwuJG0ZQoK85CejNNP03spGc7TIGHICQVPuTWStJ';
$address = '2615 Orange Ave, Santa Ana, CA 92707';

$ch = curl_init();

//$url = 'http://developer.nrel.gov/api/solar/data_query/v1.format';
$url = 'http://developer.nrel.gov/api/utility_rates/v3.json';

$url .= '?';

//$url .= "format=json&";
$url .= "api_key={$apiKey}&";
$url .= "address=" . urlencode($address) . '&';

//$url .= "lat={$lat}";
//$url .= "lon={$lon}";
//$url .= "radius=100";
//$url .= "all";


curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

var_dump($url);

$return = curl_exec($ch);

var_dump($return);

var_dump(json_decode($return));

curl_close($ch);