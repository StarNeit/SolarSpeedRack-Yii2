<?php

$apiKey = 'XwuJG0ZQoK85CejNNP03spGc7TIGHICQVPuTWStJ';
//$address = '2615 Orange Ave, Santa Ana, CA 92707';

//var_dump($_GET, $_POST, $_ENV, $_SERVER);
//var_dump($_GET);exit;

if(isset($_GET['address'])) {
    $address = urldecode($_GET['address']);
} else {
    $address = '2615 Orange Ave, Santa Ana, CA 92707';
}

//var_dump($address);exit;


$ch = curl_init();

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

//var_dump($url);

$ratesReturn = curl_exec($ch);

//var_dump($ratesReturn);

//var_dump(json_decode($ratesReturn));

curl_close($ch);

unset($ch);



$ch = curl_init();

$url = 'http://developer.nrel.gov/api/pvwatts/v5.json';

$url .= '?';

//$url .= "format=json&";
$url .= "api_key={$apiKey}&";
$url .= "address=" . urlencode($address) . '&';
$url .= "system_capacity=4&";
$url .= "azimuth=180&";
$url .= "tilt=40&";
$url .= "array_type=1&";
$url .= "module_type=1&";
$url .= "losses=10";

//$url .= "lat={$lat}";
//$url .= "lon={$lon}";
//$url .= "radius=100";
//$url .= "all";


curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$returnPvWatts = curl_exec($ch);

curl_close($ch);

?>
<style>

#contain { width:100% }

.containers { float:left; width:49%; border: 1px solid #000000 }

#pvwatts { /* border:1px solid #0000ff */ }

#rates { /* border:1px solid #ff0000 */ }

.clear { clear:both; }

</style>

<form method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>">
	<input name="address" id="address" type="text" value="<?php echo $address ?>">
	<button type="submit">Test</button>
</form>

<hr>

<div id="contain">
<div class='containers' id='pvwatts' style="">
<?php echo nl2br(print_r(json_decode($returnPvWatts), true)) ?>
</div>

<div class='containers' id='rates' style="">
<?php echo nl2br(print_r(json_decode($ratesReturn), true)) ?>
</div>

<div class="clear"></div>

</div>