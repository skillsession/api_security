<h1>Monkeysite Apikey User!</h1>

<?php

$BANANA_APIKEY_URL = "http://localhost:8081/banana_apikey.php";
$APIKEY = 'abc';
$FULL_URL = $BANANA_APIKEY_URL . '?apikey=' . $APIKEY;

$data = file_get_contents($FULL_URL);
$object = json_decode($data);

echo 'I just got ' . $object->bananas 
    . ' bananas from an api, using ' . $object->security
    . ' security';
