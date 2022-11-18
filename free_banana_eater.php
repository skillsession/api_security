<h1>Free banana eater!</h1>

<?php

$FREE_BANANA_API_URL = "http://localhost:8081/free_banana_api.php";

$data = file_get_contents($FREE_BANANA_API_URL);
$object = json_decode($data);

echo 'I just got ' . $object->bananas 
    . ' bananas from an api, using ' . $object->security
    . ' security';
