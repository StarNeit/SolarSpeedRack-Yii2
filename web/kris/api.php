<?php

if(isset($_GET['address'])) {
    $address = urldecode($_GET['address']);
} else {
    $address = '2615 Orange Ave, Santa Ana, CA 92707';
}

if(isset($_GET['system_capacity'])) {
    $system_capacity = $_GET['system_capacity'];
} else {
    $system_capacity = 0;
}

if(isset($_GET['azimuth'])) {
    $azimuth = $_GET['azimuth'];
} else {
    $azimuth = 0;
}

if(isset($_GET['tilt'])) {
    $tilt = $_GET['tilt'];
} else {
    $tilt = 0;
}
$array_type = 1;
$module_type = 1;
$losses = 10;
$apiKey = 'XwuJG0ZQoK85CejNNP03spGc7TIGHICQVPuTWStJ';


$ch = curl_init();
$url = 'http://developer.nrel.gov/api/utility_rates/v3.json';
$url .= '?';
//$url .= "format=json&";
$url .= "api_key={$apiKey}&";
$url .= "address=" . urlencode($address) . '&';

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$ratesReturn = curl_exec($ch);
var_dump($ratesReturn);
var_dump(json_decode($ratesReturn));

curl_close($ch);

unset($ch);
?>