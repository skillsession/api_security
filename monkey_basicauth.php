<h1>Basic Auth Banana Eater</h1>

<?php

$BANANA_BASICAUTH = "http://localhost:8081/banana_basicauth.php";
$username = "adam";
$password = "mom";

$request = array(
    "http" => array(
        "header" => array(
            "Content-Type: application/json",
            "Authorization: Basic " .
                base64_encode ($username . ":" . $password)
        ),
        "method" => "GET",
        "protocol_version" => 1.1
    )
);

$context = stream_context_create($request);
$data = file_get_contents($BANANA_BASICAUTH, false, $context);

//print_r($data);

$object = json_decode($data);

echo 'I just got ' . $object->bananas 
    . ' bananas from an api, using ' . $object->security
    . ' security';
