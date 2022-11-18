<?php

header('Content-Type: application/json');

if(isset($_SERVER['PHP_AUTH_USER'])) {

    $app_monkey_id = $_SERVER['PHP_AUTH_USER'];
    $token = $_SERVER['PHP_AUTH_PW'];
    $APIKEY = 'abc';

    $BANANA_APIKEY_URL = "http://localhost:8080/banana_oauth_app.php";
    $APIKEY = 'abc';
    $FULL_URL = $BANANA_APIKEY_URL . '?apikey=' . $APIKEY;

    $request = array(
        "http" => array(
            "header" => array(
                "Content-Type: application/json",
                "Authorization: Basic " .
                    base64_encode ($app_monkey_id 
                    . ":" . $token)
            ),
            "method" => "GET",
            "protocol_version" => 1.1
        )
    );
    
    $context = stream_context_create($request);
    $data = file_get_contents($FULL_URL, false, $context);
    
    echo $data;

/*
    $bananas = array();
    $bananas['bananas'] = Rand(1, 100);
    $bananas['security'] = "basicauth";

    $json_bananas = json_encode($bananas, JSON_PRETTY_PRINT);
    echo $json_bananas;
*/
} else {

    $error['error'] = "basicauth in oauth failed";
    $error['result'] = $result;
    
    $json = json_encode ($error);
    echo $json;

}